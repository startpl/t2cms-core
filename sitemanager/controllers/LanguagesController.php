<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\controllers;

use Yii;
use t2cms\sitemanager\models\Language;
use t2cms\sitemanager\models\LanguageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \t2cms\sitemanager\useCases\LanguageService;
use \t2cms\sitemanager\repositories\LanguageRepository;

/**
 * LanguagesController implements the CRUD actions for Language model.
 * 
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class LanguagesController extends Controller
{
    private $languageService;
    private $languageRepository;
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
        LanguageService $languageService,
        LanguageRepository $languageRepository,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->languageService    = $languageService;
        $this->languageRepository = $languageRepository; 
    }

    /**
     * Lists all Language models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LanguageSearch();
        $dataProvider = $this->languageRepository->search($searchModel, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Language model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new \t2cms\sitemanager\models\forms\LanguageForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($this->languageService->create($model)){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success create'));
                return $this->redirect(['index']);
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error create'));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Language model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($this->languageService->update($model)){
                \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
                return $this->refresh();
            }
            else{
                \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Language model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model  = $this->findModel($id);
        
        if($model->is_default){
            \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Unable to delete default language'));
            return $this->redirect(['index']);
        }
        
        if($this->languageService->delete($model)){
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
        
        if($this->languageService->makeDefault($model)){
            \Yii::$app->session->setFlash('success', \Yii::t('sitemanager', 'Success save'));
        }
        else{
            \Yii::$app->session->setFlash('error', \Yii::t('sitemanager/error', 'Error save'));
        }
        return $this->redirect(['index']);
    }
    
     /**
     * Finds the Language model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Language the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    private function findModel($id): Language
    {
        if(!$model = $this->languageRepository->getById($id)){
            throw new NotFoundHttpException(Yii::t('sitemanager', 'The requested page does not exist.'));
        }
        
        return $model;
    }
}
