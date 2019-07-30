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

	// /usr/bin/php /Users/zhouzhou/workspace/2018/advanced/yii pocket-fx/test
    public function actionTest($id) {
		return 'OK';
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

    public function actionJinFlash() {
		$urls = ['https://sshibjmfbd.jin10.com:4432', 'https://sshibiddce.jin10.com:4431'];
		$r = random_int(0, 1);

		$params = [
			'app' => 'IOS',
			'method' => 'GetFlashListRequest',
			'sessionId' => '',
			'jsonStr' => [
				'wheres' => ['MaxTime' => 0]
			],
			'limit' => '50',
		];
		$this->stdLog($urls[$r]);
		$headers = array(
			'Content-Type:' . 'application/json',
//			'Content-Type:' . 'application/x-www-form-urlencoded',
		);

		$response = $this->dataCurl($urls[$r], json_encode($params), 1, $headers);
		$list = json_decode($response, true);
		if (!$list) {
			$this->stdout('error flash result:'.$response.PHP_EOL);
			return;
		}

		foreach ($list['data'] as $item) {
			$this->stdLog($item['id']);
			$this->stdLog($item['content']);
			$this->stdLog($item['timestr']);
			$this->stdLog(strtotime($item['timestr']));
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

    public function actionSinaCalendarTest() {
        $now = time();
        $oneDay = 86400;
        $now = $now - 190 * $oneDay;


        $countyStr = Yii::$app->params['country.info'];
        $countryArray = json_decode($countyStr, true);
        $countries = [];
        foreach ($countryArray as $key => $county) {
            $countryCode = $county['name'];
            $county['code'] = $key;
            $countries[$countryCode] = $county;
        }

        $result = [];
        $url = 'https://rl.cj.sina.com.cn/client/api/calendar_v2/get_economic_lists';
        for ($i = 0; $i < 200; $i++) {
            $params = [
                'start_time' => date('Y-m-d', $now + ($i * $oneDay)),
                'end_time' => date('Y-m-d', $now + ($i * $oneDay)),
                'page' => 1,
                'version' => '4.3.2'
            ];

            $data = $this->parseSinaCalendar($url, $params, $countries, 1);
            if ($data) {
                foreach ($data as $key => $value) {
                    $result[$key] = $value;
                }
            }

        }
        $this->stdout('country:'.json_encode($result,JSON_UNESCAPED_UNICODE).PHP_EOL);
    }

    private function parseSinaCalendar($url, $params, $countries, $type) {
        // 新浪财经日历数据有时会没有country_info，需要根据中文的country做一次转换
        $countryChina = [
            '新西兰' => 'New Zealand',
            '日本' => 'Japan',
            '法国' => 'France',
            '加拿大' => 'Canada',
            '韩国' => 'Korea, Republic of',
            '澳大利亚' => 'Australia',
            '中国' => 'China',
            '德国' => 'Germany',
            '瑞士' => 'Switzerland',
            '英国' => 'United Kingdom',
            '欧元区' => 'EUA',
            '美国' => 'United States',
            '意大利' => 'Italy',
            '中国香港' => 'Hong Kong',
            '俄罗斯' => 'Russian',
            '中国台湾' => 'Taiwan, Province of China',
            '西班牙' => 'Spain',
            '新加坡' => 'Singapore',
            '希腊' => 'Greece',
            '印度' => 'India',
            '南非' => 'South Africa',
            '挪威' => 'Norway',
            '巴西' => 'Brazil',
            '波兰' => 'Poland',
            '马来西亚' => 'Malaysia',
            '瑞典' => 'Sweden',
            '土耳其' => 'Turkey',
        ];

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

        $result = [];
        foreach ($dataList as $item) {
            $data = $item;
            if (isset($data['country_info'])) {
                $countryInfo = $data['country_info'];
                $country = $countryInfo['name'];
                if (isset($countries[$country])) {
                    $result[$country] = $countries[$country]['currency'];
                }
            } else {
                if (isset($data['country'])) {
                    $country = $countryChina[$data['country']];
                    if (isset($countries[$country])) {
                        $result[$country] = $countries[$country]['currency'];
                    }
                }
            }

        }
        return $result;
    }

    private function parseSinaCalendarOld($url, $params, $countries, $type) {
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

    public function actionStrategy($en = 0) {
        $symbolKeys = [
            'AUDUSD' => '01de5d2c3b9b1ff6aa50ac3c2337064e',
            'AUDCAD' => 'eee470fd00fae2fdf1c8135c376b384b',
            'AUDJPY' => '45fab9871942ea477bb0e11615bdf4b6',
            'AUDCHF' => 'edb204db5f56b3c8cb5f76671de67d6d',
            'AUDNZD' => '6475e4ea9353d7b37506182da811ffc3',
            'CADJPY' => '786f97b5818f9c79fe74d9c5fedeeb5b',
            'CADCHF' => '80763a6e9b9e644af44700bb37380700',
            'USDCAD' => '1f0cd9ce3ce989fd8e73e4d79e484e8f',
            'USDCNH' => 'faadc8a5b63ac55851d7cfeb7828cd6f',
            'USDJPY' => 'eec5396b2eca3cdd49c4c53a9f0b205e',
            'USDCHF' => 'cede9fd1d6f61bb6c205f96c9773473e',
            'EURAUD' => '1261a69cb3944b130b2e25af33ebc609',
            'EURCAD' => '0a8a1c21c6618d540870777cff1f50d0',
            'EURUSD' => '7945652a70e9b13d7ba6c2c521ab58a7',
            'EURJPY' => 'eca2ac0b96575fa0bc5f4587ce5601b2',
            'EURCHF' => '567276ac6fed19b356af22adcf25b1dd',
            'EURNZD' => '029d98fc06b7efd5cc16d5769c0f21ed',
            'EURGBP' => '10f560bebddcc14405c0b36efed54ffb',
            'CHFJPY' => 'dfa04e1fcf0ee06854230d0dd8d37a46',
            'NZDCAD' => 'fb84c77f259b8a6305ffb8ebc670857d',
            'NZDUSD' => '18ebb56c5e16121f3c1e3c48dfdb9edf',
            'NZDJPY' => '13200adf628f74182f3c29794e7fcd77',
            'NZDCHF' => '25d866499bda7bf501062ec7d4b227f2',
            'GBPAUD' => 'fcbe018a14817ad0df816f28a855093f',
            'GBPCAD' => '9526d944037c1dee899be93f798fda61',
            'GBPUSD' => '23ca99be483960394a03c1c2be30d102',
            'GBPJPY' => '01a153b9583a1732613c1f0e31cac483',
            'GBPCHF' => '257e95b0a47c8eb26891a32848c6a074',
            'GBPNZD' => '1476df9bee71ee22dad768d2c72c4301',

            'XAGUSD' => 'f2715ca65b788bb1a923c4eaa4052ff6',
            'XAUUSD' => '6cadc517fc27792c00eec6666c0f75d5',
            'XBRUSD' => 'ee8c12351b91f4c8bcd6d57d8bb9df40',
            'XNGUSD' => '0e048a0e1d67eee0c244e2317741ddff',
            'XTIUSD' => 'c384821af9492119d785ebf29735ac87',

            'USA500' => '5c5627bbc1aab43e4ff625a43e15194b',
            'US30' => '50d8ec2a9db0055a020692218e0c338d',
            'GER30' => 'cdf26e0fbf97d27e07f010e9f54b3141',
            'HK50' => '4c7e03d40b0441025bcecde14e19e1c8',
            'NAS100' => 'd3877d7a2ae7920d5061778157c96ea2',
            'EUSTX50' => 'b0c4585d068ddd9f09e2a54b50fa8c56',
            'JPN225' => '5c4b361dbda69e26c4b663e0cd4b15c9',

        ];

        // https://api.wattforex.com/app/v1/strategy/getDetail?auth_sign_version=1.0&auth_consumer_key=ios_jH0c4aDCmyJ8FQaZSILTJRN3EJ5E&symbol=USDCNH&auth_sign=faadc8a5b63ac55851d7cfeb7828cd6f&brokerCode=TIGER_WIT&auth_sign_type=MD5
        $url = 'https://api.wattforex.com/app/v1/strategy/getDetail';
        $params = [
            'auth_sign_version' => '1.0',
            'auth_consumer_key' => 'ios_jH0c4aDCmyJ8FQaZSILTJRN3EJ5E',
            'symbol' => 'AUDUSD',
            'auth_sign' => '01de5d2c3b9b1ff6aa50ac3c2337064e',
            'brokerCode' => 'TIGER_WIT',
            'auth_sign_type' => 'MD5'
        ];

        foreach ($symbolKeys as $symbol => $md5) {
            $params['symbol'] = $symbol;
            $params['auth_sign'] = $md5;

            if (empty($en)) {
                $result = $this->dataCurl($url, $params);
            } else {
                $headers = array(
                    'lang:' . 'en_US',
                );
                $result = $this->dataCurl($url, $params, 0, $headers);
                //$result = $this->http_get($url . '?' . http_build_query($params));
            }


            $data = json_decode($result, true);


            if (isset($data['result'])) {
                if (isset($data['result']['symbol'])) {
                    print_r($data);
                }
            } else {
                print_r($data);
            }

            break;

        }
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

    private function dataCurl($url, $params = false, $ispost = 0, $headers = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // http://stackoverflow.com/questions/4372710/php-curl-https
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        if (!empty($headers)) {
            print_r($headers);
            curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
        }

        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    print_r($params);
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

    private static function http_get($url) {
        $ch = curl_init();

        $headers = array(
            //'Cache-Control:' . 'no-cache',
            //'Content-Type:' . 'application/json',
            //'Content-Type:' . 'application/x-www-form-urlencoded',
            //'Client-lang:' . "en_US",
            'lang:' . 'en_US',
        );

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        Yii::info('http response:'. $response, __METHOD__);

        return $response;
    }

	private function stdLog($msg) {
		$this->stdout('time:' . date('Y-m-d H:i:s', time()) .'[' . $msg . ']' . PHP_EOL);
	}
}