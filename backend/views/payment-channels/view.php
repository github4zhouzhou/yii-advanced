<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentChannels */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payment Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-channels-view">

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
            'channel',
            'channelcode',
            'img',
            'max_amount',
            'min_amount',
            'platform',
            'country',
            'show_limit',
            'status',
            'sort',
            'created_at',
            'updated_at',
            'domain',
            'currency',
            'proportion',
            'fixed_fee',
            'which_fee',
            'open_mode',
            'server_label',
            'need_proof',
        ],
    ]) ?>

</div>
