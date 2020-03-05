<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\blog\services\nestedSets;

use t2cms\blog\models\Category;
use t2cms\sitemanager\components\{
    Domains,
    Languages,
};

/**
 * Description of MenuArray
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuArray {
    static function getData()
    {

        $collection = \t2cms\blog\helpers\CategoryHelper::getAll(Domains::getEditorDomainId(), Languages::getEditorLangaugeId());
        
        $menu = [];

        if($collection){
            $nsTree = new NestedSetsTreeMenu();
            $menu = $nsTree->tree($collection);
        }
        
        $path = \Yii::$app->request->get();
        
        $url = ['PageSearch' => ['category' => Category::ROOT_ID]];
        $default = [
            'url' => \yii\helpers\ArrayHelper::merge(\Yii::$app->request->queryParams, $url),
            'label' => \Yii::t('nsblog', 'No Category'),
            'active' => ($path['PageSearch']['category'] == Category::ROOT_ID)
        ];
        
        array_unshift($menu, $default);

        return $menu;
    }
}
