<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountShowStylesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Account Show Styles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-show-styles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Account Show Styles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bg_color',
            'text_color',
            'login_group',
            [
				      'attribute' => 'group_icon',
//				      'format' => 'raw',
				      'filter' => false,
				      'value' => function ($model) {
                if (strlen($model->group_icon) > 100) {
                  return substr($model->group_icon, 0, 100);
                } else {
                  return $model->group_icon;
                }
				      },
				      'contentOptions' => ['width' => '20%'],
            ],

            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
