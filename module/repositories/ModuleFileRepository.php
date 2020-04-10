<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\module\repositories;

use yii\helpers\FileHelper;

/**
 * Description of ModuleRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ModuleFileRepository 
{
    const MODULE_INFO_FILE = 'module_info.php';
    
    private $pathModules;
    
    public function __construct()
    {
        $this->pathModules = \Yii::getAlias('@modules');
    }
    
    public function getByPath(string $path): string
    {
        return $this->pathModules . DIRECTORY_SEPARATOR . $path;
    }
    
    public function getModuleInfo(string $path): array
    {
        $infoFile = $this->getByPath($path) . DIRECTORY_SEPARATOR . self::MODULE_INFO_FILE;
        
        $info = require $infoFile;
        $info['path'] = $path;
        
        return $info;
    }
    
    public function getAll(): ?array
    {       
        $directories = FileHelper::findDirectories($this->pathModules, ['recursive' => false]);
        
        foreach($directories as &$dir){
            $dir = str_replace($this->pathModules.DIRECTORY_SEPARATOR, '', $dir);
        }
        
        return $directories;
    }
}
