<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CashTicket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'valid_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accept_period')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ticket_type')->textInput() ?>

    <?= $form->field($model, 'ticket_level')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expired_accept')->textInput() ?>

    <?= $form->field($model, 'dispatch_type')->textInput() ?>

    <?= $form->field($model, 'dispatch_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'extra_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
