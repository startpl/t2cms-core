<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
t2cms\T2Asset::register($this);
?>
<div class="module-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?=\t2cms\module\widgets\ModuleActions::widget([
            'id' => $model->path,
            'model' => $model,
            'buttonText' => \Yii::t('app', 'Controls') . ' <span class="caret"></span>'
        ]);?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'icon',
                'label' => 'Icon',
                'headerOptions' => ['width' => '30'],
                'format' => 'html',
                'value' => function($model, $key){
                    return rmrevin\yii\fontawesome\FontAwesome::i($model->fa_icon);
                }
            ],
            [
                'attribute' => 'Name',
                'format' => 'html',
                'value' => function($model, $key){
                    return Html::a($model->name, ['view', 'path' => $model->path]);
                }
            ],
            'description',
            'author',
            'version',
            [
                'attribute' => 'currentVersion',
                'label'   => \Yii::t('app', 'Current version'),
                'visible' => $model->status > t2cms\module\models\Module::STATUS_NEW
            ],
            [
                'label' => \Yii::t('app', 'Status'),
                'attribute' => 'status',
                'value' => function($model, $key){
                    return t2cms\module\models\Module::getStatuses()[$model->status];
                }
            ],
        ],
    ]) ?>

</div>
