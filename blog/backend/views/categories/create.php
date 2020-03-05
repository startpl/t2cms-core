<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model t2cms\blog\models\Category */

$this->title = Yii::t('nsblog', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('nsblog', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

t2cms\blog\AssetBundle::register($this);
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allCategories' => $allCategories,
        'allPages' => $allPages,
    ]) ?>

</div>
