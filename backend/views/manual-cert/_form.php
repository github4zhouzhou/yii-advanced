<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ManualCert;

/* @var $this yii\web\View */
/* @var $model common\models\ManualCert */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manual-cert-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'country')->dropDownList(ManualCert::countries()) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->dropDownList(ManualCert::sexes()) ?>

    <?= $form->field($model, 'cert_type')->dropDownList(ManualCert::certTypes()) ?>

    <?= $form->field($model, 'cert_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file1')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'file2')->fileInput(['accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
