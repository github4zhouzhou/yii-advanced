<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AccountShowStyles */

$this->title = 'Create Account Show Styles';
$this->params['breadcrumbs'][] = ['label' => 'Account Show Styles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-show-styles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
