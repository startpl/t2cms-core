<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */

$this->title = Yii::t('menu', 'Create Item of Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Items'), 'url' => ['/menu/items', 'id' => $menuId]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render('_form', [
        'menuId'     => $menuId,
        'itemId'     => null,
        'model'      => $model,
        'pages'      => $pages,
        'categories' => $categories
    ]);?>
</div>
