<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RedPacketRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '定向红包记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="red-packet-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'owner_id',
            'amount',
            //'currency',
            [
              'attribute' => 'achieve_condition_type',
              'value' => function ($model) {
                return \common\models\RedPacketRecord::achieveConditionTypes()[$model->achieve_condition_type];
              }
            ],
            'achieve_condition_value',
            [
              'attribute' => 'relative_line',
              'value' => function ($model) {
                return \common\models\RedPacketRecord::relativeLines()[$model->relative_line];
              }
            ],
			      'expire_hours',
            [
				      'attribute' => 'status',
              'value' => function ($model) {
                return \common\models\RedPacketRecord::statusList()[$model->status];
              }
            ],
            //'add_condition',
            [
              'attribute' => 'created_at',
              'value' => function ($model) {
                return date('Y-m-d H:i:s', $model->created_at);
              }
            ],
            //'updated_at',

            [
              'class' => 'yii\grid\ActionColumn',
				      'header' => Yii::t('app', '操作'), // 列名
				      'template' => '{view} {delete}',
            ],
        ],
    ]); ?>
</div>
