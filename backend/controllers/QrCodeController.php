<?php
/**
 * Created by PhpStorm.
 * User: zhouzhou
 * Date: 2018/9/27
 * Time: 下午8:43
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class QrCodeController extends Controller
{
    public function actionIndex() {
        //$this->layout = false;
        return $this->render('index');
    }
}