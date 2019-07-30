<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentChannelsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-channels-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'channel') ?>

    <?= $form->field($model, 'channelcode') ?>

    <?= $form->field($model, 'img') ?>

    <?= $form->field($model, 'max_amount') ?>

    <?php // echo $form->field($model, 'min_amount') ?>

    <?php // echo $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'show_limit') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'domain') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'proportion') ?>

    <?php // echo $form->field($model, 'fixed_fee') ?>

    <?php // echo $form->field($model, 'which_fee') ?>

    <?php // echo $form->field($model, 'open_mode') ?>

    <?php // echo $form->field($model, 'server_label') ?>

    <?php // echo $form->field($model, 'need_proof') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
