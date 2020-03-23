<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use t2cms\menu\models\MenuItem;

/* @var $this yii\web\View */
/* @var $searchModel t2cms\menu\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Items of {name}', ['name' => $model->title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="section-justify">
        <p>
            <?= Html::a(Yii::t('menu', 'Create Item'), ['/menu/item/create', 'menuId' => $id], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="section-right">
                <div class="zone-section">
                    <div class="domain-change">
                        <?= t2cms\sitemanager\widgets\local\DomainList::widget();?>
                    </div>
                    <div class="language-change">
                        <?= t2cms\sitemanager\widgets\local\LanguageList::widget();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php Pjax::begin(); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'name',
                'label' => 'Name',
                'format' => 'html',
                'value' => function($model, $key, $index){
                    $anchor = str_repeat(' - ', $model->depth - MenuItem::OFFSET_ROOT) . ' ' . $model->itemContent->name;
                    return \yii\helpers\Html::a($anchor, ['/menu/item/update', 'id' => $model->id]);
                }
            ],
            [
                'attribute' => 'type',
                'label' => 'Type',
                'value' => function($model, $key, $index){
                    return \t2cms\menu\models\MenuItem::getItemTypes()[$model->type];
                }
            ],
            [
                'attribute' => 'data',
                'label' => 'URI',
                'format' => 'raw',
                'value' => function($model, $key, $index){
                    $url = \t2cms\menu\helpers\MenuUrl::to($model, true);
                    $anchor = [
                        $url, 
                        rmrevin\yii\fontawesome\FontAwesome::i('external-link')
                    ];
                    return Html::a(implode(' ', $anchor), $url, [
                        'target' => '_blank'
                    ]);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>