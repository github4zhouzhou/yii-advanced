<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ManualCert */

$this->title = 'Create Manual Cert';
$this->params['breadcrumbs'][] = ['label' => 'Manual Certs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manual-cert-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
