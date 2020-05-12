<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\common\useCases;

use yii\helpers\ArrayHelper;
use t2cms\user\common\models\AuthItem;
use t2cms\user\common\repositories\{
    RoleRepository
};

/**
 * Description of UserService
 *
 * @author Koperdog <koperdog.dev@github.com>
 */
class RoleService 
{
    private $roleRepository;
    
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository     = $roleRepository;
    }
    
    public function save(AuthItem $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->roleRepository->save($model);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function delete(AuthItem $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->roleRepository->delete($model);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function assignPermissions(array $post, array $permissions, array $roles): bool
    {        
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            foreach($permissions as $permission){
                $data = array_keys(array_filter($post[$permission->name]));
                
                $parentRoles = ArrayHelper::getColumn($permission->parents, 'name');

                $newRoles    = array_diff($data, $parentRoles);
                $deleteRoles = array_diff($parentRoles, $data);
                                
                $this->roleRepository->assignMiltiple($newRoles, $permission->name);
                $this->roleRepository->removeMiltiple($deleteRoles, $permission->name);
            }
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function createRoles(array $roles): bool
    {
        foreach($roles as $role) {
            $item = new AuthItem([
                'type' => AuthItem::ROLE_TYPE,
                'name' => $role['name'],
                'description' => $role['description']
            ]);
            
            if(!$this->save($item)) {
                return false;
            }
        }
        
        return true;
    }
}
