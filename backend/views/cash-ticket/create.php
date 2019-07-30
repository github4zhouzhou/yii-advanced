<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CashTicket */

$this->title = 'Create Cash Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Cash Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-ticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
