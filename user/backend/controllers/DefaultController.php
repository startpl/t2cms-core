<?php

namespace t2cms\user\backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use t2cms\user\backend\forms\UserForm;
use t2cms\user\common\repositories\RoleRepository;
use t2cms\user\common\useCases\UserService;
use t2cms\user\common\models\User;
use t2cms\user\common\models\UserSearch;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends Controller
{
    private $userService;
    private $roleRepository;
    
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
        $id, $module, 
        UserService $userService,
        RoleRepository $roleRepository, 
        $config = array()
    ) 
    {
        parent::__construct($id, $module, $config);
        
        $this->userService        = $userService;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $form  = new UserForm();
        $form->fillModel($model);
        
        $roles = RoleRepository::getAll();

        if($form->load(Yii::$app->request->post()) && $form->validate()) {
            if($this->userService->save($form, $model)){
                Yii::$app->session->setFlash('success', Yii::t('user', "Success save"));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('user/error', "Error save"));
            }
        }
        else if(Yii::$app->request->post()){
            Yii::$app->session->setFlash('error', Yii::t('user/error', "Error validate"));
        }

        return $this->render('update', [
            'model' => $form,
            'roles' => $roles
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('user', 'The requested page does not exist.'));
    }
}
