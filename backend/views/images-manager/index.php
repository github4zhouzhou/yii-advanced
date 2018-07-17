<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ImagesManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '图片管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-manager-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'active',
            'lang',
            'app_name',
            //'app_id',
            //'img',
            //'desc:ntext',
            //'create_time:datetime',

            //'url:url',
            //'is_real',
            //'parent_id',
            //'sub_id',
            'img_type',
            'redirect',
            'valid_time:datetime',
            //'stay',
            //'sort',
            'platform',
            //'is_rule',
            //'rule',
            'update_time:datetime',
            'publish_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
