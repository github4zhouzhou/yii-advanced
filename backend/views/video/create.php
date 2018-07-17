<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
