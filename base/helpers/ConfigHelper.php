<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\base\helpers;

/**
 * Description of ConfigHelper
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ConfigHelper 
{
    public static function get(string $path): array
    {
        $result = [];
        
        if(file_exists($path))
        {
            $result = require $path;
        }
        
        if(!is_array($result)){
            throw new \DomainException("file: {$path} does not return an array");
        }
        
        return $result;
    }
}
