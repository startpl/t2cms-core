<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\useCases;

use t2cms\menu\models\forms\MenuItemForm;
use t2cms\menu\models\MenuItem;

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
    
    public function getItemsByMenuId(int $id): ?array
    {
        try{
            $menuRoot = $this->menuItemRepository->getRoot($id);
            $models   = $menuRoot->children()->all();            
        } catch(\Exception $e) {
            return null;
        }
        
        return $models;
    }
    
    public function create(MenuItemForm $form): ?MenuItem
    {
        $menuItem = new MenuItem([
            'name'      => $form->name,
            'type'      => $form->type,
            'data'      => $form->data,
            'parent_id' => $form->parent_id,
            'status'    => $form->status,
            'target'    => $form->target
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->menuItemRepository->save($menuItem);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return null;
        }
        
        return $menuItem;
    }
    
    public function update(MenuItem $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->menuItemRepository->save($model);
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
}
