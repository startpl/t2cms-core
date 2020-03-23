<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\services\nestedSets;

use t2cms\menu\helpers\MenuHelper;
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
class MenuArray {
    static function getItems(string $name)
    {
        $collection = MenuHelper::getByName($name, Domains::getEditorDomainId(), Languages::getEditorLangaugeId());
        
        $menu = [];

        if($collection){
            $nsTree = new NestedSetsTreeMenu();
            $menu = $nsTree->tree($collection);
        }
        return $menu;
    }
}
