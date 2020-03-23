<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\helpers;

use t2cms\menu\repository\read\{
    MenuItemReadRepository,
    MenuReadRepository
};

/**
 * Description of MenuHelper
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuHelper {
    
    public static function getById(int $menuId, $domain_id = null, $language_id = null): ?array
    {
        $menuRoot = MenuItemReadRepository::getRoot($menuId);
        return MenuItemReadRepository::getItemsByMenu($menuRoot, $domain_id, $language_id);
    }
    
    public static function getByName(string $name, $domain_id = null, $language_id = null): ?array
    {
        $menu = MenuReadRepository::getByName($name);
        
        $menuRoot = MenuItemReadRepository::getRoot($menu['id']);
        return MenuItemReadRepository::getItemsByMenu($menuRoot, $domain_id, $language_id);
    }
}
