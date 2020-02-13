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
		$destDir = '/data/cdn/bus';
		$imagePath = '/data/cdn/bus/main.png';
		$csvPath = "/data/cdn/bus_schedules.csv";

		$client = new Client();
		$editor = Grafika::createEditor();

		$cvs_file = fopen($csvPath,'r'); //开始读取csv文件数据
		$i = 0;//记录cvs的行
		while ($file_data = fgetcsv($cvs_file))
		{
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
				$mainName = $id . '-' . $baseName . '.png';
				$md5MainName = $id . '-' . md5($baseName) . '.png';
				$this->stdout($md5MainName . PHP_EOL);
				$this->stdout($routeName . PHP_EOL);


				$savePath = $destDir . '/' . $qrName;

				$response = $client->createRequest()
					->setMethod('POST')
					->setFormat(Client::FORMAT_JSON)
					->setUrl("https://ncp.zmxyk.com/1/qr")
					->setData(['plate_number' => $plateNumber, 'route_name' => $routeName])
					->send();

				$data = $response->getContent();

				if (file_put_contents($savePath, $data)) {
					$this->stdout('OK' . PHP_EOL);
				}

				//打开主图和子图
				$editor->open($mainImg,  $imagePath);
				$editor->open($markImg,  $savePath);
				$editor->resizeFit($markImg , 219 , 219);

				$this->stdout(strlen('123测试') . PHP_EOL);

				$editor->text($mainImg,$routeName,24,160,350, new Color("#000000"), '/usr/share/fonts/ msyh.ttf');
				//$editor->text($mainImg,'车辆信息:' . $plateNumber, 24,490,220, new Color("#000000"), '/usr/share/fonts/dejavu/DejaVuSans.ttf');
				$editor->blend($mainImg, $markImg, 'normal', 1, 'top-left', 90, 117);


				try {
					$mainSavePath = $destDir . '/' . $mainName;
					$editor->save($mainImg, $mainSavePath);
					$md5MainSavePath = $destDir . '/' . $md5MainName;
					$editor->save($mainImg, $md5MainSavePath);
				} catch (\Exception $exception) {
					return '';
				}
				break;

			}

		}
		fclose($cvs_file);

		$this->stdout('OK' . PHP_EOL);

		return;
	}
}