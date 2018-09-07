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
use common\models\WpfxDynamicNews;
use common\models\WpfxFcHistory;
use common\models\WpfxFinancialCalendar;
use common\models\WpfxNewsFlash;
use PHPHtmlParser\Dom;
use Yii;
use yii\base\Controller;

/*
 *               (dev) /--j-------l--\
 * a-----c----e--f----h-----k--m-----n (master)
 * \--b-----d---/\--g---i-----/(test)
 *
 * reset 后的操作
 * master a
 * test b
 * master c
 * test d
 * master e
 * checkout test
 * merge master f
 * checkout master
 * merge test
 */
class TestController extends Controller
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionN() {
        $data = WpfxDynamicNews::findOne(['source' => 'Fx168']);

        $dom = new Dom();
        $dom->load($data->content);
        $h1 = $dom->find('h1')[0];
        $h1->delete();
        $dom->removeSelfClosingTag();
        var_dump($dom->__toString()); die();

        preg_match('/\<h1\>.*?\<\/h1\>/', $data->content, $matches);
        $ok = str_replace($matches[0], '', $data->content);
        preg_match('/\<h3\>.*?\<\/h3\>/', $ok, $matches);
        $ok = str_replace($matches[0], '', $ok);


        var_dump($ok);
    }

    public static function makeSource($url_path, $params)
    {
        // https://report.ubfx.co.uk/order/file?order=2478407&sign=Y36HLMyH9Sk1ChsLz3oaMiSmGb8%3D&time=1535437641&server=1
        $strs = rawurlencode($url_path .'&');

        ksort($params);
        $query_string = array();
        foreach ($params as $key => $val )
        {
            array_push($query_string, $key . '=' . $val);
        }
        $query_string = join('&', $query_string);

        return $strs . rawurlencode($query_string);
    }

    public static function makeCosSig($url_path, $params, $secret)
    {
        $mk = self::makeSource($url_path, $params);
        $my_sign = hash_hmac("sha1", $mk, strtr($secret, '-_', '+/'), true);
        $my_sign = base64_encode($my_sign);

        return $my_sign;
    }

    public function actionBank() {
        $this->layout = false;
        return $this->render('bank', [
            'order_id' => 'J859PPM2EWJK5BVL',
            'product' => '中国特种部队',
            'order_time' => date('Y-m-d', time()),
            'amount' => '659.00',
        ]);
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
        $url = 'https://report.ubfx.co.uk/order/file?order=2478407&sign=Y36HLMyH9Sk1ChsLz3oaMiSmGb8%3D&time=1535437641&server=1';
        $url = 'https://report.ubfx.co.uk/order/file';
        $params = [
            'order' => '2478407',
            'time' => '1535437641',
            'server' => '1',
        ];
        // $result = self::makeSource($url, $params);
        // https%3A%2F%2Freport.ubfx.co.uk%2Forder%2Ffile%26order%3D2478407%26server%3D1%26time%3D1535437641
        $result = self::makeCosSig($url, $params, '123');
        var_dump($result); die();
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

    /**
     * @param string $data
     * @return array|bool
     */
    private function recoverData($data)
    {
        // 异步
//        [
//            'Sign' => '64b62fa9cc515cb6243cab307376a05f1fac1e8b70cdddc22e4a1f278e66feb480df92ffe7c3f1b788be380ccfa7c12b5a1a5e12540f6b398bb29294bd17b98b',
//            'Data' => 'cU%CLiczM@ITN@cTMggjMtgDMtgTM*IjI@ISZtlGVyVGZy9kIsISWONkI@ISej5WZy%XdD%XZk%3Ti*iI*AjUTV0wDV1UiojIzVHdhR3Ui*iIzE2YiZzM5wmMmdjNtYTMi%WLyETZ00yYmFGNtczM5UGOxkDOiojIv5UZkFmLxIiOiwnb19WbB%XZk%3Ti*iINhjM6%TUNxkM4ckNMVkVK%iOi,mTyVGZy9kIsISNE1kI@ISZ*lHVudW6T%yeyJ9',
//        ]

        // 同步
//        [
//            'Sign' => 'a9c531ef781b4b58ce2a41f39fe4883c910e67c1a48a2ad2a085783073dab39093aa24704f537d2dc509c0ac5a0662db2489a667b9b2867f88acfdf0a8300ac6',
//            'Data' => 'gU2c1BCdv5GIvRkI@IyZz1EczVmUi*iIn5W6k5WZw%iOiMXd0FGdT%CLxojI05Wdv1WwyVGZy9kIsIST4IjWyEVTM%DOHZDTFZlSiojIv5kclRmcP%yeIucmbpN3clN2byBHIhRXYkBicvZGIzt2Yh%GbsF2YgMXdv52byh2Yul3cn0=',
//        ],
        if (!is_string($data)) return false;
        $data_str = preg_replace('/\s/', '', $data);
        if ($data_str != $data) return false;

        $suffix = substr($data_str, strlen($data_str) - 3, 3);
        $data_str = substr($data_str, 0, strlen($data_str) - 3);
        // reverse
        if (strlen($data_str) % 3 == 1) {
            $substr_len = (int) floor(strlen($data_str) / 3);
            $data_str_sub1 = substr($data_str, 0, $substr_len);
            $data_str_sub2 = substr($data_str, $substr_len, $substr_len);
            $data_str_sub3 = substr($data_str, $substr_len * 2, $substr_len + 1);
            $data_str = $data_str_sub2 . $data_str_sub1 . $data_str_sub3;
        }
        else if (strlen($data_str) % 3 == 2) {
            $substr_len = (int) floor(strlen($data_str) / 3);
            $data_str_sub1 = substr($data_str, 0, $substr_len + 2);
            $data_str_sub2 = substr($data_str, $substr_len + 2, $substr_len);
            $data_str_sub3 = substr($data_str, $substr_len * 2 + 2, $substr_len);
            $data_str = $data_str_sub3 . $data_str_sub1 . $data_str_sub2;
        }
        else {
            $substr_len = (int) floor(strlen($data_str) / 3);
            $data_str_sub1 = substr($data_str, 0, $substr_len);
            $data_str_sub2 = substr($data_str, $substr_len, $substr_len);
            $data_str_sub3 = substr($data_str, $substr_len * 2, $substr_len);
            $data_str = $data_str_sub2 . $data_str_sub3 . $data_str_sub1;
        }
        $data_str = strrev($data_str);
        // replace
        $data_str = str_replace('6', 'a', $data_str);
        $data_str = str_replace('w', 'Q', $data_str);
        $data_str = str_replace('%', 'J', $data_str);
        $data_str = str_replace('*', 'w', $data_str);
        $data_str = str_replace('@', '6', $data_str);
        $data_str = str_replace(',', '8', $data_str);

        $data_str = $data_str . $suffix;
        $data_str = base64_decode($data_str);

        if (!$data_str) return false;
        $data_array = json_decode($data_str, true);
        if (!is_array($data_array)) return false;

        return $data_array;
    }

    public function signParams($params) {
        ksort($params);
        $keys_str = implode('%#', array_keys($params));
        $values_str = implode(array_values($params));
        $str_to_sign = $keys_str . $values_str . '136ddeab162b23a810d8774088e1aa6baf880b65';
        return hash_hmac('sha512', $str_to_sign, 'cEFGh71Mno6RsStTvw7z');
    }
}