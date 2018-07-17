<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ImagesManagerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="images-manager-search">

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

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'publish_time') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'is_real') ?>

    <?php // echo $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'sub_id') ?>

    <?php // echo $form->field($model, 'img_type') ?>

    <?php // echo $form->field($model, 'redirect') ?>

    <?php // echo $form->field($model, 'valid_time') ?>

    <?php // echo $form->field($model, 'stay') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'is_rule') ?>

    <?php // echo $form->field($model, 'rule') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
