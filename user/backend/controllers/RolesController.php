<?php

namespace t2cms\user\backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use t2cms\user\common\models\AuthItem;
use t2cms\user\common\models\AuthItemSearch;
use t2cms\user\common\repositories\RoleRepository;
use t2cms\user\common\useCases\RoleService;

/**
 * RolesController implements the CRUD actions for AuthItem model.
 */
class RolesController extends Controller
{
    private $roleRepository;
    private $roleService;
    
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
                        'roles' => ['manageRBAC'],
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
    
    public function __construct($id, $module, RoleRepository $repository, RoleService $service, $config = array()) {
        parent::__construct($id, $module, $config);
        
        $this->roleRepository = $repository;
        $this->roleService    = $service;
    }

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new AuthItem();
        $form->type = AuthItem::ROLE_TYPE;
                
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if($this->roleService->save($form)){
                Yii::$app->session->setFlash('success', Yii::t('t2cms', "Success create"));
                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('error', Yii::t('t2cms/error', "Error create"));
                return $this->refresh();
            }
            
        } else if(Yii::$app->request->post()){
            Yii::$app->session->setFlash('error', Yii::t('t2cms/error', "Error validate form"));
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($this->roleService->save($model)){
                Yii::$app->session->setFlash('success', Yii::t('t2cms', "Success save"));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('t2cms/error', "Error save"));
            }
            
            return $this->refresh();
            
        } else if(Yii::$app->request->post()){
            Yii::$app->session->setFlash('error', Yii::t('t2cms/error', "Error validate form"));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        try{
            $model = $this->roleRepository->get($id);
        } catch (\DomainException $e){
            throw new NotFoundHttpException(Yii::t('t2cms/error', 'The requested page does not exist'));
        }

        return $model;
    }
}
