<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DotConfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dot-config-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'path') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'platform') ?>

    <?= $form->field($model, 'package') ?>

    <?php // echo $form->field($model, 'time_period') ?>

    <?php // echo $form->field($model, 'publish_at') ?>

    <?php // echo $form->field($model, 'expired_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
