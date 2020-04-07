<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\common\repositories;

use t2cms\user\common\models\AuthItem;
use t2cms\user\common\models\AuthItemChild;

/**
 * Description of RoleRepository
 *
 * @author Koperdog <koperdog.dev@github.com>
 */
class RoleRepository extends \yii\base\BaseObject
{
    
    public function get(string $name): AuthItem
    {
        if(!$model = AuthItem::find()
                ->where(['name' => $name, 'type' => AuthItem::ROLE_TYPE])
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
    
    public function assignMiltiple(array $data, string $permissionName): bool
    {
        foreach($data as $role){
            $this->assignPermission($role, $permissionName);
        }
        
        return true;
    }
    
    public function removeMiltiple(array $data, string $permissionName): bool
    {
        foreach($data as $role){
            $this->removePermission($role, $permissionName);
        }
        
        return true;
    }
    
    public function assignPermission(string $roleName, string $permissionName): bool
    {
        $item = new AuthItemChild([
            'parent' => $permissionName,
            'child'  => $roleName
        ]);

        if(!$item->save()){
            throw new \RuntimeException("Error assign permission role");
        }
            
        return true;
    }
    
    public function removePermission(string $roleName, string $permissionName): bool
    {
        $item = AuthItemChild::find()
                ->where(['parent' => $permissionName, 'child' => $roleName])
                ->one();

        if(!$item->delete()){
            throw new \RuntimeException("Error remove permission role");
        }
        
        return true;
    }
    
    public static function getAll(): ?array
    {
        return AuthItem::find()->where(['type' => AuthItem::ROLE_TYPE])->all();
    }
}
