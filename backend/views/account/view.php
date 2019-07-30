<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AccountShowStyles */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Account Show Styles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-show-styles-view">

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
            'bg_color',
            'text_color',
            'login_group',
            'group_icon',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
