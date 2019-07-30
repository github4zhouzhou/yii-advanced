<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PopConfig */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pop Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pop-config-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'active',
            'lang',
            'app_name',
            'app_id',
            'img',
            'redirect',
            'desc:ntext',
            'publish_time:datetime',
            'expired_time:datetime',
            'sort',
            'scene',
            'pop_type',
            'pop_times:datetime',
            'pop_interval',
            'after_click',
            'after_close',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
