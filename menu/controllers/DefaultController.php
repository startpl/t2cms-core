<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\menu\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{
    
    private $menuService;
    private $menuRepository;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function __construct(
        $id, 
        $module, 
        \t2cms\menu\useCases\MenuService $menuService,
        $config = array()) 
    {
        parent::__construct($id, $module, $config);
        
        $this->menuService = $menuService;
    }

    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        return 'index';
    }
    
    public function actionCreate()
    {
        $form = new \t2cms\menu\models\forms\MenuForm();
        
        if($form->load(\Yii::$app->request->post()) && $form->validate()){
            if($this->menuService->create($form)){
                \Yii::$app->session->setFlash('success', \Yii::t('menu', 'Success create'));
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error create'));
            }
        }
        
        return $this->render('create', ['model' => $form]);
    }
    
    public function actionUpdate($id)
    {        
        return 'update';
    }
    
    public function actionDelete($id)
    {
        return 'delete';
    }
    
    private function findModel(int $id)
    {
        return $model;
    }
}
