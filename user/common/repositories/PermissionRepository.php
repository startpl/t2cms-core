<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\common\repositories;

use t2cms\user\common\models\AuthItem;

/**
 * Description of PermissionRepository
 *
 * @author Koperdog <koperdog.dev@github.com>
 */
class PermissionRepository extends \yii\base\BaseObject
{
    
    public function get(string $name): AuthItem
    {
        if(!$model = AuthItem::find()
                ->where(['name' => $name, 'type' => AuthItem::PERMISSION_TYPE])
                ->one()
        ){
            throw new \DomainException("Role with name: {$name} does not exists");
        }
        
        return $model;
    }
    
    public function save(AuthItem $model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException("Error save");
        }
        
        return true;
    }
    
    public function delete(AuthItem $model): bool
    {
        if(!$model->delete()){
            throw new \RuntimeException("Error delete");
        }
        
        return true;
    }
    
    public static function getAll(): ?array
    {
        return AuthItem::find()
                ->with('children')
                ->where(['type' => AuthItem::PERMISSION_TYPE])
                ->all();
    }
}
