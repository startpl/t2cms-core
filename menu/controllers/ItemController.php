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
use t2cms\sitemanager\components\{
    Domains,
    Languages
};


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
    public function actionIndex()
    {
        $this->redirect(['/menu']);
    }
    
    public function actionCreate($menuId)
    {        
        $form = new \t2cms\menu\models\forms\MenuItemForm();
        
        if(
            $form->load(\Yii::$app->request->post()) 
            && $form->validate()
            && $form->itemContent->load(\Yii::$app->request->post()) 
            && $form->itemContent->validate()
        ){
            if($model = $this->menuItemService->create($form, $menuId)){
                \Yii::$app->session->setFlash('success', \Yii::t('menu', 'Success create'));
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error create'));
            }
        }
        else if(Yii::$app->request->post() && (!$model->validate() || !$model->itemContent->validate())){
            \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error create'));
        }
        
        $pages = \startpl\t2cmsblog\helpers\PageHelper::getAll();
        $categories = \startpl\t2cmsblog\helpers\CategoryHelper::getAll();
        
        return $this->render('create',[
            'menuId'  => $menuId,
            'model' => $form,
            'pages' => $pages,
            'categories' => $categories
        ]);
    }
    
    public function actionUpdate($id)
    {                
        $domain_id   = Domains::getEditorDomainId();
        $language_id = Languages::getEditorLangaugeId();
        
        $model = $this->findModel($id, $domain_id, $language_id);
        
        if(
            $model->load(\Yii::$app->request->post())
            && $model->validate()
            && $model->itemContent->load(\Yii::$app->request->post()) 
            && $model->itemContent->validate()
        ){
            if($this->menuItemService->update($model, $domain_id, $language_id)){
                \Yii::$app->session->setFlash('success', \Yii::t('menu', 'Success save'));
                return $this->refresh();
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error save'));
            }
        }
        else if(Yii::$app->request->post() && (!$model->validate() || !$model->itemContent->validate())){
            \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error save'));
        }
        
        $pages = \startpl\t2cmsblog\helpers\PageHelper::getAll();
        $categories = \startpl\t2cmsblog\helpers\CategoryHelper::getAll();
        
        return $this->render('update',[
            'menuId'  => $model->tree,
            'model' => $model,
            'pages' => $pages,
            'categories' => $categories
        ]);
    }
    
    public function actionDelete($id)
    {
       
    }
    
    private function findModel(int $id, $domain_id = null, $language_id = null)
    {
        try{
            $model = $this->menuItemRepository->get($id, $domain_id, $language_id);
        } catch (\Exception $e){
            throw new NotFoundHttpException("The menu with id: {$id} not found");
        }
        
        return $model;
    }
}
