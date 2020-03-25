<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\design\useCases;

use t2cms\sitemanager\useCases\SettingService;
use t2cms\sitemanager\repositories\SettingRepository;
use t2cms\design\Theme;

/**
 * Description of designService
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class DesignService 
{
    private $settingService;
    private $settingRepository;
    
    public function __construct(SettingService $settingService, SettingRepository $settingRepository)
    {
        $this->settingService    = $settingService;
        $this->settingRepository = $settingRepository;
    }
    
    public function activateTheme(Theme $theme): bool
    {
        return $this->settingService->set(Theme::SETTING_NAME, $theme->name);
    }
    
}
