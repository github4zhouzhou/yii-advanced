<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ManualCert */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Manual Certs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manual-cert-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'country',
            'first_name',
            'last_name',
            'sex',
            'cert_type',
            'cert_number',
            'birthday',
            'address',
            'file1',
            'file2',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
