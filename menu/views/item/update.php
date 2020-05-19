<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */

$this->title = $model->itemContent->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menu'), 'url' => ['/menu/default/items', 'id' => $menuId]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_form', [
        'menuId'     => $menuId,
        'itemId'     => $model->id,
        'model'      => $model,
        'pages'      => $pages,
        'categories' => $categories,
        'modules'    => $modules,
    ]);?>
</div>
