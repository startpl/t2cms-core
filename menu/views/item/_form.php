<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use t2cms\menu\models\MenuItem;
use yii\helpers\ArrayHelper;
use t2cms\user\common\repositories\RoleRepository;
use t2cms\sitemanager\components\{
    Domains,
    Languages
};

$this->registerJsVar('itemTypes', \t2cms\menu\models\MenuItem::getItemTypes());

t2cms\menu\AssetBundle::register($this);

$this->registerJsVar('modelDefaultType', MenuItem::TYPE_BLOG_PAGE);

$jsModel = ArrayHelper::toArray($model);
$jsModel['name'] = $model->itemContent->name;

$this->registerJsVar('model', $jsModel);

$roles = ArrayHelper::map(RoleRepository::getAll(), 'name', 'description');

foreach($roles as &$role) {
    $role = \Yii::t('t2cms', $role);
}
?>
<div class="menu-item-form">
    <ul class="nav nav-tabs">
        <li class="nav-item" data-type="<?= MenuItem::TYPE_BLOG_PAGE?>">
            <a class="nav-link" data-toggle="tab" href="#page"><?=\Yii::t('menu', 'Page')?></a>
        </li>
        <li class="nav-item" data-type="<?= MenuItem::TYPE_BLOG_CATEGORY?>">
            <a class="nav-link" data-toggle="tab" href="#category"><?=\Yii::t('menu', 'Category')?></a>
        </li>
        <li class="nav-item" data-type="<?= MenuItem::TYPE_MODULE?>">
            <a class="nav-link" data-toggle="tab" href="#module"><?=\Yii::t('menu', 'Module')?></a>
        </li>
        <li class="nav-item" data-type="<?= MenuItem::TYPE_URI?>">
            <a class="nav-link" data-toggle="tab" href="#uri"><?=\Yii::t('menu', 'Link')?></a>
        </li>
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
    </ul>
    <div class="row panel_wrapper">
        <div class="col-md-3">
            <div class="tab-content">
                <div class="tab-pane fade" id="page" data-type="<?= MenuItem::TYPE_BLOG_PAGE?>">
                    <div class="pages-list menu-list-type" id="menu-pages-list">
                        <ul>
                        <?php foreach($pages as $page):?>
                            <li><a data-id="<?=$page['id'];?>" data-type="<?= MenuItem::TYPE_BLOG_PAGE?>"><?=$page['pageContent']['name']?></a></li>
                        <?php endforeach;?>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="category" data-type="<?= MenuItem::TYPE_BLOG_CATEGORY?>">
                    <div class="categories-list menu-list-type" id="menu-categories-list">
                        <ul>
                        <?php foreach($categories as $category):?>
                            <li><a data-id="<?=$category['id'];?>" data-type="<?= MenuItem::TYPE_BLOG_CATEGORY?>"><?=$category['categoryContent']['name']?></a></li>
                        <?php endforeach;?>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="module" data-type="<?= MenuItem::TYPE_MODULE?>">
                    <div class="categories-list menu-list-type" id="menu-modules-list">
                        <ul>
                        <?php foreach($modules as $module):?>
                            <li><a data-id="<?=$module->path;?>" data-type="<?= MenuItem::TYPE_MODULE?>"><?=$module->name?></a></li>
                        <?php endforeach;?>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="uri" data-type="<?= MenuItem::TYPE_URI?>">
                    
                    <div class="form-group field-menuitemform-uri">
                        <label class="control-label" for="menuitemform-uri">Name</label>
                        <?=Html::input('text', 'uri', null, [
                            'id' => 'menuitemform-uri',
                            'class' => 'form-control',
                            'placeholder' => 'uri',
                            'data' => [
                                'type' => MenuItem::TYPE_URI
                            ]
                        ])?>

                        <div class="help-block"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            
            <div class="panel panel-default">
                <div class="panel-heading"><?=\Yii::t('menu', 'Parameters')?></div>
                <div class="panel-body">
                    <div class="active-form">
                        <div class="item-info">
                            <div>
                                <span>ID:</span>
                                <span id="info-id"></span>
                            </div>
                            <div>
                                <span><?=\Yii::t('menu', 'Type')?>:</span>
                                <span id="info-type"><?=\Yii::t('menu', 'Page')?></span>
                            </div>
                        </div>
                        <?php $form = ActiveForm::begin(); ?>
                        
                            <?= $form->field($model->itemContent, 'name', [
                                'inputOptions' => [
                                    'id' => 'menuitemcontent-name',
                                    'class' => 'form-control'
                                ]
                            ]) ?>
                        
                            <?= $form->field($model, 'image')->widget(\mihaildev\elfinder\InputFile::className(), [
                                'controller'    => 'elfinder',
                                'filter'        => 'image',
                                'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'options'       => ['class' => 'form-control'],
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'multiple'      => false 
                            ]); ?>
                        
                            <?= $form->field($model, 'type', [
                                'inputOptions' => [
                                    'id' => 'menuitem-type'
                                ]
                            ])->hiddenInput()->label(false)?>
                        
                            <?= $form->field($model, 'data', [
                                'inputOptions' => [
                                    'id' => 'menuitem-data'
                                ]
                            ])->hiddenInput()->label(false)?>

                            <?= $form->field($model, 'parent_id')->dropDownList(
                                MenuItem::getTree($menuId, $itemId, Domains::getEditorDomainId(), Languages::getEditorLangaugeId()), 
                                ['prompt' => Yii::t('menu','No Parent'), 'class' => 'form-control']
                            )?>
                        
                            <?= $form->field($model, 'status')->checkbox([
                                'label' => \Yii::t('menu', 'Active')
                            ])?>
                            <?= $form->field($model, 'render_js')->checkbox([
                                'label' => \Yii::t('menu', 'Render using js?')
                            ])?>
                            <?= $form->field($model, 'target')->checkbox([
                                'label' => \Yii::t('menu', 'Open in new window?')
                            ])?>
                        
                            <?= $form->field($model, 'access')->dropDownList(
                                array_merge(
                                    [
                                        'everyone' => \Yii::t('t2cms', 'Everyone') 
                                    ],
                                    $roles
                                )
                            ) ?>

                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('menu', 'Submit'), ['class' => 'btn btn-primary']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>