<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use t2cms\module\widgets\ModuleActions;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = Yii::t('app', 'Modules');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsVar('urlShowMenuToggle', \yii\helpers\Url::to(['show-menu-toggle']));

t2cms\T2Asset::register($this);
?>
<div class="module-index">
    <?php if(\Yii::$app->session->hasFlash('error/info')):?>
        <pre><?=\Yii::$app->session->getFlash('error/info')?></pre>
    <?php endif;?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php // Pjax::begin(); ?>

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
                'label'     => \Yii::t('t2cms', 'Show in menu'),
                'options' => ['width'=>'120px'],
                'format'    => 'raw',
                'value' => function($model, $key, $index){
                    switch($model->status) {
                        case t2cms\module\models\Module::STATUS_ACTIVE:
                            $html  = Html::beginTag('div', ['class' => 'switch_checkbox']);
                            $html .= Html::checkbox(
                                        "showInMenu[{$model->path}]", 
                                        $model->show_in_menu, 
                                        [
                                            'id' => 'show_in_menu'.$model->path, 
                                            'class' => 'change-show_in_menu',
                                            'data' => [
                                                'path' => $model->path
                                            ]
                                        ]
                                    );
                            $html .= Html::label('Switch', 'show_in_menu'.$model->path);
                            $html .= Html::endTag('div');
                            break;
                        case t2cms\module\models\Module::STATUS_INSTALL:
                        case t2cms\module\models\Module::STATUS_INACTIVE:
                            $html = \Yii::t('t2cms', 'Not active');
                            break;
                        default: 
                            $html = \Yii::t('t2cms', 'Not installed');
                    }
                    return $html;
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

    <?php // Pjax::end(); ?>

</div>

<?php
$js = <<<JS
    $('.change-show_in_menu').change(function(){
        const modulePath = $(this).data('path');
        
        let formData = new FormData();
        formData.set('modulePath', modulePath);
        formData.set('value', $(this).prop('checked'));
        
        $.ajax({
            type: "POST",
            url: urlShowMenuToggle,
            data: formData,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            success: (response) => {
                if(response.success) {
                    $(this).prop('checked', response.value);
                } else {
                    $(this).prop('checked', !response.value);
                }
            },
            error: (response) => console.error(response)
        });
    });
JS;

$this->registerJs($js);
?>
