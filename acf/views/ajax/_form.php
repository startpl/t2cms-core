<?php

use yii\helpers\Html;
use t2cms\acf\models\AcfField;

/* @var $this yii\web\View */
/* @var $data array t2cms\acf\models\AcfField */

?>
<div class="wr_acf_fields">
    <?php foreach($data as $field):?>
    <?php
        $inputOptions = [
            'class' => $field->type != AcfField::TYPE_CHECKBOX? 'form-control' : '',
            'id'    => 'acfField-' . $field->id
        ];
    ?>
    <div class="form-group">
        <label class="control-label" for="<?=$inputOptions['id']?>"><?=$field->name?></label>
        
        <?php switch($field->type){
            case AcfField::TYPE_SELECT:
                echo Html::dropDownList($field->name, $field->value->value, explode(PHP_EOL, $field->data), $inputOptions);
                break;
            case AcfField::TYPE_TEXTAREA:
                echo Html::textarea($field->name, $field->value->value, $inputOptions);
                break;
            case AcfField::TYPE_FILE:
                echo \mihaildev\elfinder\InputFile::widget(
                    array_merge([
                        'name'          => $field->name,
                        'value'         => $field->value->value,
                        'controller'    => '/elfinder',
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple'      => false,

                    ],
                    $inputOptions
                    )
                );
                break;
            default:
                echo Html::input(AcfField::getType($field->type), $field->name, $field->value->value, $inputOptions);
        }
        ?>
    </div>
    <?php endforeach;?>
</div>