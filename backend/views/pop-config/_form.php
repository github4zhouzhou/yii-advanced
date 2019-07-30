<?php

use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PopConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pop-config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\PopConfig::statusList()) ?>

    <?= $form->field($model, 'lang')->dropDownList(\common\models\PopConfig::langList()) ?>

<!--    --><?//= $form->field($model, 'app_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'scene')->dropDownList(\common\models\PopConfig::sceneList()) ?>

    <?= $form->field($model, 'pop_type')->dropDownList(\common\models\PopConfig::typeList()) ?>

    <?= $form->field($model, 'pop_times')->textInput() ?>

    <?= $form->field($model, 'pop_interval')->dropDownList(\common\models\PopConfig::intervalList()) ?>

    <?= $form->field($model, 'after_click')->dropDownList(\common\models\PopConfig::afterClickList()) ?>

    <?= $form->field($model, 'after_close')->dropDownList(\common\models\PopConfig::afterCloseList()) ?>

    <?= $form->field($model, 'app_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'redirect')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publish_time')->widget(
      DateTimePicker::className(),
      [
        'model' => $model,
        'attribute' => 'publish_time',
        //'options' => ['placeholder' => '发布时间'],
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
    ); ?>

    <?= $form->field($model, 'expired_time')->widget(
      DateTimePicker::className(),
      [
        'model' => $model,
        'attribute' => 'expired_time',
        //'options' => ['placeholder' => '发布时间'],
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
    ); ?>

    <?= $form->field($model, 'sort')->textInput() ?>

	  <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
