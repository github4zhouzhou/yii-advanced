<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CashTicketRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '发放返现券';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-ticket-record-index">

    <p>
        <?= Html::a('发放返现券', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'mid',
            'name',
            [
              'attribute' => 'status',
              'value' => function ($model) {
                return \common\models\CashTicketRecord::statusList()[$model->status];
              }
            ],
            'money',
            //'expired_day',
            'valid_day',
			      'event_id',
            //'real_money',
            //'remark',
            //'message',
            [
              'attribute' => 'exchange_type',
              'value' => function ($model) {
                return \common\models\CashTicketRecord::exchangeTypeList()[$model->exchange_type];
              }
            ],
            [
              'attribute' => 'exchange_time',
              'value' => function ($model) {
                if ($model->exchange_time > 0) {
					        return date('Y-m-d H:i:s', $model->exchange_time);
                }
				        return 'xxxx-xx-xx xx:xx:xx';
              }
            ],
            [
              'attribute' => 'used_time',
              'value' => function ($model) {
				        if ($model->used_time > 0) {
					        return date('Y-m-d H:i:s', $model->used_time);
                }
                return 'xxxx-xx-xx xx:xx:xx';
              }
            ],
            [
              'attribute' => 'expired_time',
              'value' => function ($model) {
                return date('Y-m-d H:i:s', $model->expired_time);
              }
            ],
            [
              'attribute' => 'created_at',
              'value' => function ($model) {
                return date('Y-m-d H:i:s', $model->created_at);
              }
            ],
            //'updated_at',

            [
				      'template' => '{view}',
              'class' => 'yii\grid\ActionColumn'
            ],
        ],
    ]); ?>
</div>
