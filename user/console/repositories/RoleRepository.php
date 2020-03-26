<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\console\repositories;

use Yii;
use yii\rbac\Role;

/**
 * Description of RoleRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class RoleRepository 
{
    
    public function createRole(string $name, string $description = ''): Role
    {
        $role = Yii::$app->authManager->createRole($name);
        $role->description = $description;
        
        return $role;
    }
    
    public function addRole(Role $role): bool
    {
        if(!Yii::$app->authManager->add($role)){
            throw new \RuntimeException("Error add role: {$role->name}");
        }
        
        return true;
    }
    
}
