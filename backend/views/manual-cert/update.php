<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ManualCert */

$this->title = 'Update Manual Cert: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Manual Certs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="manual-cert-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
