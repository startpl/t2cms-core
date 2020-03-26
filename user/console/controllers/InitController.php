<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\console\controllers;

use yii\console\Controller;
use yii\helpers\Console;
use t2cms\user\console\useCases\RoleService;

/**
 * Description of DefaultController
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class InitController extends Controller 
{
    private $roleService;
    
    public function __construct($id, $module, RoleService $roleService, $config = array()) {
        parent::__construct($id, $module, $config);
        
        $this->roleService = $roleService;
    }
    
    public function actionIndex()
    {
        $roles = require __DIR__ . '/../' . 'config/roles.php';
        
        if($this->roleService->createRoles($roles)){
            echo 'success';
        } else {
            echo 'error';
        }
    }
    
}
