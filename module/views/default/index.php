<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use t2cms\module\widgets\ModuleActions;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = Yii::t('app', 'Modules');
$this->params['breadcrumbs'][] = $this->title;

t2cms\T2Asset::register($this);
?>
<div class="module-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'modules-grid',
        'columns' => [
            [
                'attribute' => 'icon',
                'label' => '#',
                'headerOptions' => ['width' => '30'],
                'format' => 'html',
                'value' => function($model, $key, $index){
                    return rmrevin\yii\fontawesome\FontAwesome::i($model->fa_icon);
                }
            ],
            [
                'attribute' => 'Name',
                'format' => 'raw',
                'value' => function($model, $key, $index){
                    return Html::a(
                        $model->name, 
                        ['/module/'.$model->url], 
                        [
                            'data' => [
                                'pjax' => 0,
                            ]
                        ]);
                }
            ],
            'description',
            'author',
            'version',
            [
                'label' => \Yii::t('app', 'Status'),
                'attribute' => 'status',
                'value' => function($model, $key, $index){
                    return t2cms\module\models\Module::getStatuses()[$model->status];
                }
            ],
            [
                'label' => \Yii::t('app', 'Controls'),
                'headerOptions' => ['width' => '80'],
                'format' => 'raw',
                'value' => function($model, $key, $index){
                    return ModuleActions::widget([
                        'model' => $model,
                        'id' => 'dropdownMenu' . $key
                    ]);
                }
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>