<?php

namespace t2cms\api\controllers;

use yii\web\Controller;
/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends Controller
{    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AjaxFilter::className(),
            ]
        ];
    }
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    /**
     * just docs
     * @return mixed
     */
    public function actionIndex()
    {
        return [
            'url' => [
                '/api/user/change-language' => [
                    'method' => 'GET',
                    'data' => [
                        'code' => 'local-CODE'
                    ],
                    'response' => [
                        'success' => 'boolean'
                    ],
                    'notice' => 'You have to reload page.'
                ]
            ]
        ];
    }
}
