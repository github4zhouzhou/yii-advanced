<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\RedPacketRecord;

/* @var $this yii\web\View */
/* @var $model common\models\RedPacketRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="red-packet-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'owner_id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->dropDownList(RedPacketRecord::currencyList()) ?>

    <?= $form->field($model, 'achieve_condition_type')->dropDownList(RedPacketRecord::achieveConditionTypes()) ?>

    <?= $form->field($model, 'achieve_condition_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expire_hours')->textInput() ?>

    <?= $form->field($model, 'relative_line')->dropDownList(RedPacketRecord::relativeLines()) ?>

<!--    --><?//= $form->field($model, 'status')->textInput() ?>

    <div id="rp_add_condition" style="margin-bottom: 10px;">
      <div style="margin-bottom: 8px; font-weight: 600;"><?= Yii::t('app', '附加条件') ?></div>
      <select style="display: inline; width: 10%;" class="form-control" name="RedPacketRecord[add-condition-from]">
		  <?foreach(RedPacketRecord::otherRelativeLines() as $key => $val):?>
        <option value="<?=$key ?>"> <?= $val ?></option>
	    <?endforeach?>
      </select>
      <?= Yii::t('app', '后') ?>
      <input type="text" style="display: inline; width: 20%" class="form-control" placeholder="<?= Yii::t('app', '天数') ?>" name="RedPacketRecord[add-condition-day]" value="" />
      <?= Yii::t('app', '天累计完成') ?>
      <input type="text" style="display: inline; width: 20%" class="form-control" placeholder="<?= Yii::t('app', '手数') ?>" name="RedPacketRecord[add-condition-hand]" value="" />
      <?= Yii::t('app', '手') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
