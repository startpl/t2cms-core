<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\base\console\controllers;

use yii\console\Controller;
use yii\helpers\Console;

/**
 * Init
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class InitController extends Controller 
{    
    const MIGRATION_PATH = '';
    const MIGRATIONS = [
        '@vendor/startpl/t2cms-core/sitemanager/migrations',
        '@vendor/startpl/t2cms-core/module/migrations',
        '@vendor/startpl/t2cms-core/menu/migrations',
        '@vendor/startpl/t2cms-blog/migrations',
        '@modules/t2cms-acf/backend/migrations',
    ];
    
    private $migration;
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        
        $this->migration = new \yii\console\controllers\MigrateController('migrate', \Yii::$app);
    }
    
    public function actionIndex()
    {        
        $this->initRBAC();
        
        foreach(self::MIGRATIONS as $path) {
            $this->migration->runAction('up', ['migrationPath' => self::MIGRATION_PATH . $path, 'interactive' => false]);   
        }
        
        
        
        $this->stdout("SUCCESS INIT T2CMS." . PHP_EOL, Console::BG_GREEN, Console::FG_BLACK);
    }
    
    private function initRBAC() 
    {
        $this->migration->runAction('up', ['migrationPath' => '@yii/rbac/migrations/', 'interactive' => false]);
        
        $roleService       = \Yii::createObject('\t2cms\user\common\useCases\RoleService');
        $permissionService = \Yii::createObject('\t2cms\user\common\useCases\PermissionService');
        $roleRepository    = \Yii::createObject('\t2cms\user\common\repositories\RoleRepository');
        
        $user = new \t2cms\user\console\controllers\InitController(
                'user', 
                \Yii::$app,
                $roleService,
                $permissionService,
                $roleRepository
        );
        $user->runAction('index');
        $user->runAction('init-assignments');
        $user->runAction('create-admin');
    }
        
}
