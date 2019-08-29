<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CashTicketRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-ticket-record-form">

    <?php $form = ActiveForm::begin(); ?>

	  <?= $form->field($model, 'ticket_level')->dropDownList(\common\models\CashTicketRecord::levelList()) ?>

    <?= $form->field($model, 'mid')->textInput() ?>

    <?= $form->field($model, 'expired_day')->textInput(['placeholder' => '从发放时刻算起，超过设置天数还未使用就过期']) ?>

    <?= $form->field($model, 'valid_day')->textInput(['placeholder' => '从使用时刻当天零点算起（北京时间）']) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true, 'placeholder' => '返现券一般都是活动领取或兑换，后台直接发放最好写个备注']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
