<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use t2cms\user\common\enums\UserStatus;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'username');?>
    <?= $form->field($model, 'email');?>
    <?= $form->field($model, 'role')->dropDownList(ArrayHelper::map($roles, 'name', 'description'))?>

    <?= $form->field($model, 'status')->dropDownList(UserStatus::getStatuses()) ?>
    
    <?= $form->field($model, 'newPassword')->label(\Yii::t('user', 'New password'))?>
    <?= $form->field($model, 'passwordRepeat')->label(\Yii::t('user', 'Password repeat'))?>
    
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
