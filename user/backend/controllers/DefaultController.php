<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\user\backend\controllers;

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
    public function actionIndex()
    {
        return 'index';
    }
}
