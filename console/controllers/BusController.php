<?php

namespace console\controllers;


use yii\console\Controller;
use yii\httpclient\Client;
use Grafika\Grafika;
use Grafika\Color;

class BusController extends Controller
{
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
			$stop++;
			$i++;
			if($i==1)
			{
				continue;//过滤表头
			}

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
				$this->stdout($routeName . PHP_EOL);


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
				$routeStart = 520 - strlen($newRounteName) * 5;
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

				if ($stop > 20) break;

			}

		}
		fclose($cvs_file);

		$this->stdout('OK' . PHP_EOL);

		return;
	}
}