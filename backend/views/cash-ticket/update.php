<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CashTicket */

$this->title = 'Update Cash Ticket: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Cash Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cash-ticket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
