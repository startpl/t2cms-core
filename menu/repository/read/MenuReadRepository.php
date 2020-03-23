<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\repository\read;

use t2cms\menu\models\Menu;

/**
 * Description of MenuRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuReadRepository 
{
    
    public static function get(int $id): ?array
    {
        return Menu::find()->where(['id' => $id])->asArray()->one();
    }
    
    public static function getByName(string $name): ?array
    {
        return Menu::find()->where(['name' => $name])->asArray()->one();
    }
}
