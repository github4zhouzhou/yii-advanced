<?php
namespace console\controllers;

use common\models\WpfxFcHistory;
use common\models\WpfxFinancialCalendar;
use common\models\WpfxNewsFlash;
use yii\console\Controller;

class PocketFxController extends Controller
{
    public static $flash_list_url = 'http://news.wattforex.com/v1/newsList';
    public static $flash_detail_url = 'http://news.wattforex.com/v1/newsDetail';
    public static $calendar_list_url = 'http://news.wattforex.com/v1/calendars';
    //public static $calendar_list_url = 'http://news.wattforex.com/v1/calendars?offset=28800&time=';
    public static $calendar_detail_url = 'http://news.wattforex.com/v1/getCalendar';
    //public static $calendar_detail_url = 'http://news.wattforex.com/v1/getCalendar?lang=zh_CN&id=';
    public static $calendar_history_url = 'http://news.wattforex.com/v1/getIndex';
    //public static $calendar_history_url = 'http://news.wattforex.com/v1/getIndex?id=';


    public function actionFlashAll() {
        $i = 1;
        for($i = 5; $i < 10; $i++) {
            $this->actionFlash($i);
        }
    }

    private function parseFlash($url, $params) {
        $response = $this->dataCurl($url, $params);

        $list = json_decode($response, true);
        if (!$list) {
            $this->stdout('error flash result:'.$response.PHP_EOL);
            return;
        }

        if ($list['code'] == 'success') {
            $dataList = $list['result'];
        } else {
            $this->stdout('error flash code:'.$response.PHP_EOL);
            return;
        }

        $this->stdout('flash time:'.date('Y-m-d H:i:s', time()).',list count:'.count($dataList).PHP_EOL);

        foreach ($dataList as $item) {
            if (isset($item['flashId'])) {
                $pFlash = WpfxNewsFlash::findOne(['flash_id' => $item['flashId'], 'lang' => $params['lang']]);

                if (!$pFlash) {
                    $pFlash = new WpfxNewsFlash();
                }

                if (!$pFlash->content) {
                    // 由于列表里面 content 为空, 这里请求一次详情，获得 content 内容
                    $respDetail = $this->dataCurl(self::$flash_detail_url, ['lang' => $params['lang'], 'id' => $item['flashId']]);
                    $detail = json_decode($respDetail, true);
                    if ($detail && $detail['code'] == 'success') {
                        if (!empty($detail['result'])) {
                            $item = $detail['result'];
                            $pFlash->content = $item['content'];
                        }
                    }
                }

                // 更新语言，很重要，lang和flash_id唯一确定一条快讯
                $pFlash->lang = $params['lang'];

                // 更新非 content 字段
                $pFlash->flash_id = $item['flashId'];
                $pFlash->third_id = $item['thirdId'];
                $pFlash->platform_source = $item['platformSource'];
                $pFlash->type = $item['type'];
                $pFlash->timestamp = $item['timestamp'];
                $pFlash->source = $item['source'];
                $pFlash->title = $item['title'];

                $ret = $pFlash->save(false);
                if (!$ret) {
                    $this->stdout('flash_id:'.$pFlash->flash_id.', save fail'.PHP_EOL);
                }

            } elseif (isset($item['eventId'])) {

            } else {

            }
        }
    }

    public function actionFlash($index = 1) {
        $langs = ['zh_CN', 'en'];
        foreach ($langs as $lang) {
            $params = [
                'lang' => $lang,
                'pageIndex' => $index
            ];
            $this->parseFlash(self::$flash_list_url, $params);
        }
    }

    public function parseCalendar($url, $params) {
        $response = $this->dataCurl($url, $params);

        $list = json_decode($response, true);
        if (!$list) {
            $this->stdout('error calender time = ' .$params['time']. ', result:'.$response.PHP_EOL);
            return;
        }

        if ($list['code'] == 'success') {
            $dataList = $list['result'];
        } else {
            $this->stdout('error calendar code:'.$response.PHP_EOL);
            return;
        }

        $this->stdout('calendar:'.$params['time'].',time:'.date('Y-m-d H:i:s', time()).',list count:'.count($dataList).PHP_EOL);

        foreach ($dataList as $item) {
            $pCalendar = WpfxFinancialCalendar::findOne(['event_id' => $item['eventId'], 'lang' => $params['lang']]);
            if (!$pCalendar) {
                $pCalendar = new WpfxFinancialCalendar();
            }

            if (!$pCalendar->content) {
                // 由于列表里面 content 为空, 这里请求一次详情，获得 content 内容
                $detailParams = [
                    'lang' => $params['lang'],
                    'id' => $item['eventId']
                ];
                $respDetail = $this->dataCurl(self::$calendar_detail_url, $detailParams);
                $detail = json_decode($respDetail, true);
                if ($detail && $detail['code'] == 'success') {
                    if (!empty($detail['result'])) {
                        $item = $detail['result'];
                        $pCalendar->content = $item['content'];
                    }
                }
            }

            // 更新语言，很重要，lang和event_id唯一确定一条信息
            $pCalendar->lang = $params['lang'];

            // 更新非 content 字段
            $pCalendar->event_id = $item['eventId'];
            $pCalendar->type = $item['type'];
            $pCalendar->event_type = $item['eventType'];
            $pCalendar->data_tag = $item['dataTag'];
            $pCalendar->country = $item['country'];
            $pCalendar->country_code = $item['countryCode'];
            $pCalendar->currency = $item['currency'];
            $pCalendar->title = $item['title'];
            $pCalendar->important = $item['important'];
            $pCalendar->actual = $item['actual'];
            $pCalendar->forecast = $item['forecast'];
            $pCalendar->previous = $item['previous'];
            $pCalendar->revised = $item['revised'];
            $pCalendar->timestamp = $item['timestamp'];
            $pCalendar->meta_id = $item['metaId'];
            $pCalendar->platform_source = $item['platformSource'];
            $pCalendar->third_id = $item['thirdId'];
            $pCalendar->effect_rule = $item['effectRule'];
            $pCalendar->effect = $item['effect'];


            $ret = $pCalendar->save(false);
            if (!$ret) {
                $this->stdout('event_id:'.$pCalendar->event_id.', save fail'.PHP_EOL);
            }

            $pHistory = WpfxFcHistory::findOne(['event_id' => $item['eventId']]);
            if (!$pHistory) {
                // 由于列表里面 content 为空, 这里请求一次详情，获得 content 内容
                $historyParams = [
                    'lang' => $params['lang'],
                    'id' => $item['eventId']
                ];
                $respDetail = $this->dataCurl(self::$calendar_history_url, $historyParams);
                $detail = json_decode($respDetail, true);
                if ($detail && $detail['code'] == 'success') {
                    $dataResult = $detail['result'];
                    if (isset($dataResult['data'])) {
                        $pHistory = new WpfxFcHistory();
                        $pHistory->event_id = $item['eventId'];
                        $pHistory->data = json_encode($dataResult['data']);
                        $ret = $pHistory->save(false);
                        if (!$ret) {
                            $this->stdout('history, event_id:'.$pHistory->event_id.', save fail'.PHP_EOL);
                        }
                    }
                }
            }
        }
    }

    // time: -1 => 昨天, 0 => 今天, 1 => 明天 2 => 本周, 3 => 下周
    public function actionCalendar($time = 0) {
        $langs = ['zh_CN', 'en'];
        foreach ($langs as $lang) {
            $params = [
                'lang' => $lang,
                'offset' => 28800,
                'time' => $time
            ];
            $this->parseCalendar(self::$calendar_list_url, $params);
        }
    }


    /**
     * @param $url
     * @param bool $params 传递的参数
     * @param int $ispost 是否以POST提交，默认GET
     * @return bool|mixed 返回JSON数据
     */
    private function dataCurl($url, $params = false, $ispost = 0)
    {
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // http://stackoverflow.com/questions/4372710/php-curl-https
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
                } else {
                    curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
                }

            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);
        if ($response === FALSE) {
            // echo "cURL Error: " . curl_error($ch);
            return false;
        }
        //$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //$httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }
}