<?php

namespace backend\controllers;

use Yii;
use common\models\ManualCert;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ManualCertController implements the CRUD actions for ManualCert model.
 */
class ManualCertController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ManualCert models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ManualCert::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ManualCert model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ManualCert model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ManualCert();

        if ($model->load(Yii::$app->request->post())) {

			$this->_upload($model, 'file1');
			$this->_upload($model, 'file2');

			$ret = $this->makeImageBase64($model->file1);
			Yii::error('response:' . $ret, __METHOD__);

			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ManualCert model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

        	$this->_upload($model, 'file1');
			$this->_upload($model, 'file2');

			$model->save();

			$ret = $this->makeImageBase64($model->file1);
			Yii::error('response:' . $ret, __METHOD__);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ManualCert model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ManualCert model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ManualCert the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ManualCert::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	private function _upload(ManualCert $model, $name)
	{
		$file = UploadedFile::getInstanceByName("ManualCert[$name]");

		if($file && $file->extension) {
			$path = sprintf('/data/cdn/uploads/cert/%s.%s', uniqid(), $file->extension);
			if(!is_dir(dirname($path))) {
				mkdir(dirname($path), 0777, true);
			}
			if($file->saveAs($path)) {
				$model->$name = $path;
			}
		} else {
			unset($model->$name);
		}
	}

	private function _uploadFile($furl)
	{
		Yii::error('$furl:' . $furl, __METHOD__);
		$url = "http://dev.account.ubfx.com/bankinfo/upload";
		//  初始化
		$ch = curl_init();
		// 要上传的本地文件地址"@F:/xampp/php/php.ini"上传时候，上传路径前面要有@符号
		$post_data = array (
			"file" => $furl
		);
		//print_r($post_data);
		//CURLOPT_URL 是指提交到哪里？相当于表单里的“action”指定的路径
		//$url = "http://localhost/DemoIndex/curl_pos/";
		//  设置变量
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);//执行结果是否被返回，0是返回，1是不返回
		curl_setopt($ch, CURLOPT_HEADER, 0);//参数设置，是否显示头部信息，1为显示，0为不显示
		//伪造网页来源地址,伪造来自百度的表单提交
		curl_setopt($ch, CURLOPT_REFERER, "http://www.baidu.com");
		//表单数据，是正规的表单设置值为非0
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);//设置curl执行超时时间最大是多少
		//使用数组提供post数据时，CURL组件大概是为了兼容@filename这种上传文件的写法，
		//默认把content_type设为了multipart/form-data。虽然对于大多数web服务器并
		//没有影响，但是还是有少部分服务器不兼容。本文得出的结论是，在没有需要上传文件的
		//情况下，尽量对post提交的数据进行http_build_query，然后发送出去，能实现更好的兼容性，更小的请求数据包。
		curl_setopt($ch, CURLOPT_POSTFIELDS, '');
		//   执行并获取结果
		$result = curl_exec($ch);
		if(curl_exec($ch) === FALSE)
		{
			echo "<br/>"," cUrl Error:".curl_error($ch);
		}
		//  释放cURL句柄
		curl_close($ch);
		return $result;
	}

	private function makeImageBase64($filename) {
		$filename = stripslashes($filename);
		Yii::info('filename:' . $filename, __METHOD__);

		$exist = file_exists($filename);
		if (!$exist) {
			return false;
		}
		$size = filesize($filename);
		if ($size > 1024 * 1024) { // > 1M
			return false;
		}

		// 获取文件后缀名
		$ext = pathinfo($filename)['extension'];
		$ext = strtolower($ext);
		$image = null;
		if ($ext == 'png') {
			$image = imagecreatefrompng($filename);
		} else if ($ext == 'jpeg' || $ext == 'jpg') {
			$image = imagecreatefromjpeg($filename);
		} else if ($ext == 'bmp') {
			$image = imagecreatefromwbmp($filename);
		} else {
			return false;
		}

		ob_start();
		ob_end_clean();

		ob_start();
		if ($ext == 'png') {
			imagepng($image);
		} else if ($ext == 'jpeg' || $ext == 'jpg') {
			imagejpeg($image);
		} else if ($ext == 'bmp') {
			imagewbmp($image);
		}
		$image_data = ob_get_contents();
		ob_end_clean();

		return base64_encode($image_data);
	}
}
