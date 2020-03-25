<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\design;

/**
 * Theme DTO
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class Theme 
{
    const SCREEN_FILE  = 'Screenshot.png';
    const SETTING_NAME = 'design';
    
    private $path;
    
    public $name;
    public $screen;
    
    public function __construct(string $path)
    {
        $this->path = $path;
        
        $this->name   = $this->getName();
        $this->screen = $this->getScreen();
    }
    
    private function getName(): string
    {
        return array_pop(explode(DIRECTORY_SEPARATOR, $this->path));
    }
    
    private function getScreen(): string
    {
        $file = file_get_contents($this->path . DIRECTORY_SEPARATOR . self::SCREEN_FILE);
        return base64_encode($file);
    }
    
    public function isActive(): bool
    {
        return \Yii::$app->settings->get(self::SETTING_NAME) === $this->name;
    }
}
