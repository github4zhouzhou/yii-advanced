<?php
namespace console\controllers;

use common\models\WpfxDynamicNews;
use common\models\WpfxFcHistory;
use common\models\WpfxFinancialCalendar;
use common\models\WpfxNewsFlash;
use yii\console\Controller;

use Yii;

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

    public function actionTest() {
        $countyStr = Yii::$app->params['country.info'];
        $counties = json_decode($countyStr, true);
        $result = [];
        foreach ($counties as $key => $county) {
            $countryCode = $county['name'];
            $county['code'] = $key;
            $result[$countryCode] = $county;
        }
        var_dump($result); die();
    }

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

    public function actionCalendarFxStreetDaily() {
        $now = time();
        $oneDay = 86400;
        $url = 'http://calendar.fxstreet.com/eventdate/';
        for ($i = 0; $i < 14; $i++) {
            $params = [
                'view' => 'range',
                'start' => date('Ymd', $now + ($i * $oneDay)),
                'end' => date('Ymd', $now + ($i * $oneDay)),
                'k' => '9A43BED21AF44620BE15',
                't' => date('YmdHis', time()),
                's' => 'c2cd3082fb5c0d5d4f2bfbdef1c8cd0a73da82b3',
                'f' => 'json'
            ];
            $this->parseCalendarFxStreet($url, $params);
        }
    }

    public function actionFxStreet() {
        $url = 'http://calendar.fxstreet.com/eventdate/';
        $params = [
            'view' => 'range',
            'start' => date('Ymd', time()),
            'end' => date('Ymd', time()),
            'k' => '9A43BED21AF44620BE15',
            't' => date('YmdHis', time()),
            's' => 'c2cd3082fb5c0d5d4f2bfbdef1c8cd0a73da82b3',
            'f' => 'json'
        ];

        // $s = 'c2cd3082fb5c0d5d4f2bfbdef1c8cd0a73da82b3';
        // $s = 'f218a121569da40a3511d8e2d486b191e3dbded8';
        // Yii::$app->params['new']['calendar']['s'];
        $this->parseCalendarFxStreet($url, $params);
    }

    public function parseCalendarFxStreet($url, $params) {
        $result = $this->dataCurl($url, $params);
        $list = json_decode($result, true);
        if (!$list || !is_array($list)) {
            $this->stdout('fx-street-calendar,time:'.date('Y-m-d H:i:s', time()).',error list 0'.PHP_EOL);
            return;
        }

        $lang = 'en';
        $source = 'fx-street-calendar';
        $detailUrl = 'http://calendar.fxstreet.com/eventdate/';
        foreach ($list as $item) {
            $tmpUrl = $detailUrl . $item['IdEcoCalendarDate'] . '/';
            $tmpParams = [
                'k' => $params['k'],
                't' => $params['t'],
                's' => $params['s'],
                'f' => 'json'
            ];

            $str = $this->dataCurl($tmpUrl, $tmpParams);
            $data = json_decode($str, true);

            $pCalendar = WpfxFinancialCalendar::findOne(['event_id' => $data['IdEcoCalendarDate'], 'lang' => $lang, 'platform_source' => $source]);
            if (!$pCalendar) {
                $pCalendar = new WpfxFinancialCalendar();
            }

            $pCalendar->title = $data['Name'];
            $pCalendar->event_id = $data['IdEcoCalendarDate'];
            if ($data['Speech']) {
                $pCalendar->data_tag = 'speech';
            } elseif ($data['Report']) {
                $pCalendar->data_tag = 'report';
            }
            $pCalendar->country = $data['Country'];
            $pCalendar->country_code = $data['InternationalCode'];
            $pCalendar->currency = $data['Currency'];
            $pCalendar->content = $data['HTMLDescription'];
            $pCalendar->important = $data['Precision'];
            if ($data['Actual']) {
                $pCalendar->actual = $data['Actual'];
            }
            if ($data['Previous']) {
                $pCalendar->previous = $data['Previous'];
            }
            if ($data['Consensus']) {
                $pCalendar->forecast = $data['Consensus'];
            }
            if ($data['Revised']) {
                $pCalendar->revised = $data['Revised'];
            }
            $pCalendar->timestamp = strtotime($data['DateTime']['Date']);
            $pCalendar->lang = $lang;
            $pCalendar->meta_id = $data['IdEcoCalendar'];
            $pCalendar->platform_source = $source;
            $pCalendar->event_type = $data['EcoCalendarType'];
            $pCalendar->type = 1;

            $ret = $pCalendar->save(false);
            if (!$ret) {
                $this->stdout('fx-street-calendar,time:'.date('Y-m-d H:i:s', time()).',error:'.json_encode($pCalendar->getErrors()).PHP_EOL);
            }
        }
    }

    public function actionSinaCalendarDaily() {
        $now = time();
        $oneDay = 86400;

        $countyStr = Yii::$app->params['country.info'];
        $countryArray = json_decode($countyStr, true);
        $countries = [];
        foreach ($countryArray as $key => $county) {
            $countryCode = $county['name'];
            $county['code'] = $key;
            $countries[$countryCode] = $county;
        }

        $url = 'https://rl.cj.sina.com.cn/client/api/calendar_v2/get_economic_lists';
        for ($i = 0; $i < 14; $i++) {
            $params = [
                'start_time' => date('Y-m-d', $now + ($i * $oneDay)),
                'end_time' => date('Y-m-d', $now + ($i * $oneDay)),
                'page' => 1,
                'version' => '4.3.2'
            ];

            var_dump($params);

            $this->parseSinaCalendar($url, $params, $countries, 1);
        }
    }

    public function actionSinaCalendar($page = 1) {
        // https://rl.cj.sina.com.cn/client/api/calendar_v2/get_economic_lists?start_time=2018-07-20&end_time=2018-07-20&level=&country=&page=1&version=4.3.2
        // https://rl.cj.sina.com.cn/client/api/calendar_v2/get_meet_lists?start_time=2018-07-20&end_time=2018-07-20&page=1&version=4.3.2

        $params = [
            'start_time' => date('Y-m-d', time()),
            'end_time' => date('Y-m-d', time()),
            'page' => $page,
            'version' => '4.3.2'
        ];

        $url = 'https://rl.cj.sina.com.cn/client/api/calendar_v2/get_economic_lists';

        $countyStr = Yii::$app->params['country.info'];
        $countryArray = json_decode($countyStr, true);
        $countries = [];
        foreach ($countryArray as $key => $county) {
            $countryCode = $county['name'];
            $county['code'] = $key;
            $countries[$countryCode] = $county;
        }

        $this->parseSinaCalendar($url, $params, $countries, 1);
    }

    private function parseSinaCalendar($url, $params, $countries, $type) {
        $result = $this->dataCurl($url, $params);
        $list = json_decode($result, true);

        $parseResult = false;
        if (isset($list['result']) && isset($list['result']['status'])) {
            if ($list['result']['status']['msg'] == 'succ') {
                $parseResult = true;
            }
        }

        if (!$parseResult) {
            $this->stdout('sina calendar:'.',time:'.date('Y-m-d H:i:s', time()).',parse result false'.PHP_EOL);
            return;
        }

        $data = $list['result']['data'];
        if ($data['total_num'] <= 0) {
            var_dump('total_num = 0');
            return;
        }
        $dataList = $data['data'];
        $this->stdout('sina calendar,'.',time:'.date('Y-m-d H:i:s', time()).',list count:'.count($dataList).PHP_EOL);

        $lang = 'zh_CN';
        $source = 'sina-calendar';
        $tmpUrl = 'https://rl.cj.sina.com.cn/client/api/calendar_v1/get_detail';
        foreach ($dataList as $item) {
            $tmpParams = [
                'type' => $type,
                'id' => $item['id'],
                'version' => $params['version']
            ];
            $tmpResult = $this->dataCurl($tmpUrl, $tmpParams);

            $dataDetail = json_decode($tmpResult, true);
            $data = $dataDetail['result']['data'];

            $pCalendar = WpfxFinancialCalendar::findOne(['event_id' => $data['id'], 'lang' => $lang, 'platform_source' => $source]);
            if (!$pCalendar) {
                $pCalendar = new WpfxFinancialCalendar();
            }

            $pCalendar->title = $data['title'];
            $pCalendar->event_id = $data['id'];


            if (isset($data['country_info'])) {
                $countryInfo = $data['country_info'];
                $pCalendar->country = $countryInfo['name'];
                if (isset($countries[$pCalendar->country])) {
                    $pCalendar->country_code = $countries[$pCalendar->country]['code'];
                    $pCalendar->currency = $countries[$pCalendar->country]['currency'];
                } else {
                    $this->stdout('sina calendar:'.',time:'.date('Y-m-d H:i:s', time()).', country name:'. $countryInfo['name'] .PHP_EOL);
                }
            }

            if ($data['paraphrase'] && $data['interpret']) {
                $pCalendar->content = $data['paraphrase'] . "\n" .$data['interpret'];
            } elseif ($data['paraphrase']) {
                $pCalendar->content = $data['paraphrase'];
            } elseif ($data['interpret']) {
                $pCalendar->content = $data['interpret'];
            }
            $pCalendar->important = $data['importance'];

            $pCalendar->previous = $data['pre_value']; // todo 单位
            $pCalendar->actual = $data['real_value'];
            $pCalendar->forecast = $data['fur_value'];

            $pCalendar->timestamp = strtotime($data['publish_time']); // todo 搞清楚时区
            $pCalendar->lang = $lang;
            $pCalendar->platform_source = $source;
            $pCalendar->type = 1;

            $ret = $pCalendar->save(false);
            if (!$ret) {
                $this->stdout('sina calendar save false:'.json_encode($pCalendar->getErrors()));
                return;
            }

//            if ($data['history_data']) {
//                $historyData = $data['history_data'];
//                if (empty($historyData)) {
//                    continue;
//                }
//
//                $historyItem = WpfxFcHistory::findOne(['source' => $source, 'event_id' => $pCalendar->event_id]);
//                if ($historyItem) {
//                    continue;
//                }
//                $historyItem = new WpfxFcHistory();
//
//                $hResult = [];
//                foreach ($historyData as $hData) {
//                    $tmpData = [];
//                    $tmpData['historyId'] = $hData['id'];
//                    $tmpData['timestamp'] = strtotime($hData['publish_time']);
//                    $tmpData['previous'] = $hData['pre_value'];
//                    $tmpData['actual'] = $hData['real_value'];
//                    $tmpData['forecast'] = $hData['fur_value']; // todo 单位
//                    $hResult[] = $tmpData;
//                }
//
//                $historyItem->event_id = $pCalendar->event_id;
//                $historyItem->source = $source;
//                $historyItem->data = json_encode($hResult);
//
//                $historyItem->save(false);
//            }

        }


    }

    public function actionFlash2() {
        // http://data.fxstreet.com/news/?fields=Title&key=englishnewscharts&pageNumber=1&pageSize=10&tags=
        // http://data.fxstreet.com/news/?fields=Title&key=englishnewscharts&pageNumber=1&pageSize=10&tags=
        $url = 'http://data.fxstreet.com/news/';
        $params = [
            'fields' => 'Title',
            'key' => 'englishnewscharts',
            'pageNumber' => 1,
            'pageSize' => 10,
        ];

        $result = $this->dataCurl($url, $params);
        $list = json_decode($result, true);

        foreach ($list as $item) {
            // http://data.fxstreet.com/news/865cab51-4921-1f89-f67c-7ce6acbed572/body
            $tmpUrl = 'http://data.fxstreet.com/news/' . $item['Id'] . '/body';
            var_dump($item['Title']);

            $result = $this->dataCurl($tmpUrl);
            $dList = json_decode($result, true);
            var_dump($dList[0]);


        }
    }

    // fxstreet 的动态资讯
    public function actionDynamicFxStreet($pageNum = 1) {
        $url = 'http://data.fxstreet.com/news/';
        $params = [
            'fields' => 'Title',
            'key' => 'englishnewscharts',
            'pageNumber' => $pageNum,
            'pageSize' => 20,
        ];

        $result = $this->dataCurl($url, $params);
        $list = json_decode($result, true);

        // 语言和来源固定
        $lang = 'en';
        $source = 'fxstreet-news';

        foreach ($list as $item) {

            $dNews = WpfxDynamicNews::findOne(['doc_id' => $item['Id'], 'lang' => $lang, 'source' => $source]);
            if ($dNews) {
                continue;
            }
            $dNews = new WpfxDynamicNews();



            // http://data.fxstreet.com/news/865cab51-4921-1f89-f67c-7ce6acbed572/body
            $tmpUrl = 'http://data.fxstreet.com/news/' . $item['Id'] . '/body';
            $result = $this->dataCurl($tmpUrl);
            $dList = json_decode($result, true);
            if (is_array($dList)) {
                $dNews->content = $dList[0]['Body'];
            }

            $dNews->doc_id = $item['Id'];
            $dNews->lang = $lang;
            $dNews->source = $source;
            $dNews->title = $item['Title'];
            $dNews->detail_url = 'http://data.fxstreet.com/news/' . $item['Id'] . '/body';
            $dNews->timestamp = strtotime($item['Timestamp']);
            $dNews->summary = $item['Summary'];
            $dNews->tags = implode(',', $item['TAGs']);
            $dNews->first_key = '';
            $dNews->lmid = 0;
            $dNews->image = '';

            $dNews->save(false);

        }
    }

    public function actionStrategy() {
        $url = 'https://api.wattforex.com/app/v1/strategy/getDetail';
        $params = [
            'auth_sign_version' => '1.0',
            'auth_consumer_key' => 'ios_jH0c4aDCmyJ8FQaZSILTJRN3EJ5E',
            'symbol' => 'AUDUSD',
            'auth_sign' => '01de5d2c3b9b1ff6aa50ac3c2337064e',
            'brokerCode' => 'TIGER_WIT',
            'auth_sign_type' => 'MD5'
        ];
    }

    public function actionFx168() {
        // pc 版返回数据中带 first key 用来区分种类
        // http://api3.fx168api.com/cms/GetNewsByLmId.aspx?chid=2822&pnum=1&psize=20&callback=GetHistory&_=1531920435708

        // 手机版 通过 channelId 来区分， 1 要闻， 6 外汇， 其他的没有一一查看
        // https://app5.fx168api.com/h5/news/getNewsByChannel.json?minId=&maxId=&channelId=1&pageSize=20&direct=down&_=1532069271185

        $url = 'http://api3.fx168api.com/cms/GetNewsByLmId.aspx';
        $params = [
            'chid' => 2822,
            'pnum' => 1,
            'psize' => 20,
            'callback' => 'GetHistory',
        ];

        $result = $this->dataCurl($url, $params);
        $ret = preg_match('/GetHistory\((.*)\)/', $result, $matches);
        if (!$ret) {
            $this->stdout('time:' . date('Y-m-d H:i:s', time()) . ', preg_match result:'.$ret);
            return 0;
        }

        $lang = 'zh_CN';
        $source = 'fx168-news';
        $list = json_decode($matches[1], true);
        foreach ($list as $item) {
            $dNews = WpfxDynamicNews::findOne(['doc_id' => $item['docid'], 'lang' => $lang, 'source' => $source]);
            if (!$dNews) {
                $dNews = new WpfxDynamicNews();
            }

            if (!$dNews->content) {
                $detailUrl = str_replace('.shtml', '_wap.shtml', $item['docpuburl']);
                $dResult = $this->dataCurl($detailUrl);
                $start = strpos($dResult, '<div class="yjl_article">');
                $end = strpos($dResult, '<div class="yjl_rili_aboutNews">');
                $result = substr($dResult, $start, $end - $start);

                $ret = preg_match_all('/\<img(.*?)\/>/', $result, $matches);
                if ($ret) {
                    $imgs = $matches[0];
                    foreach ($imgs as $img) {
                        $a = str_replace("src=\"./", "src=\"".$item['appfilePath'], $img);
                        $result = str_replace($img, $a, $result);
                    }
                }
                $dNews->content = $result;
            }

            $dNews->doc_id = $item['docid'];
            $dNews->lang = $lang;
            $dNews->source = $source;
            $dNews->title = $item['doctitle'];
            $dNews->detail_url = $item['docpuburl'];
            $dNews->timestamp = strtotime($item['docfirstpubtime']);
            $dNews->summary = $item['zhaiyao'];
            $dNews->first_key = $item['firstkey'];
            $dNews->lmid = $item['lmid'];
            $dNews->image = $item['appfilePath'] . $item['appfile'];

            $dNews->save(false);

        }
    }

    public function actionFlashSina() {

        // http://app.finance.sina.com.cn/news/twenty-four-hour-news/top-news?top3=true
        $url = 'http://app.finance.sina.com.cn/news/twenty-four-hour-news/add-news';
        $result = $this->dataCurl($url);
        $list = json_decode($result, true);

        $parseResult = false;
        if (isset($list['result']) && isset($list['result']['status'])) {
            if ($list['result']['status']['msg'] == 'OK') {
                $parseResult = true;
            }
        }

        if (!$parseResult) {
            $this->stdout('sina flash:'.',time:'.date('Y-m-d H:i:s', time()).',parse result false'.PHP_EOL);
            return;
        }

        $data = $list['result']['data'];
        $dataList = $data['data'];
        $this->stdout('sina flash,'.',time:'.date('Y-m-d H:i:s', time()).',list count:'.count($dataList).PHP_EOL);

        $lang = 'zh_CN';
        $platformSource = 'sina-finance';
        foreach ($dataList as $item) {
            $pFlash = WpfxNewsFlash::findOne(['lang' => $lang, 'flash_id' => $item['id'], 'platform_source' => $platformSource]);
            if (!$pFlash) {
                $pFlash = new WpfxNewsFlash();
            }

            $pFlash->lang = $lang;
            $pFlash->platform_source = $platformSource;
            $pFlash->flash_id = $item['id'];
            $pFlash->type = 4;
            $pFlash->timestamp = strtotime($item['created_at']);
            $pFlash->source = '新浪财经';


            $ret = preg_match('/【(.*?)】(.*)/', $item['content'], $matches);
            if ($ret) {
                $pFlash->title = $matches[1];
                $pFlash->content = $matches[2];
            } else {
                $pFlash->title = $item['content'];
            }

            $pFlash->save(false);
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
                    $tmpUrl = $url . '?' . http_build_query($params);
                    var_dump($tmpUrl);
                    curl_setopt($ch, CURLOPT_URL, $tmpUrl);
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