<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentChannels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-channels-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'channelcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_amount')->textInput() ?>

    <?= $form->field($model, 'min_amount')->textInput() ?>

    <?= $form->field($model, 'platform')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'show_limit')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proportion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fixed_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'which_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'open_mode')->textInput() ?>

    <?= $form->field($model, 'server_label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'need_proof')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
