<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CashTicketRecord */

$this->title = '发放返现券';
$this->params['breadcrumbs'][] = ['label' => 'Cash Ticket Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-ticket-record-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
