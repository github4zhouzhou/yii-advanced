<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PaymentChannels */

$this->title = 'Create Payment Channels';
$this->params['breadcrumbs'][] = ['label' => 'Payment Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-channels-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
