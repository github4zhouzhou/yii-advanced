<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ImagesManager */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Images Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-manager-view">

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
            'title',
            'active',
            'lang',
            'app_name',
            'app_id',
            'img',
            'desc:ntext',
            'create_time:datetime',
            'update_time:datetime',
            'publish_time:datetime',
            'url:url',
            'is_real',
            'parent_id',
            'sub_id',
            'img_type',
            'redirect',
            'valid_time:datetime',
            'stay',
            'sort',
            'platform',
            'is_rule',
            'rule',
        ],
    ]) ?>

</div>
