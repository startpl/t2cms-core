<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model t2cms\user\common\models\AuthItem */

$this->title = Yii::t('app', 'Update Role: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="auth-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="auth-item-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
