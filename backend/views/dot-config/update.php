<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DotConfig */

$this->title = 'Update Dot Config: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Dot Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dot-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
