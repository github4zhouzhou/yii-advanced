<?php

use yii\helpers\Html;

$this->title = Yii::t('app', '');
$this->params['breadcrumbs'][] = Yii::t('app', '红点配置');

?>

<h1 class="page-header">
  <p>
	  <?= Html::a(Yii::t('app', '配置1'), ['/dot-config/index'], ['class' => 'btn  btn-success']) ?>
	  <?= Html::a(Yii::t('app', '配置2'), ['/dot-config/test'], ['class' => 'btn  btn-success']) ?>
  </p>
</h1>

<table id="table-main" class="table table-striped" width="100%">
  <thead>
    <tr>
      <th><?= Yii::t('app', 'ID') ?></th>
      <th><?= Yii::t('app', '位置') ?></th>
      <th><?= Yii::t('app', '状态') ?></th>
      <th><?= Yii::t('app', '平台') ?></th>
      <th><?= Yii::t('app', '包名') ?></th>
      <th><?= Yii::t('app', '时间段') ?></th>
      <th><?= Yii::t('app', '发布时间') ?></th>
      <th><?= Yii::t('app', '过期时间') ?></th>
    </tr>
    <tr>
      <th><input style="width: 30px;"></th>
      <th><select class="form-control input-sm" id="filter_status" style="width: 50px;"></select></th>
      <th><select class="form-control input-sm" id="filter_status" style="width: 50px;"></select></th>
      <th><select class="form-control input-sm" id="filter_status" style="width: 50px;"></select></th>
    </tr>
  </thead>
</table>

<script>
  window.onload = function () {
    var editor = new $.fn.dataTable.Editor({
      domTable: "#table-main",
      idSrc: "id",
      fields: [],
    });

    var table = {}
    table = $('#table-main').DataTable({
      columns:[
        {data: ''}
      ],
    });
  }
</script>