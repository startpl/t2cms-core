<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use t2cms\sitemanager\models\{
    forms\DomainForm,
    Domain,
    DomainSearch,
    Setting
};
use t2cms\sitemanager\useCases\{
    DomainService, 
    SettingService
};
use t2cms\sitemanager\repositories\{
    DomainRepository,
    SettingRepository
};

/**
 * DomainsController implements the CRUD actions for Domain model.
 * 
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DomainsController extends Controller
{
    private $domainService;
    private $domainRepository;
    private $settingService;
    private $settingRepository;
    
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
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function __construct
    (
        $id, 
        $module, 
        DomainService $domainService,
        DomainRepository $domainRepository,
        SettingService $settingService,
        SettingRepository $settingRepository,
        $config = []
    ) 
    {
        parent::__construct($id, $module, $config);
        $this->domainService     = $domainService;
        $this->domainRepository  = $domainRepository; 
        $this->settingService    = $settingService;
        $this->settingRepository = $settingRepository;
    }

    /**
     * Lists all Domain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DomainSearch();
        $dataProvider = $this->domainRepository->search($searchModel, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Domain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DomainForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($domain = $this->domainService->create($model)){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success create'));
                return $this->redirect(['update', 'id' => $domain->id]);
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error create'));
            }
        }
        else if(Yii::$app->request->post() && !$model->validate()){
            \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error create'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Domain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $language_id = \t2cms\sitemanager\components\Languages::getEditorLangaugeId();
        
        $model    = $this->findModel($id);
        $settings = $this->findDomainSettings($id, $language_id);
                
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(
                $this->domainService->updateDomain($model->id, \Yii::$app->request->post()) &&
                $this->settingService->saveMultiple($settings, \Yii::$app->request->post(), $id, $language_id)
            ){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
                return $this->refresh();
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }
        
        return $this->render('update', [
            'model'    => $model,
            'settings' => $settings
        ]);
    }

    /**
     * Deletes an existing Domain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model  = $this->findModel($id);
        
        if($model->is_default){
            \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Unable to delete default domain'));
            return $this->redirect(['index']);
        }
            
        if($this->domainService->delete($model)){
            \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
        }
        else{
            \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
        }
        
        return $this->redirect(['index']);
    }
    
    public function actionMakeDefault($id)
    {
        $model = $this->findModel($id);
        
        if($this->domainService->makeDefault($model)){
            \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
        }
        else{
            \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
        }
        return $this->redirect(['index']);
    }
    
    private function findDomainSettings($id, $language_id = null)
    {
        try{
            $models = $this->settingRepository->getAllByStatus(
                [
                    Setting::STATUS['MAIN'],
                    Setting::STATUS['CUSTOM']
                ],
                $id, 
                $language_id);
        } catch(\DomainException $e){
            throw new NotFoundHttpException(Yii::t('sitemanager', 'The requested page does not exist.'));
        }
        
        return $models;
    }

    /**
     * Finds the Domain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Domain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        try{
            $model = $this->domainRepository->getById($id);
        } catch(\DomainException $e){
            throw new NotFoundHttpException(Yii::t('sitemanager', 'The requested page does not exist.'));
        }
        
        return $model;
    }
}
