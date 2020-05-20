<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel t2cms\acf\models\AcfGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Field Groups');
$this->params['breadcrumbs'][] = $this->title;

\t2cms\T2Asset::register($this);
?>
<div class="acf-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <ul class="nav nav-tabs mb-40">
        <li><?=Html::a(\Yii::t('app', 'Fields'), ['default/index'])?></li>
        <li class="active"><a><?=\Yii::t('app', 'Groups')?></a></li>
    </ul>
    
    <p>
        <?= Html::a(Yii::t('app', 'Create Group'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'description',

            [
                'header' => \Yii::t('app', 'Controls'),
                'class' => 'yii\grid\ActionColumn'
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
