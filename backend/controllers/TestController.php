<?php
/**
 * Created by PhpStorm.
 * User: zhouzhou
 * Date: 2018/6/7
 * Time: 下午8:13
 */

namespace backend\controllers;

use common\models\TradeAccount;
use common\behaviors\MyBehavior;
use common\models\WpfxFcHistory;
use common\models\WpfxFinancialCalendar;
use common\models\WpfxNewsFlash;
use Yii;
use yii\base\Controller;

/*
 *               (dev) /--j-------l--\
 * a-----c----e--f----h-----k--m-----n (master)
 * \--b-----d---/\--g---i-----/(test)
 */
class TestController extends Controller
{
    public function actionIndex() {
        //$r = strtotime('20180716 08:07:48') . ',' . strtotime('2018-07-16T08:07:48.03Z');
        //$r = strtotime('20180716 08:07:48') - strtotime('2018-07-16T08:07:48.03Z');
//        $str = 'GetHistory([{afdfjkdjfkdjfkdjkfjdkfjdk}])';
//        preg_match('/GetHistory\((.*)\)/', $str, $matches);
//        var_dump($matches); die();

        $this->test();
    }

    public function actionNew() {
        $a = [];
        if (empty($a)) {
            echo 'a';
        } else {
            echo 'new';
        }
    }

    private function git() {
        return 'abcde';
    }

    public function test() {
        //return strtotime('2018-07-16T08:07:48.03Z');
        $time = 4;
        $oneDay = 86400;
        $now = time();
        $start_time = mktime(0,0,0,date("m",$now),date("d",$now),date("Y",$now));  //当天开始时间
        $end_time = mktime(23,59,59,date("m",$now),date("d",$now),date("Y",$now)); //当天结束时间

        var_dump(date('Y-m-d H:i:s', $start_time));
        var_dump(date('Y-m-d H:i:s', $end_time));

        if ($time == 1) { // 今天
        } elseif ($time == 0) { // 昨天
            $start_time = $start_time - $oneDay;
            $end_time = $end_time - $oneDay;
        } elseif ($time == 2) { // 明天
            $start_time = $start_time + $oneDay;
            $end_time = $end_time + $oneDay;
        } elseif ($time == 3) { // 本周
            $w = date('w', $now);
            $w = ($w + 6) % 7; // [1,2,3,4,5,6,0] => [0,1,2,3,4,5,6]
            $start_time = $start_time - ($oneDay * $w);
            $end_time = $end_time + $oneDay * (6 - $w);
        } elseif ($time == 4) { // 下周
            $w = date('w', $now);
            $w = ($w + 6) % 7; // [1,2,3,4,5,6,0] => [0,1,2,3,4,5,6]
            $start_time = $start_time + (7 - $w) * $oneDay;
            //$end_time = $end_time - ($oneDay * ($w+7)) + ($oneDay * 6);
            $end_time = $end_time + $oneDay * (13 - $w);
        }

        var_dump(date('Y-m-d H:i:s', $start_time));
        var_dump(date('Y-m-d H:i:s', $end_time));

        die();
    }

    public function sendSmsForXAUUSD()
    {
        $str = '"潘作伟",+8615050206855
"杨林",+8613405102969
"吴燕辉",+8615250221099
"颜芳",+8613451753157
"销售账号",+8613800138309
"跟单者5",+8613800138313
"跟单者7",+8613800138314
"高翠红",+8613671759649
"毛肜絮",+8615000000070
"周慧娟",+8613366634912
"郭星",+8615149828586
"于迪",+8613889895823
"明星账户1",+8618000000009
"明星账户2",+8618000000008
"熊梅",+8613466602067
"贾会娟",+8618101216639
"陈汉图",+8613267686141
"郭志",+8613888831617
"肇博",+8618640042707
"郭文",+8613062828750
"宛辉",+8613080864113
"何英辉",+8615710500111
"测试",+8613900139564
"朱晓晔",+8613918121410
"李春香",+8618511977839
"严大兴",+8618856933145
"付细香",+8615962401830
"颜友云",+8613087377264
"刘文翔",+8618763600526
"王其总",+8613567612709
"朱祥信",+8615960818221
"于家鹏",+8615840243542
"马城镇",+8618741007866
"柳海峰",+8615904510734
"杨文",+8615640545383
"张媛",+8615909524166
"089",+8615000000089
"纪振华",+8618351683810
"卢博",+8615204053118
"孙永刚",+8615940328521
"李玉玲",+8613820408577
"沈晓冬",+8615811568066
"陆毓龙",+8615940098044
"聂鹏飞",+8613180691333
"于洋",+8613332450702
"郭海波",+8615041231957
"黄文强",+8618081046852
"高翡",+8618292462738
"白亚辉",+8613904895152
"李东东",+8618781741600
"侯仰强",+8613071927559
"王九峰",+8613784942936
"韩翠海",+8613864892119
"夏依林",+8618721995137
"房玉梅",+8613941953700
"邢振武",+8613947981279
"周文奇",+8618551218448
"杨勇",+8613604908539
"邹玲玲",+8618246495113
"李娟娟",+8615246656923
"温丽雅",+8613821563593
"刘剑",+8617610401985
"李金波",+8613103722736
"侯国伟",+8613963819032
"常涛",+8615001031287
"李粉芳",+8618849008498
"佟延昭",+8615040246967
"王硕",+8615246807675
"程建法",+8613085881716
"张加微",+8615636336785
"林聪智",+8615678500504
"沈澍",+8615602115978
"周华建",+8617671725356
"于俪源",+8613166615755
"侯长皓",+8617640121122
"宋广滨",+8613898842777
"高梓淇",+8618524495878
"王娜",+8613386823895
"韩云利",+8613940145089
"王晓丹",+8615808963718
"杨京哲",+8615942059293
"李晓波",+8613166611553
"兰昊",+8613136003400
"陈健强",+8613602749432
"赵芯悦",+8615524128710
"王矜栋",+8618610738713
"巩晓丹",+8613188330002
"杨薇",+8613694180321
"戴波涛",+8615802498938
"李强",+8613358985980
"汤波",+8618640518601
"薛金凤",+8613125413946
"倪隽",+8615840587587
"肇舰",+8613591541976
"杨晋霞",+8613753607488
"葛茂祥",+8618602429999
"史琴",+8613635309568
"刘春林",+8617328578614
"李欣",+8615040826868
"李本龙",+8618613073146
"陈海军",+8613757356506
"胡永亮",+8613710533618
"崔国栋",+8615593988882
"周巍",+8618610032557';

        $array = explode(',', $str);

        $names = [];
        $phones = [];
        foreach ($array as $item) {
            $result = preg_match('/(\".*\"$)/', $item, $matches);
            if ($result) {
                $names[] = $matches[1];
            }
            $result = preg_match('/(^\+\d+)/', $item, $matches);
            if ($result) {
                $phones[] = $matches[1];
            }
        }

        $result = [];
        for($i = 0; $i < count($names); $i++) {
            $user = [];
            $user['name'] = substr($names[$i], 1, strlen($names[$i])-2);
            $user['phone'] = $phones[$i];
            $result[] = $user;

        }
        var_dump($result);
        //var_dump($phones);
        die();

    }

    public function actionCalendarList() {
        return 'ok';
    }

    // flash?pageSize=10&pageNum=1&lang=zh_CN
    public function actionFlash() {
//        $t = strtotime('Apr 10, 2017 12:04:14 AM');
//        var_dump(date('Y-m-d H:i:s', $t)); die();
//        date("F j,Y,g:i a);

        $pageNum = Yii::$app->request->get('pageNum', 1);
        $pageSize = Yii::$app->request->get('pageSize', 20);
        $lang = Yii::$app->request->get('lang', 'en');

        var_dump($lang);
        var_dump($pageNum);
        var_dump($pageSize);

        $list = WpfxNewsFlash::find()
            ->where(['lang' => $lang])
            ->orderBy(['timestamp' => SORT_DESC])
            ->offset(($pageNum - 1) * $pageSize)
            ->limit($pageSize)
            ->all();

        $result = [];
        foreach ($list as $item) {
            $result[] = date('Y-m-d H:i:s', $item['timestamp']);
            $result[] = $item['title'];
        }

        return json_encode($result);
    }

    public function actionCalendar() {
        $lang = Yii::$app->request->get('lang', 'en');
        $time = Yii::$app->request->get('time', 0);

        $oneDay = 86400;
        $bWeek = false; // 是不是取一周的数据
        $now = time();
        $start_time = mktime(0,0,0,date("m",$now),date("d",$now),date("Y",$now));  //当天开始时间
        $end_time = mktime(23,59,59,date("m",$now),date("d",$now),date("Y",$now)); //当天结束时间
        if ($time == 0) { // 今天
        } elseif ($time == -1) { // 昨天
            $start_time = $start_time - $oneDay;
            $end_time = $end_time - $oneDay;
        } elseif ($time == 1) { // 明天
            $start_time = $start_time + $oneDay;
            $end_time = $end_time + $oneDay;
        } elseif ($time == 2) { // 本周
            $w = date('w', $now);
            $w = ($w + 6) % 7; // [1,2,3,4,5,6,0] => [0,1,2,3,4,5,6]
            $start_time = $start_time - ($oneDay * $w);
            $end_time = $end_time + $oneDay * $w;
            $bWeek = true;
        } elseif ($time == 3) { // 下周
            $w = date('w', $now);
            $w = ($w + 6) % 7; // [1,2,3,4,5,6,0] => [0,1,2,3,4,5,6]
            $start_time = $start_time - ($oneDay * ($w+7));
            $end_time = $end_time + ($oneDay * ($w+7));
            $bWeek = true;
        }

        if ($bWeek) {
            $list = [];
            for($i = 1; $i <= 7; $i++) {
                $start = $start_time + $i * $oneDay; // 第 i 天 开始
                $end = $start + $oneDay - 1; // 第 i 天 结束
                $dayList = WpfxFinancialCalendar::find()
                    ->where(['lang' => $lang])
                    ->orderBy(['timestamp' => SORT_DESC])
                    ->andWhere(['>', 'timestamp', $start])
                    ->andWhere(['<', 'timestamp', $end])
                    ->all();

                $list[$i] = $dayList;
            }
        } else {
            $list = WpfxFinancialCalendar::find()
                ->where(['lang' => $lang])
                ->orderBy(['timestamp' => SORT_DESC])
                ->andWhere(['>', 'timestamp', $start_time])
                ->andWhere(['<', 'timestamp', $end_time])
                ->all();

        }

        $result = [];
        foreach ($list as $item) {
            $result[] = $item['event_id'];
        }

        return json_encode($result);

    }

    public function actionCalendarDetail() {
        $lang = Yii::$app->request->get('lang', 'en');
        $id = Yii::$app->request->get('id', 0);

        $item = WpfxFinancialCalendar::findOne(['lang' => $lang, 'event_id' => $id]);
        $history = WpfxFcHistory::findOne(['event_id' => $id]);

        return $history->event_id;
    }

    public function behaviorTest() {
        $myBehavior = new MyBehavior();
        $this->attachBehavior('myBehavior', $myBehavior);

        echo $this->property;
        echo PHP_EOL;
        echo $this->method();
    }

    public function isForbiddenEmail($email) {
        $aaaa = 'ubfx.co,ubfx.co.uk,ubankfx.com';
        $arr = explode(',', $aaaa);
        $eDomain = preg_replace('/(.*?)@/', '', $email);
        var_dump($eDomain); die();
        if (in_array($eDomain, $arr)) {
            return true;
        }
        return false; // 默认不是禁用邮箱
    }

    public function tradeAccount() {
        $account = TradeAccount::findOne(['login' => 681914130]);
        $account->balance = 600;
        var_dump('1');
        print_r("\n");
        var_dump($account->products);
        print_r("\n");
        $account->save(false);
        var_dump('2');
        print_r("\n");
        var_dump($account->products);
        print_r("\n");
        $account->score = 1.23;
        $account->save(false);
        var_dump('3');
        print_r("\n");
        var_dump($account->products);
        print_r("\n");
    }
}