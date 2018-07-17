<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\widgets\ActiveForm */

$test = function ($model) {
    return \backend\models\Video::getSubCate($model->category);
}

?>

<div class="video-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

<!--    --><?php //$form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->input('file') ?>
<!--    --><?//= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'view_conditions')->checkboxList(\backend\models\Video::$arr_view_conditions) ?>

    <?= $form->field($model, 'status')->dropDownList(\backend\models\Video::$arr_status) ?>

    <?= $form->field($model, 'category')->dropDownList(\backend\models\Video::$arr_cate, ['id' => 'category']) ?>

    <?= $form->field($model, 'sub_category')->dropDownList($test($model), ['id' => 'sub_category']) ?>

    <?= $form->field($model, 'sort')->textInput(['maxlength' => true, 'type' =>'integer']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$subCateUrl = Url::toRoute('sub-cate');
$categoryJs = <<<JS
    $("#category").change(function(event) {
        $.get('{$subCateUrl}', { id: $(this).children('option:selected').val() },
            function (data) {
                $("#sub_category").empty();
                $("#sub_category").append(data);
            }  
        );
    });
JS;
$this->registerJs($categoryJs);

?>