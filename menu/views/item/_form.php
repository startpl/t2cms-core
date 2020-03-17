<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="menu-form">
    <ul class="nav nav-tabs">
        <li class="nav-item active">
            <a class="nav-link" data-toggle="tab" href="#page">Страница</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#category">Категория</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#url">Ссылка</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="page">
            <?=$this->render('sections/pagesList', ['pages' => $pages]);?>
        </div>
        <div class="tab-pane fade" id="category">
            CategoryHelper::getAll();
        </div>
        <div class="tab-pane fade" id="url">
            Simple input
        </div>
    </div>
    
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('menu', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>