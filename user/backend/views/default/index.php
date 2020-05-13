<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use t2cms\user\common\enums\UserStatus;
use yii\helpers\ArrayHelper;
use t2cms\user\common\repositories\RoleRepository;

/* @var $this yii\web\View */
/* @var $searchModel t2cms\user\common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('t2cms', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => \Yii::t('t2cms', 'Login'),
                'attribute' => 'username',
                'format' => 'html',
                'value' => function($model, $key, $index){
                    return Html::a($model->username, ['update', 'id' => $model->id]);
                }
            ],
            'email',
            [
                'label' => \Yii::t('t2cms', 'Status'),
                'attribute' => 'status',
                'filter' => UserStatus::getStatuses(),
                'value' => function($model, $key, $index){
                    $statuses = UserStatus::getStatuses();
                    return $statuses[$model->status];
                }
            ],
            [
                'label' => \Yii::t('t2cms', 'Role'),
                'attribute' => 'role',
                'format' => 'text',
                'filter' => ArrayHelper::getColumn(RoleRepository::getAll(), 'description'),
                'value' => function($model, $key, $index){
                    $role = array_shift(\Yii::$app->authManager->getRolesByUser($model->id));
                    return \Yii::t('t2cms', $role->description);
                }
            ],
            [
                'label' => \Yii::t('t2cms', 'Registration date'),
                'attribute' => 'created_at',
                'format' => 'date'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => [
                    'width' => 80
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
