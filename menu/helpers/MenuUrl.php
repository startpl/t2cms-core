<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\helpers;

use t2cms\menu\models\MenuItem;
use t2cms\module\services\ModuleMenuFacade;

/**
 * Description of MenuHelper
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuUrl{
    
    public static function to($item, $absolute = false, $scheme = false): string
    {
        if($item instanceOf MenuItem){
            $item = \yii\helpers\ArrayHelper::toArray($item);
        }
        
        switch($item['type']){
            case MenuItem::TYPE_BLOG_PAGE:
                $url = ['blog/page', 'id' => $item['data']];
                break;
            case MenuItem::TYPE_BLOG_CATEGORY:
                $url = ['blog/category', 'id' => $item['data']];
                break;
            case MenuItem::TYPE_MODULE:
                $url = ['/' . ModuleMenuFacade::getModuleUrl($item['data'])];
                break;
            case MenuItem::TYPE_URI:
            default:
                $url = $item['data'];
                break;
        }
        
        if(!is_array($url)) return $url;
        
        return $absolute? 
                \Yii::$app->urlManagerFrontend->createAbsoluteUrl($url, $scheme)
                : \Yii::$app->urlManagerFrontend->createUrl($url, $scheme);
    }
    
}
