<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PopConfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pop-config-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'active') ?>

    <?= $form->field($model, 'lang') ?>

    <?= $form->field($model, 'app_name') ?>

    <?php // echo $form->field($model, 'app_id') ?>

    <?php // echo $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'redirect') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'publish_time') ?>

    <?php // echo $form->field($model, 'expired_time') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'scene') ?>

    <?php // echo $form->field($model, 'pop_type') ?>

    <?php // echo $form->field($model, 'pop_times') ?>

    <?php // echo $form->field($model, 'pop_interval') ?>

    <?php // echo $form->field($model, 'after_click') ?>

    <?php // echo $form->field($model, 'after_close') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
