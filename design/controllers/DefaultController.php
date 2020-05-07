<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\design\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use t2cms\design\useCases\DesignService;
use t2cms\design\repositories\DesignRepository;

class DefaultController extends Controller
{    
    private $designService;
    private $designRepository;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'panelAccess' => [
                'class' => \t2cms\base\behaviors\AdminPanelAccessControl::className()
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manageSetting'],
                    ],
                ],
            ]
        ];
    }
    
    public function __construct($id, $module, DesignService $designService, DesignRepository $designRepository, $config = array()) {
        parent::__construct($id, $module, $config);
        
        $this->designService    = $designService;
        $this->designRepository = $designRepository;
    }
    
    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', ['themes' => $this->designRepository->getAllThemes()]);
    }
    
    public function actionActivate($name)
    {   
        $theme = $this->findTheme($name);
        
        if($this->designService->activateTheme($theme)){
            \Yii::$app->session->setFlash('success', \Yii::t('design', "{$name} theme activated "));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('design', "Error activating theme"));
        }
        
        return $this->redirect(['index']);
    }
    
    private function findTheme(string $name)
    {
        if(!$theme = $this->designRepository->getByName($name)){
            throw new NotFoundHttpException("The theme with name {$name} not exists");
        }
        
        return $theme;
    }
}
