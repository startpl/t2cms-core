<?php

namespace t2cms\acf\controllers;

use Yii;
use t2cms\acf\models\AcfField;
use t2cms\acf\models\AcfFieldSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use t2cms\acf\repositories\{
    AcfGroupRepository,
    AcfFieldRepository
};


/**
 * FieldController implements the CRUD actions for AcfField model.
 */
class DefaultController extends Controller
{
    private $acfGroupRepository;
    private $acfFieldRepository;
    
    public function __construct
    (
        $id, 
        $module,
        AcfGroupRepository $acfGroupRepository,
        AcfFieldRepository $acfFieldRepository,
        $config = array()
    ) {
        parent::__construct($id, $module, $config);
        
        $this->acfGroupRepository = $acfGroupRepository;
        $this->acfFieldRepository = $acfFieldRepository;
    }
    
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

    /**
     * Lists all AcfField models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $groups = \yii\helpers\ArrayHelper::map(
            AcfGroupRepository::getAll(),
            'id',
            'name'
        );
        
        $searchModel = new AcfFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'groups'       => $groups,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AcfField model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $groupFields = $this->acfFieldRepository->getAllByGroup($id);
        
        debug($groupFields);
    }

    /**
     * Creates a new AcfField model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AcfField();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AcfField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AcfField model.
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
     * Finds the AcfField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AcfField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AcfField::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
