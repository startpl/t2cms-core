<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\module\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use t2cms\module\services\ModuleService;

class DefaultController extends Controller
{    
    private $moduleService;
    
    public function __construct($id, $module, ModuleService $moduleService, $config = array()) {
        parent::__construct($id, $module, $config);
        
        $this->moduleService = $moduleService;
    }
    
    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $module = $this->moduleService->getAll();
        
        debug($module);
    }
}
