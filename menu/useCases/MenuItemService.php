<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\useCases;

use t2cms\menu\models\forms\MenuForm;
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
    
    public function create(MenuForm $form): ?Menu
    {
        return new Menu();
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
