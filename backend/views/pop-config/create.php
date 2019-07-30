<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PopConfig */

$this->title = 'Create Pop Config';
$this->params['breadcrumbs'][] = ['label' => 'Pop Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pop-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
