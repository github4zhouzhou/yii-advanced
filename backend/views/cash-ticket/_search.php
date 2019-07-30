<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CashTicketSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-ticket-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'event_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'valid_month') ?>

    <?= $form->field($model, 'accept_period') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'ticket_type') ?>

    <?php // echo $form->field($model, 'ticket_level') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'expired_accept') ?>

    <?php // echo $form->field($model, 'dispatch_type') ?>

    <?php // echo $form->field($model, 'dispatch_value') ?>

    <?php // echo $form->field($model, 'extra_data') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
