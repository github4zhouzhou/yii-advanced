<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DotConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '红点配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dot-config-index">


    <p>
        <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'path',
            [
              'attribute' => 'status',
              'value' => function ($model) {
                return \common\models\DotConfig::statusList()[$model->status];
              }
            ],
            [
              'attribute' => 'platform',
              'value' => function ($model) {
                return \common\models\DotConfig::platformList()[$model->platform];
              }
            ],
            'package',
            'time_period',
            [
              'attribute' => 'publish_at',
              'value' => function ($model) {
                return date('Y-m-d H:i:s', $model->publish_at);
              }
            ],
            [
              'attribute' => 'expired_at',
              'value' => function ($model) {
				        return date('Y-m-d H:i:s', $model->expired_at);
              }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
