<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\repository;

use yii\db\ActiveRecord;
use t2cms\menu\models\MenuItem;

/**
 * Description of MenuItemRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuItemRepository 
{
    public function get(int $id): ActiveRecord
    {
        if(!$model = MenuItem::find($id)){
            throw new \DomainException("Menu with id: {$id} was not found");
        }
        
        return $model;
    }
    
    public function save($model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException('Error saving model');
        }
        
        return true;
    }
    
    public function appendTo(MenuItem $model): bool
    {
        $parent = $this->get($model->parent_id);
        
        if(!$model->appendTo($parent)){
            throw new \RuntimeException("Error append model");
        }
        
        return true;
    }
    
    public function makeRoot(MenuItem $model): bool
    {
        if(!$model->makeRoot()){
            throw new \RuntimeException("Error Make Root menu model");
        }
        
        return true;
    }
}
