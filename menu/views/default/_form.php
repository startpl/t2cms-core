<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'title') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('menu', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>