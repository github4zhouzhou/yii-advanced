<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CashTicketRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-ticket-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'event_id') ?>

    <?php // echo $form->field($model, 'expired_day') ?>

    <?php // echo $form->field($model, 'valid_day') ?>

    <?php // echo $form->field($model, 'money') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'ticket_level') ?>

    <?php // echo $form->field($model, 'real_money') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'message') ?>

    <?php // echo $form->field($model, 'refer_id') ?>

    <?php // echo $form->field($model, 'exchange_type') ?>

    <?php // echo $form->field($model, 'exchange_time') ?>

    <?php // echo $form->field($model, 'used_day') ?>

    <?php // echo $form->field($model, 'used_time') ?>

    <?php // echo $form->field($model, 'expired_time') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
