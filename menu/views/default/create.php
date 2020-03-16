<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */

$this->title = Yii::t('menu', 'Create Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="menu-form">

        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'title') ?>
        
            <div class="form-group">
                <?= Html::submitButton(Yii::t('menu', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
