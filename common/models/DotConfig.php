<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dot_config".
 *
 * @property int $id
 * @property string $name 显示名称
 * @property string $path 红点位置（路径），如uc/account
 * @property int $status 状态：0禁用，1启用
 * @property int $platform 平台：0 全平台或者不区分平台，1 iOS，2 Android
 * @property string $package 包名
 * @property double $time_period 间隔时间段，即每隔多久就显示一次红点
 * @property int $publish_at 在某个时间段显示红点，时间段的开始时间
 * @property int $expired_at 在某个时间段显示红点，时间段的结束时间
 */
class DotConfig extends \yii\db\ActiveRecord
{
	const STATUS_N = 0;
	const STATUS_Y = 1;

	const PLATFORM_ALL = 0;
	const PLATFORM_IOS = 1;
	const PLATFORM_ANDROID = 2;

	public static function statusList()
	{
		return [
			self::STATUS_N => Yii::t('app', '禁用'),
			self::STATUS_Y => Yii::t('app', '启用')
		];
	}

	public static function platformList()
	{
		return [
			self::PLATFORM_ALL => 'All',
			self::PLATFORM_IOS => 'iOS',
			self::PLATFORM_ANDROID => 'Android'
		];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dot_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path'], 'required'],
            [['status', 'platform'], 'integer'],
            [['time_period'], 'number'],
			[['expired_at', 'publish_at'], 'safe'],
            [['path', 'package', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'name' => Yii::t('app', '名称'),
            'path' => Yii::t('app', '位置'),
            'status' => Yii::t('app', '状态'),
            'platform' => Yii::t('app', '平台'),
            'package' => Yii::t('app', '包名'),
            'time_period' => Yii::t('app', '时间段'),
            'publish_at' => Yii::t('app', '开始时间'),
            'expired_at' => Yii::t('app', '结束时间'),
        ];
    }

    public function beforeValidate()
	{
		return parent::beforeValidate(); // TODO: Change the autogenerated stub
	}

	public function beforeSave($insert)
	{
		if (!empty($this->publish_at)) {
			if (is_string($this->publish_at)) {
				$this->publish_at = strtotime($this->publish_at);
			}
		}
		if (empty($this->publish_at) || is_string($this->publish_at)) {
			$this->publish_at = 0;
		}
		if (!empty($this->expired_at)) {
			if (is_string($this->expired_at)) {
				$this->expired_at = strtotime($this->expired_at);
			}
		}
		if (empty($this->expired_at) || is_string($this->expired_at)) {
			$this->expired_at = 0;
		}

		if (empty($this->time_period)) {
			$this->time_period = 0;
		}
		if (empty($this->expired_at)) {
			$this->expired_at = 0;
		}
		if (empty($this->package)) {
			$this->package = 'all';
		}

		return parent::beforeSave($insert); // TODO: Change the autogenerated stub
	}
}
