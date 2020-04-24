<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use t2cms\sitemanager\components\Languages;


/* @var $this yii\web\View */
/* @var $settings t2cms\sitemanager\models\Setting with aggignment models*/

$this->title = Yii::t('sitemanager', 'General Settings');
$this->params['breadcrumbs'][] = $this->title;

$homePageItems = [
    'pages' => yii\helpers\ArrayHelper::map(
        startpl\t2cmsblog\helpers\PageHelper::getAll(),
        'id',
        'pageContent.name'
    ),
    'categories' => startpl\t2cmsblog\helpers\CategoryHelper::getAllAsTree(null, Languages::getEditorLangaugeId())
];

$this->registerJsVar('homePageItems', $homePageItems);
?>

<div class="settings-general">
    <div class="text-right">
        <div class="zone-section">
            <?= t2cms\sitemanager\widgets\local\LanguageList::widget();?>
        </div>
    </div>

    <?php $form = ActiveForm::begin(); ?>

        <?=$form->field($settings['_disconnected']['value'], "value")
            ->checkbox([
                'label' => false, 
                'name' => 'Setting[_disconnected]',
                'id' => 'setting-_disconnected'
            ])
            ->label("Disconnected");?>
    
        <?=$form->field($settings['_site_name']['value'], "value", [
            'inputOptions' => [
                'name' => 'Setting[_site_name]',
                'class' => 'form-control',
                'id' => 'setting-_site_name'
            ]
        ])->label("Site name");?>
    
        <div class="row">
            <div class="col-md-6">
                <?=$form->field($settings['home_page_type']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[home_page_type]',
                        'class' => 'form-control',
                        'id' => 'setting-home_page_type'
                    ]])
                    ->dropDownList([
                        \Yii::t('sitemanager', 'Page'),
                        \Yii::t('sitemanager', 'Category')
                    ])
                    ->label("Home Page Type");?>
        
            </div>
            <div class="col-md-6">
                <?=$form->field($settings['home_page']['value'], 'value', [
                    'inputOptions' => [
                        'name' => 'Setting[home_page]',
                        'class' => 'form-control',
                        'id' => 'setting-home_page'
                    ]])
                    ->dropDownList(
                            $homePageItems[($settings['home_page_type']['value']->value == 0? 'pages' : 'categories')]
                    )
                    ->label('Home Page');?>
            </div>
        </div>
        
        <?= Html::submitButton(Yii::t('sitemanager', 'Save'), ['class' => 'btn btn-primary']) ?>
        
    <?php ActiveForm::end();?>
</div>
<?php
$js = <<<JS
    $('#setting-home_page_type').change(function(){
        const key   = $(this).val() > 0 ? 'categories' : 'pages';
        const dataItems = homePageItems[key];
        
        let items = '';
        
        for(let i in dataItems){
            if(!items){
                items = '<option selected value="'+i+'">'+dataItems[i]+'</option>';
                continue;
            }
        
            items += '<option value="'+i+'">'+dataItems[i]+'</option>';
        }
        
        $('#setting-home_page').html(items);
    });
JS;

$this->registerJs($js);
?>