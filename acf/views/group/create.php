<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model t2cms\acf\models\AcfGroup */

$this->title = Yii::t('app', 'Create Field Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Field Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acf-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
