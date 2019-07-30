<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CashTicket */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cash Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-ticket-view">

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
            'event_id',
            'status',
            'valid_month',
            'accept_period',
            'color',
            'ticket_type',
            'ticket_level',
            'title',
            'description',
            'expired_accept',
            'dispatch_type',
            'dispatch_value',
            'extra_data:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
