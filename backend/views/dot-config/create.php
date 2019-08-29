<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DotConfig */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'DotConfig', 'url' => ['index']];
$this->params['breadcrumbs'][] = '创建';
?>
<div class="dot-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
