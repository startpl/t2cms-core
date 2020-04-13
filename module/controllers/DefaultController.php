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
use yii\data\ArrayDataProvider;

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
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->moduleService->getAll()
        ]);
        
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionView($path)
    {
        $module = $this->getModule($path);
        return $this->render('view', ['model' => $module]);
    }
    
    public function actionInstall($path)
    {
        $module = $this->getModule($path);
        
        if($this->moduleService->install($module)){
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success install'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app/error', 'Error install'));
        }
        
        return $this->goBack(\Yii::$app->request->referrer);
    }
    
    public function actionUninstall($path)
    {
        $module = $this->getModule($path);
        
        if($this->moduleService->uninstall($module)){
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success uninstall'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app/error', 'Error uninstall'));
        }
        
        return $this->goBack(\Yii::$app->request->referrer);
    }
    
    public function actionActivate($path)
    {
        $module = $this->getModule($path);
        
        if($this->moduleService->activate($module)){
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success activate'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app/error', 'Error activate'));
        }
        
        return $this->goBack(\Yii::$app->request->referrer);
    }
    
    public function actionDeactivate($path)
    {
        $module = $this->getModule($path);
        
        if($this->moduleService->deactivate($module)){
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success deactivate'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app/error', 'Error deactivate'));
        }
        
        return $this->goBack(\Yii::$app->request->referrer);
    }
    
    public function actionUpdate($path)
    {
        $module = $this->getModule($path);
        
        if($this->moduleService->update($module)){
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Success update'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app/error', 'Error update'));
        }
        
        return $this->goBack(\Yii::$app->request->referrer);
    }
    
    private function getModule(string $path): \t2cms\module\dto\ModuleDTO
    {
        if(!$model = $this->moduleService->getModule($path)){
            throw new NotFoundHttpException("Page not found");
        }
        
        return $model;
    }
}
