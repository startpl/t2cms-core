<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\design\repositories;

use yii\helpers\FileHelper;
use t2cms\design\Theme;

/**
 * Description of DesignRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class DesignRepository 
{    
    private $pathThemes;
    
    public function __construct() {
        $this->pathThemes = \Yii::getAlias('@themes');
    }
    
    public function getByName(string $name): ?Theme
    {
        $directory = $this->pathThemes . DIRECTORY_SEPARATOR . $name;
        
        if(is_dir($directory)){
            return $this->getTheme($directory);
        }
        
        return null;
    }
    
    public function getAllThemes(): ?array
    {
        $directories = FileHelper::findDirectories($this->pathThemes, ['recursive' => false]);
        
        $result = [];
        foreach($directories as $dir){
            $result[] = $this->getTheme($dir);
        }
        
        return $result;
    }
    
    private function getTheme(string $directory): Theme
    {
        return new Theme($directory);
    }
    
}
