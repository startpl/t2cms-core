<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\repository;

use t2cms\menu\models\Menu;
use yii\db\ActiveRecord;

/**
 * Description of MenuRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuRepository 
{
    
    public function get(int $id): ActiveRecord
    {
        if(!$model = Menu::find($id)){
            throw new \DomainException("Menu with id: {$id} was not found");
        }
        
        return $model;
    }
    
    public function save(Menu $model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException('Error saving model');
        }
        
        return true;
    }
    
}
