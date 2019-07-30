<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PopConfig */

$this->title = 'Update Pop Config: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Pop Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pop-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
