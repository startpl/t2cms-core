<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_form', [
        'menuId'  => $menuId,
        'model' => $model,
        'pages' => $pages,
        'categories' => $categories
    ]);?>
</div>
