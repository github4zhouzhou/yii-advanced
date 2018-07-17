<?php

use backend\models\PaymentChannels;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentChannelsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Channels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-channels-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Payment Channels', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'caption' => 'GridView',
        'captionOptions' => ['style' => 'text-align: center;'],
        'dataColumnClass' => 'yii\grid\DataColumn', // 默认 yii\grid\DataColumn
        'emptyCell' => '<p style="background-color: #c55;">good</p>',
        'emptyText' => 'ok',
        'afterRow' => function($model, $key, $index, $grid) {
            //var_dump($grid->getId());
            //$dataCol = $grid->columns[11];
            //var_dump($dataCol->attribute);
        },
        'beforeRow' => function($model, $key, $index, $grid) {
//            if ($index % 2 == 0) {
//                $dataCol = $grid->columns[11];
//                $dataCol->contentOptions = ['style' => 'text-align: center; background-color: #c55;'];
//            }
        },
        'columns' => [
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'id',
                'contentOptions' => ['width' => '1%', 'style' => 'text-align: center;'],
            ],
            'channel',
            'channelcode',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'img',
                'filter' => false,
                'value' => function($model){
                    return "<img style='max-width: 100px;' src='/{$model->img}'>";
                },
                'format' => 'raw'
            ],
            'max_amount',
            //'min_amount',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'platform',
                'filter' => PaymentChannels::$s_platforms,
                'value' => function($model){
                    return implode(', ', $model->platform);
                },
                'contentOptions' => ['style' => 'white-space: normal;word-break: break-word;min-width:90px', 'width' => '5%'],
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'country',
                'filter' => PaymentChannels::$s_countries,
                'value' => function($model) {
                    return implode(', ', $model->country);
                },
                'contentOptions' => ['style' => 'white-space: normal;word-break: break-word;min-width:90px', 'width' => '5%'],

            ],
            //'show_limit',
            [
                'attribute' => 'status',
                'filter' => PaymentChannels::$s_status,
                'value' => function($model) {return PaymentChannels::$s_status[$model->status];},
                'contentOptions' => ['style' => 'text-align: center;']
            ],
            //'sort',
            //'created_at',
            //'updated_at',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'domain',
                'filter' => Yii::$app->params['domains'],
                'value' => function($data){
                    return implode(', ', $data->domain);
                },
                'contentOptions' => ['style' => 'white-space: normal;word-break: break-word;min-width:90px', 'width' => '6%'],

            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'currency',
                'value' => function($model) {
                    return null;
                }
            ],
            //'proportion',
            //'fixed_fee',
            //'which_fee',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'open_mode',
                'filter' => PaymentChannels::$s_open_modes,
                'value' => function($model) {
                    return PaymentChannels::$s_open_modes[$model->open_mode];
                }
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'server_label',
                'filter' => PaymentChannels::$s_server_labels,
                'value' => function($model) {
                    //return implode(', ',$model->server_label);

                    $result = [];
                    foreach ($model->server_label as $val) {
                        $result[] = PaymentChannels::$s_server_labels[$val];
                    }
                    return implode(', ',$result);
                },
            ],
            [
                'attribute' => 'need_proof',
                'filter' => PaymentChannels::$show_proof,
                'value' => function($model) {return PaymentChannels::$show_proof[$model->need_proof];},
                'contentOptions' => function($model, $key, $index, $column) {
                    if ($model->need_proof) {
                        return ['style' => 'text-align: center; background-color: #c55;'];
                    } else {
                        return ['style' => 'text-align: center;'];
                    }
                }
            ],
        ],
    ]); ?>
</div>
