<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="themes-list">
    <div class="row">
        <?php Pjax::begin(); ?>
        <?php foreach($themes as $theme):?>
        <div class="theme col-md-4 col-sm-6 col-xs-12">
            <?php if($theme->isActive()):?><span class="label label-success"><span class="glyphicon glyphicon-ok"></span></span><?php endif;?>
            <div class="wp-block inverse no-margin">
                <div class="img" style="background-image:url(data:image/png;base64,<?=$theme->screen?>)">
                </div>
                <h2 class="title"><?=$theme->name?></h2>
                <div class="active_wr">
                    <?=Html::a(
                        \Yii::t('app', 'Activate'), 
                        ['activate', 'name' => $theme->name], 
                        [
                            'class' => 'btn btn-'.($theme->isActive()? 'default disabled' : 'success'),
                            'data' => [
                                'pjax' => '0',
                                'confirm' => \Yii::t('app', 'Are you sure you want to activate this theme?'),
                                'method' => 'post'
                            ]
                        ]);?>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        <?php Pjax::end(); ?>
    </div>
</div>
<style>
.themes-list .img{
    width:100%;
    height:180px;
    background-size:contain;
    background-repeat:no-repeat;
}
.themes-list .theme{
    position:relative;
}
.themes-list h2{
    margin-top:5px;
}
.themes-list .theme > .label{
    position: absolute;
    top: -15px;
    left: 0;
    
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    font-size: 15px;
}
</style>