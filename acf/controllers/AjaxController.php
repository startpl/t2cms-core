<?php

namespace t2cms\acf\controllers;

use yii\web\Controller;
use t2cms\acf\repositories\{
    AcfGroupRepository,
    AcfFieldRepository
};

/**
 * DefaultController implements the CRUD actions for AcfGroup model.
 */
class AjaxController extends Controller
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
        
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'ajax' => [
                'class' => \yii\filters\AjaxFilter::className(),
            ]
        ];
    }

    public function actionIndex()
    {
        $post = \Yii::$app->request->post('acf');
                
        $data = $this->acfFieldRepository->getAllByGroup(
            (int)$post['group_id'], 
            (int)$post['src_id'],
            (string)$post['src_type'],
            (int)$post['domain_id'], 
            (int)$post['language_id']
        );
                
        return $this->renderAjax('_form', ['data' => $data]);
    }
}
