<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use t2cms\acf\models\AcfField;

/* @var $this yii\web\View */
/* @var $model t2cms\acf\models\AcfField */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsVar('fieldTypes', array_flip(AcfField::getTypes()));
?>

<div class="acf-field-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(AcfField::getTypes()) ?>
    
    <?= $form->field($model, 'data', [
        'options' => [
            'class' => ($model->type === AcfField::TYPE_SELECT)? '' : 'hide',
            'id' => 'field-acffield-data'
            ]
        ])
        ->hint(\Yii::t('app', 'Each item on a new line'))
        ->textarea(['rows' => 5]);?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$js = <<<JS
    $('#acffield-type').change(function(){
        if($(this).val() == fieldTypes.select){
            $('#field-acffield-data').removeClass('hide')
        } else {
            $('#field-acffield-data').addClass('hide')
        }
    });
JS;

$this->registerJs($js);
?>