<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\common\useCases;

use t2cms\user\common\models\AuthItem;
use t2cms\user\common\repositories\PermissionRepository;

/**
 * Description of UserService
 *
 * @author Koperdog <koperdog.dev@github.com>
 */
class RoleService 
{
    private $permissionRepository;
    
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository     = $permissionRepository;
    }
    
    public function save(AuthItem $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->permissionRepository->save($model);
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
            $this->permissionRepository->delete($model);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
}