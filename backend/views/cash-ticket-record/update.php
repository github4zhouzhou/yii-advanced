<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CashTicketRecord */

$this->title = 'Update Cash Ticket Record: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Cash Ticket Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cash-ticket-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
