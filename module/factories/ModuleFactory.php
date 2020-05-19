<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\module\factories;

use t2cms\module\dto\ModuleDTO;

/**
 * Description of ModuleFactory
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
abstract class ModuleFactory 
{
    public static function getModuleDTO(array $config): ModuleDTO
    {
        $module = new ModuleDTO();
        
        $module->path           = $config['path'];
        $module->url            = $config['url'];
        $module->name           = $config['name'];
        $module->description    = $config['description'];
        $module->version        = $config['version'];
        $module->currentVersion = $config['currentVersion'];
        $module->author         = $config['author'];
        $module->status         = $config['status'];
        $module->fa_icon        = $config['fa_icon'];
        
        $module->namespace      = $config['namespace'];
        
        $module->show_in_menu = $config['show_in_menu'];
                
        return $module;
    }
}
