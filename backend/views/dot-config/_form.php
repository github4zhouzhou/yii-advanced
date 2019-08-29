<?php

use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DotConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dot-config-form">

    <?php $form = ActiveForm::begin(); ?>

	  <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\DotConfig::statusList()) ?>

    <?= $form->field($model, 'platform')->dropDownList(\common\models\DotConfig::platformList()) ?>

    <?= $form->field($model, 'package')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_period')->textInput() ?>

    <?= $form->field($model, 'publish_at')->widget(
      DateTimePicker::class, [
          'model' => $model,
          'attribute' => 'publish_at',
			    'size' => 'md', //'lg', 'md', 'sm', 'xs'
          'layout' => "{picker}{input}{remove}",
          'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:00',
			      'todayBtn' => true,
			      'todayHighlight' => true,
			      'startDate' => date('Y-m-d H:i:s'),
          ]
        ]
    ) ?>

    <?= $form->field($model, 'expired_at')->widget(
      DateTimePicker::class, [
        'model' => $model,
        'attribute' => 'expired_at',
        'size' => 'md', //'lg', 'md', 'sm', 'xs'
        'layout' => "{picker}{input}{remove}",
        'pluginOptions' => [
          'autoclose' => true,
          'format' => 'yyyy-mm-dd hh:ii:00',
          'todayBtn' => true,
          'todayHighlight' => true,
          'startDate' => date('Y-m-d H:i:s'),
        ]
      ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
