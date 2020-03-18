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
use t2cms\menu\useCases\MenuItemService;
use t2cms\menu\repository\MenuItemRepository;


class ItemController extends Controller
{
    
    private $menuItemService;
    
    private $menuItemRepository;
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
        MenuItemService $service,
        MenuItemRepository $repository,
        $config = array()) 
    {
        parent::__construct($id, $module, $config);
        
        $this->menuItemService    = $service;
        $this->menuItemRepository = $repository;
    }

    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $this->redirect(['/menu']);
    }
    
    public function actionCreate($id)
    {
        $form = new \t2cms\menu\models\forms\MenuItemForm();
        
        if($form->load(\Yii::$app->request->post()) && $form->validate()){
            if($model = $this->menuItemService->create($form)){
                \Yii::$app->session->setFlash('success', \Yii::t('menu', 'Success create'));
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error create'));
            }
        }
        else if(Yii::$app->request->post() && !$model->validate()){
            \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error create'));
        }
        
        $pages = \startpl\t2cmsblog\helpers\PageHelper::getAll();
        $categories = \startpl\t2cmsblog\helpers\CategoryHelper::getAll();
        
        return $this->render('create',[
            'menuId'  => $id,
            'model' => $form,
            'pages' => $pages,
            'categories' => $categories
        ]);
    }
    
    public function actionUpdate($id)
    {        
        
    }
    
    public function actionDelete($id)
    {
       
    }
    
    private function findModel(int $id)
    {
        try{
            $model = $this->menuRepository->get($id);
        } catch (\Exception $e){
            throw new NotFoundHttpException("The menu with id: {$id} not found");
        }
        
        return $model;
    }
}
