<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\module\services;

/**
 * Description of ModuleMenuFacade
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ModuleMenuFacade
{
    private static $moduleService;
    
    public static function getModulesToMenu()
    {        
        $modules = self::getModuleServiceInstance()->getAllToShowMenu();
        
        $items = [];
        foreach($modules as $module) {
            $items[] = [
                'label' => \Yii::t('app', $module->name),
                'icon' => $module->fa_icon,
                'url' => ['/module/' . $module->url]
            ];
        }
        
        return $items;
    }
    
    public static function getModuleUrl($path): ?string
    {
        if(!$module = self::getModuleServiceInstance()->getModule($path)) {
            return null;
        }
        
        return $module->url;
    }
    
    private static function getModuleServiceInstance()
    {
        if(!self::$moduleService) {
            self::$moduleService = \Yii::createObject('\t2cms\module\services\ModuleService');
        }
        
        return self::$moduleService;
    }
}
