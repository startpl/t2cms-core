<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\module;

use yii\helpers\ArrayHelper;
use t2cms\module\services\ModuleService;
use t2cms\module\dto\ModuleDTO;
use t2cms\base\helpers\ConfigHelper;

/**
 * Description of ModuleBootstrap
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ModuleBootstrap implements \yii\base\BootstrapInterface
{
    private $service;
    private $app;
    private $appId;
    
    const COMMON   = 'common';
    const BACKEND  = 'backend';
    const MODULE_MANAGER = 'module';
    
    public function __construct(ModuleService $service) 
    {        
        $this->service = $service;
    }
    
    public function bootstrap($app)
    {
        $this->app   = $app;
        $this->appId = end(explode('-', $app->id));
        
        $modules = $this->service->getAllActive();
        
        foreach($modules as $module){
            $this->bootstrapModule($app, $module);
            $this->connectModule($module);
        }
    }
    
    private function connectModule(ModuleDTO $module)
    {       
        $app = $this->appId == self::BACKEND? $this->app->getModule(self::MODULE_MANAGER) : $this->app;
        if(!$this->setModule($app, $module, self::COMMON)){
            $this->setModule($app, $module, $this->appId);
        }
    }
    
    private function bootstrapModule($app, ModuleDTO $module)
    {   
        if(!file_exists(\Yii::getAlias('@modules/'.$module->path.'/Bootstrap.php'))) return;
        try {
            $bootstrapName = $module->namespace . '\Bootstrap';
            $moduleBoot = new $bootstrapName;
            $moduleBoot->bootstrap($app);
        } catch(\Exception $e) {
            
        }
    }
    
    private function setModule(\yii\base\Module $parent, ModuleDTO $module, string $appId = 'frontend'): bool
    {   
        $path = \Yii::getAlias('@modules').'/'.$module->path . '/' . $appId;
        
        $moduleClass  = $module->namespace. '\\' . $appId .'\\' . 'Module';                
        $modulePath   = $path . '/Module.php';
        $moduleConfig = ConfigHelper::get($path . '/config/main.php');
    
        if(file_exists($modulePath)){
            $parent->setModule(
                $module->url, 
                ArrayHelper::merge(['class' => $moduleClass], $moduleConfig)
            );
            
            return true;
        }
        
        return false;
    }
}
