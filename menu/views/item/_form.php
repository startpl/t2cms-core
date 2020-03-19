<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use t2cms\menu\models\MenuItem;
use t2cms\sitemanager\components\{
    Domains,
    Languages
};

$this->registerJsVar('itemTypes', \t2cms\menu\models\MenuItem::getItemTypes());

t2cms\menu\AssetBundle::register($this);

$this->registerJsVar('modelDefaultType', MenuItem::TYPE_BLOG_PAGE);
$this->registerJsVar('model', $model);
?>
<div class="menu-item-form">
    <ul class="nav nav-tabs">
        <li class="nav-item" data-type="<?= MenuItem::TYPE_BLOG_PAGE?>">
            <a class="nav-link" data-toggle="tab" href="#page"><?=\Yii::t('menu', 'Page')?></a>
        </li>
        <li class="nav-item" data-type="<?= MenuItem::TYPE_BLOG_CATEGORY?>">
            <a class="nav-link" data-toggle="tab" href="#category"><?=\Yii::t('menu', 'Category')?></a>
        </li>
        <li class="nav-item" data-type="<?= MenuItem::TYPE_URI?>">
            <a class="nav-link" data-toggle="tab" href="#uri"><?=\Yii::t('menu', 'Link')?></a>
        </li>
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
                <div class="tab-pane fade" id="uri" data-type="<?= MenuItem::TYPE_URI?>">
                    
                    <div class="form-group field-menuitemform-uri">
                        <label class="control-label" for="menuitemform-uri">Name</label>
                        <?=Html::input('text', 'uri', null, [
                            'id' => 'menuitemform-uri',
                            'class' => 'form-control',
                            'placeholder' => 'uri'
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
                                <span>ID</span>
                                <span id="info-id"></span>
                            </div>
                            <div>
                                <span><?=\Yii::t('menu', 'Type')?></span>
                                <span id="info-type"><?=\Yii::t('menu', 'Page')?></span>
                            </div>
                        </div>
                        <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model->itemContent, 'name') ?>
                            <?= $form->field($model, 'type')->hiddenInput()->label(false)?>
                            <?= $form->field($model, 'data')->hiddenInput()->label(false)?>

                            <?= $form->field($model, 'parent_id')->dropDownList(
                                MenuItem::getTree($menuId, $itemId, Domains::getEditorDomainId(), Languages::getEditorLangaugeId()), 
                                ['prompt' => Yii::t('menu','No Parent'), 'class' => 'form-control']
                            )?>
                        
                            <?= $form->field($model, 'status')->checkbox()?>
                            <?= $form->field($model, 'target')->checkbox()?>

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