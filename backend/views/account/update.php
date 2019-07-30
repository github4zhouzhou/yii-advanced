<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AccountShowStyles */

$this->title = 'Update Account Show Styles: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Account Show Styles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="account-show-styles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
