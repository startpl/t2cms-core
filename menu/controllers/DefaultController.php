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
use t2cms\sitemanager\components\{
    Domains,
    Languages
};

class DefaultController extends Controller
{
    
    private $menuService;
    private $menuRepository;
    private $menuItemService;
    
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
        \t2cms\menu\useCases\MenuItemService $menuItemService,
        \t2cms\menu\repository\MenuRepository $menuRepository,
        $config = array()) 
    {
        parent::__construct($id, $module, $config);
        
        $this->menuService     = $menuService;
        $this->menuItemService = $menuItemService;
        
        $this->menuRepository  = $menuRepository;
    }

    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \t2cms\menu\models\MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $form = new \t2cms\menu\models\forms\MenuForm();
        
        if($form->load(\Yii::$app->request->post()) && $form->validate()){
            if($menu = $this->menuService->create($form)){
                \Yii::$app->session->setFlash('success', \Yii::t('menu', 'Success create'));
                return $this->redirect(['update', 'id' => $menu->id]);
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error create'));
            }
        }
        else if(Yii::$app->request->post() && !$model->validate()){
            \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error create'));
        }
        
        return $this->render('create', ['model' => $form]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($this->menuService->update($model)){
                \Yii::$app->session->setFlash('success', \Yii::t('menu', 'Success update'));
                return $this->refresh();
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error update'));
            }
        }
        
        return $this->render('update', ['model' => $model]);
    }
    
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if($this->menuService->delete($model)){
            \Yii::$app->session->setFlash('success', \Yii::t('menu', 'Error delete'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('menu/error', 'Error delete'));
        }
        
        return $this->redirect(['index']);
    }
    
    public function actionItems($id)
    {
        $domain_id   = Domains::getEditorDomainId();
        $language_id = Languages::getEditorLangaugeId();
        
        $model = $this->findModel($id);
                
        $items = new \yii\data\ArrayDataProvider([
            'allModels' => $this->menuItemService->getItemsByMenuId($model->id, $domain_id, $language_id)
        ]);
        
        return $this->render('items', ['model' => $model, 'dataProvider' => $items, 'id' => $id]);
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
