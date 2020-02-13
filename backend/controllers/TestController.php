<?php
/**
 * Created by PhpStorm.
 * User: zhouzhou
 * Date: 2018/6/7
 * Time: 下午8:13
 */

namespace backend\controllers;

use common\helpers\Test;
use common\models\TradeAccount;
use common\behaviors\MyBehavior;
use common\models\WpfxDynamicNews;
use common\models\WpfxFcHistory;
use common\models\WpfxFinancialCalendar;
use common\models\WpfxNewsFlash;
use mdm\admin\components\MenuHelper;
use PHPHtmlParser\Dom;
use Symfony\Component\BrowserKit\Client;
use Yii;
use yii\base\Controller;
use yii\base\Exception;
use GuzzleHttp\RequestOptions;

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
    	$res = json_decode('good', true);
    	return $res;
    }

	function getUtcHour($timestamp)
	{
		$tz = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$H = date('H', $timestamp);
		date_default_timezone_set($tz);
		return intval($H);
	}

	/**
	 * @desc 连接苹果的推送服务器
	 * @return bool|resource
	 */
	function connect_feedback() {

		$passphrase = '123456';

		$cert_file = '/Users/zhouzhou/Downloads/tmp/output_dis.pem'; // 推送的证书地址，环境不要错了

		$feedback_server = 'ssl://feedback.push.apple.com:2196'; // feedback服务器地址

		$ctx = stream_context_create();

		stream_context_set_option($ctx, 'ssl', 'local_cert', $cert_file);

		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		$fp = stream_socket_client($feedback_server, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $ctx);

		if(!$fp) {
			Yii::error("Failed to connect feedback server: $error $errorString\n", __METHOD__);
			return false;
		} else {
			Yii::error("Connection to feedback server OK\n", __METHOD__);
		}
		return $fp;
	}

	/**
	 * @desc 执行推送操作的主要代码
	 */
	function feedback(){

		$count1 = 0;

		$run_times = 0;

		$iostokenremoved= 'iostokenremoved';

		$iostokenremoved_num = 'iostokenremoved_num';

		$fp = $this->connect_feedback();

		//苹果建议provider和feedback服务维持一个长连接，如果频繁的建立连接可能会被当做攻击处理
		$devcon ='';

		while($run_times < 2000){

			$run_times++;

			// socket连接检测
			if($devcon === FALSE) {
				Yii::error(date('Ymd His').'|feedback server disconnected', __METHOD__);
				@fclose($fp);
				unset($fp);
				$fp = $this->connect_feedback();
			}

			//每次读取38个字段，这是保存的一个完整token 信息的长度
			while ($devcon = fread($fp, 38)){
				$count1++;

				$arr = unpack("H*", $devcon);//解包传过来的二进制数据

				$rawhex = trim(implode("", $arr));

				$feedbackTime = hexdec(substr($rawhex, 0, 8));

				$feedbackDate = date('Y-m-d H:i:s', $feedbackTime);

				$feedbackDeviceToken = substr($rawhex, 12, 64);

				Yii::error('date:' . $feedbackDate, __METHOD__);
				Yii::error('token:' . $feedbackDeviceToken, __METHOD__);
			}

			Yii::error('FeedBack:'. $count1 . PHP_EOL, __METHOD__);

//			usleep(10000000); // sleep 10秒
			fclose($fp);
			break;

		}
//		fclose($fp);
	}

    public function isDst()
	{
		$timezone=date('e');  //获取当前使用的时区

//		date_default_timezone_set('US/Pacific-New'); //强制设置时区
		date_default_timezone_set('America/New_York'); //强制设置时区

		$dst=date('I');  //判断是否夏令时

		date_default_timezone_set($timezone);  //还原时区

		return $dst;  //返回结果
	}

    private function testTry() {
		Yii::error(__METHOD__, 'sa');
		try {
			return "1";
//			throw new Exception('OK');
		} finally {
			print_r('finally');
//			return '1111';
//			return "1111";//当finally有return的时候 返回这个，当注销后，返回try 或者是 catch的内容。
		}
	}

	private function RSA2EncryptByPub($strToSign, $key) {
		return $this->curlPost('http://api.bejson.com/btools/tools/enc/rsa/buildRSAEncryptByPublicKey', $strToSign, $key);
	}

	private function RSA2DecryptByPri($data, $key) {
		return $this->curlPost('http://api.bejson.com/btools/tools/enc/rsa/buildRSADecryptByPrivateKey', $data, $key);
	}

	private function curlPost($url, $param, $key) {
		$headers = array('Content-Type: application/x-www-form-urlencoded');
		$ch = curl_init(); // 启动一个CURL会话
		curl_setopt($ch, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
			'key' => $key,
			'data' => $param,
			'rsaType' => 'rsa2'
		])); // Post提交的数据包
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close($ch);

		Yii::error('RSA2Sign result:' . $response, __METHOD__);

		$jData = json_decode($response, true);
		if (isset($jData['code']) && $jData['code'] == 0) {
			return $jData['message'];
		}
		return '';
	}

    public function actionTest() {
        $this->andTest();
    }

    public function coinGatePay() {
			$notify = [
				'id' => '2229913',
				'order_id' => 'RMGW2GJVL4VPG7XE',
				'status' => 'paid',
				'pay_amount' => '3.043782',
				'pay_currency' => 'ETH',
				'price_amount' => '609.0',
				'price_currency' => 'USD',
				'receive_currency' => 'ETH',
				'receive_amount' => '3.013344',
				'created_at' => '2018-10-15T13:02:04+00:00',
				'token' => '5d2af99e0a847abe52a341cec1e05d50',
			];

			$request = [
				'order_id' => 'RMGW2GJVL4VPG7XE',
				'price_amount' => '609.00',
				'price_currency' => 'USD',
				'receive_currency' => 'DO_NOT_CONVERT',
				'callback_url' => 'http://pay.ubfx.co.uk/coingate/notify',
				'cancel_url' => 'http://pay.ubfx.co.uk/coingate/cancel?oid=RMGW2GJVL4VPG7XE',
				'success_url' => 'http://pay.ubfx.co.uk/coingate/result?oid=RMGW2GJVL4VPG7XE',
				'token' => '5d2af99e0a847abe52a341cec1e05d50',
			];


			$s1 = $this->signData($request);
			$s2 = $this->signData($notify);
			var_dump($s1 . $s2); die();


		}

	public function signData($params)
	{
		$strToSign = $params['order_id'] . intval($params['price_amount']) . $params['price_currency'] . 'coin-gate-ubfx';
		return hash('md5', $strToSign);
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

	public function actionRpn()
	{
		$data = [
			'order_id' => '3V2Z37B8E4W4WK7Y',
			'order_time' => '1551680286',
			'order_amount' => '676',
			'deal_id' => '123',
			'deal_time' => '1551680287',
			'pay_amount' => '677',
			'pay_result' => '3',
		];
		$key = 'DKJkTQPE0YdAtJTOShRI2Q';

		$strToSign = 'order_id=' . $data['order_id']
			. '|order_time=' . $data['order_time']
			. '|order_amount=' . $data['order_amount']
			. '|deal_id=' . $data['deal_id']
			. '|deal_time=' . $data['deal_time']
			. '|pay_amount=' . $data['pay_amount']
			. '|pay_result=' . $data['pay_result']
			. '|key=' . $key;
		$sign = hash('md5', $strToSign);

		var_dump($sign);die();

		$this->layout = false;
		return $this->render('rpn', [
			'url' => 'http://www.baidu.com',
			'order' => '12345678',
			'btn_tip' => '複製並跳轉',
		]);
	}

    public function actionRpnTest()
	{
		$mid = 'EU85201076P2P';
		$uid = '11099';
		$request_time = '1551680286';
		$key = 'DKJkTQPE0YdAtJTOShRI2Q';

		$strToSign = 'mid='. $mid . '|uid=' . $uid . '|request_time=' . $request_time . '|key=' . $key;
		$sign = hash('md5', $strToSign);

		var_dump($strToSign);die();
		$this->layout = false;
		return $this->render('rpn', [
			'url' => 'http://www.baidu.com',
			'order' => '12345678',
			'btn_tip' => '複製並跳轉',
		]);
	}

    public function actionRdp()
	{
		$this->layout = false;
		return $this->render('rdp', [
			'title' => '确认信息',
			'pay_type' => '支付方式：网银支付',
			'pay_amount' => '支付金额：$50',
			'order_id' => 'J859PPM2EWJK5BVL',
			'input_tip' => '请输入储蓄卡号',
			'btn_tip' => '下一步',
		]);
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

    public function actionDLocal() {
		$this->layout = false;
		return $this->render('d-local', [
			'order_id' => 'J859PPM2EWJK5BVL',
			'product' => '中国特种部队',
			'order_time' => date('Y-m-d', time()),
			'amount' => '459.00',
		]);
	}

    public function actionCalendarList() {
        return 'ok';
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

    public function signParams($params) {
        ksort($params);
        $keys_str = implode('%#', array_keys($params));
        $values_str = implode(array_values($params));
        $str_to_sign = $keys_str . $values_str . '136ddeab162b23a810d8774088e1aa6baf880b65';
        return hash_hmac('sha512', $str_to_sign, 'cEFGh71Mno6RsStTvw7z');
    }

    public function andTest() {
        $a = 1;
        $b = 1 << 1;
        $c = 1 << 2;

        $ret = $a | $b | $c;

        $ret = $ret & ~$a;
        var_dump($a, $b, $c, ~$b, ~$a, $ret); die();
    }

    public function curlFile($url, $path)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);

		$data = array('file' => new \CURLFile(realpath($path)));

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 1 );
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT,"TEST");
		$result = curl_exec($curl);
		$error = curl_error($curl);

		return $result;
	}

	public function getDeviceLangByMid($mid)
	{
		$response = $this->curlGet('http://172.24.47.98:9415/api/' . 'device/info', [
			'alias' => $mid,
			'app_id' => 5,
		]);
		return $response;
	}

	public function curlGet($url, $params, $headers = [])
	{
		$ch = curl_init();

		/**
		 * http 1.0 和 1.1 的区别
		 * https://www.cnblogs.com/gofighting/p/5421890.html
		 * http 1.1 可能会保持长连接，我们不需要长连接，所以强制使用1.0
		 */
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);

		// 在发起连接前等待的时间，如果设置为0，则无限等待。
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		// 设置cURL允许执行的最长秒数
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		// 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// http://stackoverflow.com/questions/4372710/php-curl-https
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		if (empty($params)) {
			curl_setopt($ch, CURLOPT_URL, $url);
		} else {
			if (is_array($params)) {
				curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
			} else {
				curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
			}
		}

		// 设置头信息
		if (empty($headers)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json;charset=utf-8']);
		} else {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		// 执行
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
}