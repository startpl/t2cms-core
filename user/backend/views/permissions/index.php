<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel t2cms\user\common\models\PermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Permissions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?=Html::beginForm()?>
        <div class="row">
        <?php foreach($permissions as $permission):?>
        <?php 
            $children = ArrayHelper::getColumn($permission->children, 'name');
        ?>
        <div class="col-md-3 col-sm-6">
            <div class="title"><?=\Yii::t('user', $permission->description)?></div>
            <div class="body">
                <?php foreach($roles as $role):?>
                    <?php 
                        $value = in_array($role->name, $children);
                    ?>
                    <div class="checkbox">
                        <?=Html::hiddenInput(
                            $permission->name.'['.$role->name.']', 
                            ($value? true : null), 
                            [
                                'id' => $permission->name.'_'.$role->name
                            ]
                        );?>
                        <label>
                            <?=Html::checkbox(
                                $role->name.'.'.$permission->name, 
                                $value, 
                                [
                                    'class' => 'role_checkbox',
                                    'data' => [
                                        'role' => $role->name,
                                        'permission' => $permission->name
                                    ]
                                ]);?>
                            <?=$role->description?>
                        </label>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <?php endforeach;?>
        </div>
        <p>
            <?=Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']);?>
        </p>
    <?=Html::endForm();?>

</div>
<?php
$js = "$('.role_checkbox').change(function(){
    const role       = $(this).data('role');
    const permission = $(this).data('permission');
    
    $('#'+permission+'_'+role).val($(this).prop('checked')? true : null);
});";
$this->registerJs($js);
?>