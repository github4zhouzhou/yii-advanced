<?php

namespace console\controllers;


use yii\console\Controller;
use yii\httpclient\Client;
use yii\base\Exception;
use yii\db\Query;
use Grafika\Grafika;
use Grafika\Color;

class BusController extends Controller
{

	// /usr/bin/php /workspace/wwwroot/forex/backend/yii qr-image
	public function actionMergeQrImage($offset = 0, $dir = '')
	{
		// 如果传了输出路径就不用默认路径了
		empty($dir) ? $distDir = '/data/cdn/bus-dist' : $distDir = $dir;

		// 合成主图片的路径，以及下载的二维码存储路径
		$busDir = '/data/cdn/bus';

		$mainImagePath = '/data/cdn/bus/main.jpg';

		$busInfoList = (new Query())->from('bus_schedules')->offset($offset)->orderBy('id')->all(\Yii::$app->db);

		// 找出所有公司名
		$companyList = (new Query())->from('bus_companies')->orderBy('id')->all(\Yii::$app->db);
		$companyMap = [];
		foreach ($companyList as $company) {
			$companyMap[$company['id']] = $company;
		}

		$client = new Client();

		$count = 0;
		foreach ($busInfoList as $busInfo) {
			$count++;

			$id = 1000000 + $busInfo['id'];
			$routeName = $busInfo['route_name'];
			$plateNumber = $busInfo['plate_number'];
			$companyId = $busInfo['company_id'];

			$companyName = $companyId;
			if (isset($companyMap[$companyId])) {
				$companyName = $companyMap[$companyId]['short_name'];
			}

			// 线路和车牌号码组成图片名称
			$baseName = $id . '-' . $companyName . '-' . $routeName . '-' . $plateNumber;
			$qrName = 'qr-' . $baseName . '.png';
			$mainName = $baseName . '.jpg';

			// 输出一下文件名
			$this->stdout($mainName . PHP_EOL);

			try {
				$qrSavePath = $busDir . '/' . $qrName;
				$response = $client->createRequest()
					->setMethod('POST')
					->setFormat(Client::FORMAT_JSON)
//					->setUrl("https://ncp.zmxyk.com/1/qr")
//					->setData(['plate_number' => $plateNumber, 'route_name' => $routeName])
					->setUrl("http://127.0.0.1:4633/1/qr")
					->setData([
						'plate_number' => $plateNumber,
						'route_name' => $routeName,
//						'page' => 'pages/auth/index',
					])
					->send();
				$data = $response->getContent();
				file_put_contents($qrSavePath, $data);
			} catch (\Exception $exception) {

			}


			//打开主图和子图
			$editor = Grafika::createEditor();

			$editor->open($mainImg,  $mainImagePath);
			$editor->open($markImg,  $qrSavePath);

			// 主图比较到，放大二维码
			$editor->resizeFit($markImg , 680 , 680);

			$qrLeft = 260;
			$qrTop = 335;
			// 将二维码合成到主图上
			$editor->blend($mainImg, $markImg, 'normal', 1, 'top-left', $qrLeft, $qrTop);

			// 计算线路文字的位置
			$routeLeft = 520;
			$newRounteName = $routeName . ' 路';
			$routeLen = strlen($newRounteName);
			if ($routeLen > 5) {
				$routeStart = $routeLeft - strlen($newRounteName) * 5;
			} elseif ($routeLen <= 4) {
				$routeStart = $routeLeft - strlen($newRounteName) * 3;
			} else {
				$routeStart = $routeLeft - strlen($newRounteName) * 4;
			}

			// 车辆信息
			$newPlateNumber = '车辆信息：' . $plateNumber;
			$plateStart = 1580 -  strlen($newPlateNumber) * 4;

			// 设置文字
			$color = new Color("#ffffff");
			$color->setAlpha(0.5);
			$editor->text($mainImg, $newPlateNumber, 30, $plateStart, 1150, $color, '/usr/share/fonts/msyh.ttf');
			$editor->text($mainImg, $newRounteName, 48, $routeStart, 1110, new Color("#3B4257"), '/usr/share/fonts/msyh.ttf');

			try {
				$mainSavePath = $distDir . '/' . $mainName;
				$editor->save($mainImg, $mainSavePath);
			} catch (\Exception $exception) {
				return '';
			}
		}
	}

	// /usr/bin/php /workspace/wwwroot/forex/backend/yii qr-image
	public function actionQrImage()
	{
		$distDir = '/data/cdn/bus-dist';
		$busDir = '/data/cdn/bus';
		$imagePath = '/data/cdn/bus/main.jpg';
		$csvPath = "/data/cdn/bus_schedules.csv";

		$client = new Client();

		$cvs_file = fopen($csvPath,'r'); //开始读取csv文件数据
		$i = 0;//记录cvs的行
		$stop = 0;
		while ($file_data = fgetcsv($cvs_file))
		{
			$i++;
			if($i==1)
			{
				continue;//过滤表头
			}
			$stop++;

			if($file_data[0]!='')
			{
				$data[$i] = $file_data;
				$id = $file_data[0];
				$routeName = $file_data[3];
				$plateNumber = $file_data[2];

				$baseName = $routeName . '-' . $plateNumber;
				$qrName = $id . '-' . 'qr-' . $baseName . '.png';
				$mainName = $id . '-' . $baseName . '.jpg';
				$md5MainName = $id . '-' . md5($baseName) . '.jpg';
				$this->stdout( $stop . ' ' . $routeName . PHP_EOL);

				$qrSavePath = $busDir . '/' . $qrName;

				$response = $client->createRequest()
					->setMethod('POST')
					->setFormat(Client::FORMAT_JSON)
					->setUrl("https://ncp.zmxyk.com/1/qr")
					->setData(['plate_number' => $plateNumber, 'route_name' => $routeName])
					->send();

				$data = $response->getContent();

				if (file_put_contents($qrSavePath, $data)) {
				}

				//打开主图和子图
				$editor = Grafika::createEditor();

				$editor->open($mainImg,  $imagePath);
				$editor->open($markImg,  $qrSavePath);
				$editor->resizeFit($markImg , 680 , 680);


				$editor->blend($mainImg, $markImg, 'normal', 1, 'top-left', 260, 335);

				$newRounteName = $routeName . ' 路';
				$routeLen = strlen($newRounteName);
				if ($routeLen > 5) {
					$routeStart = 520 - strlen($newRounteName) * 5;
				} elseif ($routeLen <= 4) {
					$routeStart = 520 - strlen($newRounteName) * 3;
				} else {
					$routeStart = 520 - strlen($newRounteName) * 4;
				}

				$newPlateNumber = '车辆信息：' . $plateNumber;
				$plateStart = 1580 -  strlen($newPlateNumber) * 4;

				$color = new Color("#ffffff");
				$color->setAlpha(0.5);
				$editor->text($mainImg, $newPlateNumber, 30, $plateStart, 1150, $color, '/usr/share/fonts/msyh.ttf');
				$editor->text($mainImg, $newRounteName, 48, $routeStart, 1110, new Color("#3B4257"), '/usr/share/fonts/msyh.ttf');


				try {
					$mainSavePath = $distDir . '/' . $mainName;
					$editor->save($mainImg, $mainSavePath);
				} catch (\Exception $exception) {
					return '';
				}

//				if ($stop > 20) break;

			}

		}
		fclose($cvs_file);

		$this->stdout('OK' . PHP_EOL);
	}
}