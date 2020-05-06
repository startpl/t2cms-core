<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel t2cms\menu\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('menu', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'width' => 80
                   ]
            ],
            [
                'attribute' => 'name',
                'label' => 'Name',
                'format' => 'html',
                'value' => function($model, $key, $index){
                    $anchor = rmrevin\yii\fontawesome\FontAwesome::i('list').' '.$model->name;
                    return \yii\helpers\Html::a($anchor, ['items', 'id' => $model->id]);
                }
            ],
            'title',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
