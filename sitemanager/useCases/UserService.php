<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\sitemanager\useCases;

use t2cms\sitemanager\repositories\LanguageRepository;

/**
 * Description of UserService
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class UserService 
{
    public static function setLanguage(string $code): bool
    {
        if(!LanguageRepository::existsByCode($code)) return false;
        
        try{
            \Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name'   => 'language',
                'value'  => $code,
                'expire' => time()+(60*60*24*30)
            ]));
        } catch (\Exception $e) {
            return false;
        }
        
        return true;
    }
}
