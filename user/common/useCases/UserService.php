<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\common\useCases;

use t2cms\user\backend\forms\UserForm;
use t2cms\user\common\models\User;


/**
 * Description of UserService
 *
 * @author Koperdog <koperdog.dev@github.com>
 */
class UserService 
{
    
    public function save(UserForm $form, User $user): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $user->load($form->attributes, '');
            $this->setRole($user->id, $form->role);
            
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function setRole(int $userId, string $role): bool
    {
        \Yii::$app->authManager->revokeAll($userId);
        
        $newRole = \Yii::$app->authManager->getRole($role);
        if(!\Yii::$app->authManager->assign($newRole, $userId)){
            throw new RuntimeException("Can not set role user");
        }
        
        return true;
    }
}
