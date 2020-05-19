<?php

namespace t2cms\api\controllers;

use yii\web\Controller;
/**
 * DefaultController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
    
    public function __construct($id, $module, $config = array()) 
    {
        parent::__construct($id, $module, $config);
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actionChangeLanguage($code) 
    {
        return ['success' => \Yii::$app->languages->setLanguage($code), 'code-Local' => $code];
    }
}
