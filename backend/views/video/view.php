<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$viewConditions = function ($model) {
   if ($model->view_conditions > 0) {
       $result = [];
       if ($model->view_conditions & \backend\models\Video::VIEW_COND_LOGIN) {
           $result[] = \backend\models\Video::$arr_view_conditions[\backend\models\Video::VIEW_COND_LOGIN];
       }
       if ($model->view_conditions & \backend\models\Video::VIEW_COND_DEPOSIT) {
           $result[] = \backend\models\Video::$arr_view_conditions[\backend\models\Video::VIEW_COND_DEPOSIT];
       }
       return json_encode($result, JSON_UNESCAPED_UNICODE);
   } else {
       return '无';
   }
}
?>
<div class="video-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'url:url',
            'image:url',
            'sort',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return \backend\models\Video::$arr_status[$model->status];
                },
            ],
            [
                'attribute' => 'view_conditions',
                'value' => $viewConditions($model),
            ],
            [
                'attribute' => 'category',
                'value' => function($model){
                    return \backend\models\Video::$arr_cate[$model->category];
                },
            ],
            [
                'attribute' => 'sub_category',
                'value' => function($model){
                    return \backend\models\Video::$arr_sub_category[$model->category][$model->sub_category];
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => date('Y-m-d H:i:s', $model->created_at),
            ],
            [
                'attribute' => 'updated_at',
                'value' => date('Y-m-d H:i:s', $model->updated_at),
            ],
        ],
    ]) ?>

</div>
