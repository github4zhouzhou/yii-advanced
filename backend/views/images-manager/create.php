<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ImagesManager */

$this->title = 'Create Images Manager';
$this->params['breadcrumbs'][] = ['label' => 'Images Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-manager-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
