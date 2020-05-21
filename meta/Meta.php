<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\meta;

/**
 * Meta helper, replace variables in text to settings 
 * example: 'current city [[city]]', [[city]] will be replace by the current City variable from Settings
 * 
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class Meta
{
    public static function t(string $text)
    {        
        return preg_replace_callback(
            '/\[\[[\w\-]+\]\]/', 
            function($matches) {
                return \Yii::$app->settings->get(trim($matches[0], '[]'));
            }, 
            $text
        );
    }
}
