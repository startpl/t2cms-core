<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */
/* @var $settings array t2cms\sitemanager\models\Setting */

$this->title = Yii::t('sitemanager', 'Settings of Domain: {name}', [
    'name' => $model->domain,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitemanager', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

\t2cms\sitemanager\AssetBundle::register($this);

$this->registerJsVar('i18n', ['confirm' => \Yii::t('sitemanager', 'Are you sure?')]);
?>
<div class="domain-update">

    <div class="section-justify">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="zone-section">
            <?= t2cms\sitemanager\widgets\local\LanguageList::widget();?>
        </div>
    </div>

    <div class="domain-form">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
        <?= $form->field($model, 'name', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'domain', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        </div>
        
        <?php if(!empty($settings)):?>
        <div class="panel panel-default">
            <div class="panel-heading"><?=\Yii::t('sitemanager', 'Settings');?></div>
            <div class="panel-body" id="settings_wr">
                <?=$form->field($settings['disconnected']['value'], "value")
                    ->checkbox([
                        'label' => false, 
                        'name' => 'Setting[disconnected]',
                        'id' => 'setting-disconnected'
                    ])
                    ->label("Disconnected");?>

                <?=$form->field($settings['site_name']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[site_name]',
                        'class' => 'form-control',
                        'id' => 'setting-site_name'
                    ]
                ])->label("Site name");?>

                <?=$form->field($settings['title_contain_sitename']['value'], "value")
                    ->checkbox([
                        'label' => false, 
                        'name' => 'Setting[title_contain_sitename]',
                        'id' => 'setting-title_contain_sitename'
                    ])
                    ->label("Title contain sitename");?>

                <?=$form->field($settings['title_separator']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[title_separator]',
                        'class' => 'form-control',
                        'id' => 'setting-title_separator'
                    ]
                    ])->label("Title separator");?>
                
                <?=$form->field($settings['robots']['value'], "value")
                    ->textarea([
                        'name' => 'Setting[robots]',
                        'id' => 'setting-robots'
                    ])
                    ->label("Robots");?>
                
                <hr/>
                                
                <?=$form->field($settings['id_google_analytics']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[id_google_analytics]',
                        'class' => 'form-control',
                        'id' => 'setting-id_google_analytics'
                    ]
                    ])->label("ID Google Analitycs");?>
                
                <?=$form->field($settings['google_webmaster']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[google_webmaster]',
                        'class' => 'form-control',
                        'id' => 'setting-google_webmaster'
                    ]
                    ])->label("Google Webmaster");?>
                
                <?=$form->field($settings['yandex_webmaster']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[yandex_webmaster]',
                        'class' => 'form-control',
                        'id' => 'setting-yandex_webmaster'
                    ]
                    ])->label("Yandex Webmaster");?>
                
                <?=$form->field($settings['id_yandex_metrika']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[id_yandex_metrika]',
                        'class' => 'form-control',
                        'id' => 'setting-id_yandex_metrika'
                    ]
                    ])->label("ID Yandex Metrika");?>
                
                <hr/>
                
                <?=$form->field($settings['city']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[city]',
                        'class' => 'form-control',
                        'id' => 'setting-city'
                    ]
                    ])->label("City 1");?>
                
                <?=$form->field($settings['city_1']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[city_1]',
                        'class' => 'form-control',
                        'id' => 'setting-city_1'
                    ]
                    ])->label("City 1");?>
                
                <?=$form->field($settings['city_2']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[city_2]',
                        'class' => 'form-control',
                        'id' => 'setting-city_2'
                    ]
                    ])->label("City 2");?>
                
                <?=$form->field($settings['city_3']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[city_3]',
                        'class' => 'form-control',
                        'id' => 'setting-city_3'
                    ]
                    ])->label("City 3");?>
                
                <?=$form->field($settings['city_4']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[city_4]',
                        'class' => 'form-control',
                        'id' => 'setting-city_4'
                    ]
                    ])->label("City 4");?>
                
                <?=$form->field($settings['city_5']['value'], "value", [
                    'inputOptions' => [
                        'name' => 'Setting[city_5]',
                        'class' => 'form-control',
                        'id' => 'setting-city_5'
                    ]
                    ])->label("City 5");?>
                <hr/>
                
                <?=$form->field($settings['address']['value'], "value")
                    ->textarea([
                        'name' => 'Setting[address]',
                        'id' => 'setting-address'
                    ])
                    ->label("Address");?>
                
                <?=$form->field($settings['phone']['value'], "value")
                    ->textarea([
                        'name' => 'Setting[phone]',
                        'id' => 'setting-phone'
                    ])
                    ->label("Phone");?>
                
                <?=$form->field($settings['email']['value'], "value")
                    ->textarea([
                        'name' => 'Setting[email]',
                        'id' => 'setting-email'
                    ])
                    ->label("Email");?>
                
                <?=$form->field($settings['email_feedback']['value'], "value")
                    ->textarea([
                        'name' => 'Setting[email_feedback]',
                        'id' => 'setting-email_feedback'
                    ])
                    ->label("Email Feedback");?>
                
                <?=$form->field($settings['email_from']['value'], "value")
                    ->textarea([
                        'name' => 'Setting[email_from]',
                        'id' => 'setting-email_from'
                    ])
                    ->label("Email From");?>
                
                <?=$form->field($settings['price_link']['value'], "value")
                    ->textarea([
                        'name' => 'Setting[price_link]',
                        'id' => 'setting-price_link'
                    ])
                    ->label("Link to price list");?>
                
            </div>
        </div>
        <?php endif;?>
        
        <div class="panel panel-default">
            <div class="panel-heading"><?=\Yii::t('sitemanager', 'Custom Settings');?></div>
            <div class="panel-body" id="settings_wr">
                <?php if(!empty($settings)):?>
                <?php foreach($settings as $index => $setting):?>
                <?php if($setting->status == \t2cms\sitemanager\models\Setting::STATUS['CUSTOM']):?>
                
                <div class="custom-setting-wr">
                    <?=$form->field($setting['value'], "value", [
                        'options' => ['class' => ($setting->required? 'required' : '')],
                        'inputOptions' => [
                            'name' => 'Setting['.$index.']',
                            'class' => 'form-control',
                            'id' => 'setting-'.$index
                        ]
                    ])->textarea()->label($index);?>
                    <div class="controls_wr">
                        <a href="<?= yii\helpers\Url::to(['default/update', 'id' => $setting->id]);?>">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-href="<?= yii\helpers\Url::to(['default/delete', 'id' => $setting->id]);?>" class="setting-delete">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach;?>
                <?php endif;?>
                
                <p>
                    <?= Html::a(Yii::t('sitemanager', 'Create Setting'), ['default/create'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
        </div>
        
        <div class="form-group">
            <?= Html::submitButton(Yii::t('sitemanager', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        
    </div>

</div>
