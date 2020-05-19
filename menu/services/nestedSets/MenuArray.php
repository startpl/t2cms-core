<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\services\nestedSets;

use t2cms\menu\helpers\MenuHelper;
use \startpl\yii2NestedSetsMenu\base\NestedSetsTree;
use t2cms\sitemanager\components\{
    Domains,
    Languages
};

/**
 * Description of MenuArray
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuArray 
{
    private static $strategy;
    
    static function getItems(string $name, NestedSetsTreeMenu $strategy = null)
    {
        if($strategy) self::setStrategy ($strategy);
        
        $collection = MenuHelper::getByName($name, Domains::getEditorDomainId(), Languages::getEditorLangaugeId());
        
        $menu = [];

        if($collection){
            $nsStrategy = self::getCurrentStrategy();
            $menu = $nsStrategy->tree($collection);
        }
        return $menu;
    }
    
    public static function setStrategy(NestedSetsTree $strategy)
    {
        self::$strategy = $strategy;
    }
    
    public static function getCurrentStrategy(): NestedSetsTree
    {
        if(self::$strategy === null) {
            self::$strategy = new NSTreeMenu();
        }
        
        return self::$strategy;
    }
}
