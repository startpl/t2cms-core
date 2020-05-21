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

\yii\jui\JuiAsset::register($this);
t2cms\menu\AssetBundle::register($this);

$this->registerJsVar('URL_SORT', yii\helpers\Url::to(['sort', 'id' => $id]));
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
    
    <?= \t2cms\base\widgets\treeview\TreeView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'menuItems-grid',
        'columns' => [
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
                'attribute' => 'image',
                'label'     => 'image',
                'format'    => 'image',
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
                'class' => '\t2cms\base\widgets\treeview\base\ActionColumn',
                'header' => 'Actions',
                'template' => '{update} {delete}',
                'buttons' =>
                    [
                        'update' => function ($url, $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>', 
                                ['/menu/item/update', 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>', 
                                ['/menu/item/delete', 'id' => $model->id],
                                [
                                    'data' => [
                                        'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
                                        'method'  => 'post',
                                        'pjax'    => '0'
                                    ]
                                ]);
                        }
                    ]
            ],
        ],
    ]); ?>

</div>