<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DotConfig */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dot Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dot-config-view">

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
            'path',
            'status',
            'platform',
            'package',
            'time_period',
            'publish_at',
            'expired_at',
        ],
    ]) ?>

</div>
