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
        if(!file_exists($infoFile)){
            throw new \DomainException("Module with path: {$path} does not exists");
        }
        
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
    
    public function install(\t2cms\module\dto\ModuleDTO $module): bool
    {
        $class = $module->namespace . '\\' . 'ModuleInstall';
        $installClass = new $class();
        if(!$installClass->install()){
            throw new \RuntimeException("Error install module: {$module->name}");
        }
        
        return true;
    }
    
    public function uninstall(\t2cms\module\dto\ModuleDTO $module): bool
    {
        $class = $module->namespace . '\\' . 'ModuleInstall';
        $installClass = new $class();
        if(!$installClass->uninstall()){
            throw new \RuntimeException("Error uninstall module: {$module->name}");
        }
        
        return true;
    }
    
    public function activate(\t2cms\module\dto\ModuleDTO $module): bool
    {
        $class = $module->namespace . '\\' . 'ModuleInstall';
        $installClass = new $class();
        if(!$installClass->activate()){
            throw new \RuntimeException("Error activate module: {$module->name}");
        }
        
        return true;
    }
    
    public function deactivate(\t2cms\module\dto\ModuleDTO $module): bool
    {
        $class = $module->namespace . '\\' . 'ModuleInstall';
        $installClass = new $class();
        if(!$installClass->deactivate()){
            throw new \RuntimeException("Error deactivate module: {$module->name}");
        }
        
        return true;
    }
    
    public function update(\t2cms\module\dto\ModuleDTO $module): bool
    {
        $class = $module->namespace . '\\' . 'ModuleInstall';
        $installClass = new $class();
        if(!$installClass->update()){
            throw new \RuntimeException("Error update module: {$module->name}");
        }
        
        return true;
    }
}
