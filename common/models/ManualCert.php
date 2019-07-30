<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "manual_certs".
 *
 * @property int $id
 * @property int $mid
 * @property string $country 国籍
 * @property string $first_name 名
 * @property string $last_name 姓
 * @property int $sex 称谓
 * @property int $cert_type 证件类型
 * @property string $cert_number 证件号码
 * @property string $birthday 出生日期
 * @property string $address 居住地址
 * @property string $file1 证件正面
 * @property string $file2 证件反面
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class ManualCert extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manual_certs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['country', 'first_name', 'last_name'], 'string', 'max' => 16],
            [['sex', 'cert_type'], 'string', 'max' => 2],
            [['cert_number', 'birthday'], 'string', 'max' => 32],
            [['address', 'file1', 'file2'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'mid' => 'user id',
            'country' => '国籍',
            'first_name' => '名',
            'last_name' => '姓',
            'sex' => '称谓',
            'cert_type' => '证件类型',
            'cert_number' => '证件号码',
            'birthday' => '出生日期',
            'address' => '居住地址',
            'file1' => '证件正面',
            'file2' => '证件反面',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

	public function countries()
	{
		return [
			'CN' => '中国',
			'EN' => '美国'
		];
//		$countries = [];
//		foreach (json_decode(\Yii::$app->params['country.info'], true) as $code => $value) {
//			$countries[] = [
//				'label' => $value['name'],
//				'value' => $code,
//			];
//		}
//		return $countries;
	}

	public function sexes()
	{
		return [1 => '先生', 2 => '夫人', 3 => '小姐', 4 => '女士', 5 => '其他'];
	}

	public function certTypes()
	{
		return [1 => '身份证', 2 => '驾驶证', 3 => '户口本'];
	}

}
