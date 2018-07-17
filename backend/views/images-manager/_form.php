<?php

use common\models\ImagesManager;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\ImagesManager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="images-manager-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->dropDownList(ImagesManager::$s_active) ?>

    <?= $form->field($model, 'lang')->dropDownList(ImagesManager::$s_lang) ?>

    <?= $form->field($model, 'app_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'publish_time')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_real')->textInput() ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'sub_id')->textInput() ?>

    <?= $form->field($model, 'img_type')->textInput() ?>

    <?= $form->field($model, 'redirect')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valid_time')->textInput() ?>

    <?= $form->field($model, 'stay')->textInput() ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'platform')->textInput() ?>

    <?= $form->field($model, 'is_rule')->textInput() ?>

    <?= $form->field($model, 'rule')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
