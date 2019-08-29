<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CashTicketRecord */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cash Ticket Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-ticket-record-view">

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
            'mid',
            'name',
//            'status',
//            'event_id',
            'expired_day',
            'valid_day',
            'money',
            'color',
            'description',
//            'ticket_level',
            'real_money',
            'remark',
            'message',
            'refer_id',
//            'exchange_type',
//            'exchange_time:datetime',
//            'used_day',
//            'used_time:datetime',
//            'expired_time:datetime',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

</div>
