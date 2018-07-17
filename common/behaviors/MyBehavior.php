<?php
/**
 * Created by PhpStorm.
 * User: vz
 * Date: 2018/7/4
 * Time: 下午8:01
 */

namespace common\behaviors;

use yii\base\Behavior;

class MyBehavior extends Behavior
{
    public $property = 'This is property in MyBehavior';

    public function method() {
        return 'Method in MyBehavior is called';
    }
}