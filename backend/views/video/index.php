<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '视频管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'beforeRow' => function($model, $key, $index, $grid) {
            if ($index == 0) {
                foreach ($grid->columns as $dataCol) {
                    if (empty($dataCol->contentOptions)) {
                        $dataCol->contentOptions = ['style' => 'text-align: center;'];
                    }
                }
            }
        },
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'url',
                'contentOptions' => ['style' => 'white-space: normal;word-break: break-word;min-width:100px'],
            ],
            'sort',
            [
                'attribute' => 'view_conditions',
                'filter' => \backend\models\Video::$arr_view_conditions,
                'value' => function ($model) {
                    //return \backend\models\Video::$arr_view_conditions[1];
                    if (!$model->view_conditions) {
                        return 0;
                    }
                    return $model->view_conditions;
                },
            ],
            [
                'attribute' => 'image',
                'format' => 'raw',
                'filter' => false,
                'value' => function ($model) {
                    //$domain = Yii::$app->params['domain.cdn'] ;
                    $domain = 'a';
                    return Html::img(sprintf("%s/%s", $domain, $model->image), ['width' => 'auto', 'height' =>25, 'max-width' => 100]);
                },
                'contentOptions' => ['width' => '5%'],
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'status',
                'filter' => \backend\models\Video::$arr_status,
                'value' => function ($model) {
                    return \backend\models\Video::$arr_status[$model->status];
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'category',
                'filter' => \backend\models\Video::$arr_cate,
                'value' => function ($model) {
                    return \backend\models\Video::$arr_cate[$model->category];
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'sub_category',
                'filter' => \backend\models\Video::$arr_sub_cate,
                'value' => function ($model) {
                    return \backend\models\Video::$arr_sub_category[$model->category][$model->sub_category];
                },
            ],
            //'custom:ntext',
            //'created_at',
            //'updated_at',

            [
                'template' => '{view} {update}',
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>
</div>
