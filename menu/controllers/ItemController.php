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

class ItemController extends Controller
{
    
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
        $config = array()) 
    {
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $this->redirect(['/menu']);
    }
    
    public function actionCreate()
    {
        $form = new \t2cms\menu\models\forms\MenuItemForm();
        
        $pages = \startpl\t2cmsblog\helpers\PageHelper::getAll();
        $categories = \startpl\t2cmsblog\helpers\CategoryHelper::getAll();
                
        return $this->render('create',[
            'model' => $form,
            'pages' => $pages,
            'categories' => $categories
        ]);
    }
    
    public function actionUpdate($id)
    {        
        
    }
    
    public function actionDelete($id)
    {
       
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
