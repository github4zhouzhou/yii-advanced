<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RedPacketRecord */

$this->title = 'Create Red Packet Record';
$this->params['breadcrumbs'][] = ['label' => 'Red Packet Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="red-packet-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
