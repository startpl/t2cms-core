<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\useCases;

use t2cms\menu\models\{
    forms\MenuItemForm,
    MenuItem,
    MenuItemContent
};

/**
 * Description of menuService
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuItemService 
{
    private $menuItemRepository;
    
    public function __construct(
        \t2cms\menu\repository\MenuItemRepository $menuItemRepository
    )
    {
        $this->menuItemRepository = $menuItemRepository;
    }
    
    public function getItemsByMenuId(int $id, $domain_id = null, $language_id = null): ?array
    {
        try{
            $menuRoot = $this->menuItemRepository->getRoot($id);
            $models   = $this->menuItemRepository->getItemsByMenu($menuRoot, $domain_id, $language_id);
        } catch(\Exception $e) {
            return null;
        }
        
        return $models;
    }
    
    public function create(MenuItemForm $form, int $id): ?MenuItem
    {
        $model = new MenuItem([
            'type'      => $form->type,
            'data'      => $form->data,
            'parent_id' => $form->parent_id,
            'status'    => $form->status,
            'target'    => $form->target,
            'access'    => $form->access,
            'render_js' => $form->render_js,
            'image'     => $form->image,
            'menu'      => $id,
        ]);
        
        $itemContent = new MenuItemContent([
            'name' => $form->itemContent->name
        ]);
        
        if(empty($model->parent_id)){
            $menu = $this->menuItemRepository->getRoot($id);
            $model->parent_id = $menu->id;
        }
                
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->menuItemRepository->appendTo($model);
            $this->menuItemRepository->link('item', $model, $itemContent);
            $transaction->commit();
        } catch (\Exception $e) {            
            debug($e);
            $transaction->rollBack();
            return null;
        }
        
        return $model;
    }
    
    public function update(MenuItem $model, $domain_id = null, $language_id = null): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            if($model->getDirtyAttributes(['parent_id']) && ($model->id != $model->parent_id)){
                if(empty($model->parent_id)){
                    $menu = $this->menuItemRepository->getRoot($model->menu);
                    $model->parent_id = $menu->id;
                }
                $this->menuItemRepository->appendTo($model);
            }
            else{
                $this->menuItemRepository->save($model);
            }
            $this->menuItemRepository->saveContent($model->itemContent, $domain_id, $language_id);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function delete(MenuItem $model): bool
    {        
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->menuItemRepository->delete($model);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function sort(array $data): int
    {
        $result = 0;
        
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $parentNode = $this->menuItemRepository->getParentNodeById($data[0]);
            
            foreach($data as $index => $value){
                $item = $this->menuItemRepository->get($value);
                $this->menuItemRepository->setPosition($item, $parentNode);
                                
                $result++;
            }
            
            $transaction->commit();
        } catch(\Exception $e){
            debug($e);
            $transaction->rollBack();
            return 0;
        }
        
        return $result;
    }
}
