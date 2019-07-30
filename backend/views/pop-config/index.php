<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PopConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pop Configs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pop-config-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pop Config', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
			      'sort',
            'active',
            'lang',
            //'app_name',
            //'app_id',
            'img',
            'redirect',
            //'desc:ntext',
            'publish_time:datetime',
            'expired_time:datetime',

            //'scene',
            'pop_type',
            'pop_times:datetime',
            'pop_interval',
            //'after_click',
            //'after_close',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
