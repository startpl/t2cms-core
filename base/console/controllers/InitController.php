<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\console\controllers;

use yii\console\Controller;
use t2cms\user\common\useCases\RoleService;
use t2cms\user\common\useCases\PermissionService;

/**
 * Description of DefaultController
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class InitController extends Controller 
{
    private $roleService;
    private $permissionService;
    
    public function __construct(
        $id, 
        $module, 
        RoleService $roleService, 
        PermissionService $permissionService,
        $config = array()
    )
    {
        parent::__construct($id, $module, $config);
        
        $this->roleService       = $roleService;
        $this->permissionService = $permissionService;
    }
    
    public function actionIndex()
    {
        $roles = \t2cms\user\common\enums\UserRoles::ROLES;
        
        $permissions = \t2cms\user\common\enums\UserPermissions::PERMISSIONS;
        
        if(
            $this->roleService->createRoles($roles)
            && $this->permissionService->createPermissions($permissions)){
            echo 'success';
        } else {
            echo 'error';
        }
    }
    
    public function actionMakeAdmin()
    {
        $userRole = \Yii::$app->authManager->getRole('admin');
        \Yii::$app->authManager->assign($userRole, 1);
        
        echo 'success';
    }
        
}
