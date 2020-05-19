<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\module\helpers;

/**
 * Description of ModuleHelper
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ModuleHelper 
{
    private static $moduleService;
    
    public static function getAllActive(): ?array 
    {
        return self::getModuleServiceInstance()->getAllActive();
    }
    
    private static function getModuleServiceInstance()
    {
        if(!self::$moduleService) {
            self::$moduleService = \Yii::createObject('\t2cms\module\services\ModuleService');
        }
        
        return self::$moduleService;
    }
}
