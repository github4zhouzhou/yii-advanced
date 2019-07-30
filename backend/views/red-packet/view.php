<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RedPacketRecord */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Red Packet Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="red-packet-record-view">

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
            'owner_id',
            'amount',
            'currency',
            'achieve_condition_type',
            'achieve_condition_value',
            'expire_hours',
            'relative_line',
            'status',
            'add_condition',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
