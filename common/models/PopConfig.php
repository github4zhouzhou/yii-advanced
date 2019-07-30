<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pop_config".
 *
 * @property int $id
 * @property string $title 标题
 * @property int $active 活动状态：1=开启；2=关闭
 * @property string $lang 语言：zh-CN;en-US
 * @property string $app_name 包名
 * @property string $app_id app 标识
 * @property string $img 图片路径
 * @property string $redirect 图片跳转路由
 * @property string $desc 描述
 * @property int $publish_time 发布时间
 * @property int $expired_time 过期时间
 * @property int $sort 排序字段
 * @property int $scene 弹出场景
 * @property int $pop_type 弹窗类型
 * @property int $pop_times 弹出次数
 * @property int $pop_interval 弹出间隔，每天，每周
 * @property int $after_click 弹窗跳转后怎么处理
 * @property int $after_close 点击关闭按钮后的操作
 * @property int $min_version 最小版本
 * @property int $max_version 最大版本
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class PopConfig extends \yii\db\ActiveRecord
{

	const TYPE_NO_LOGIN = 1; 	// 未登录弹窗
	const TYPE_NO_CERT = 4; 	// 未实名弹窗
	const TYPE_NO_DEPOSIT = 5; 	// 未入金弹窗
	const TYPE_NO_TRADE = 6;	// 未交易弹窗

	// 其他场景以后再定（如交易后弹出，入金后弹出等）
	const SCENE_DEFAULT = 0; 	// 默认弹出场景，请求到就弹出

	const INTERVAL_DEFAULT = 0; 	// 弹出间隔，
	const INTERVAL_DAILY = 1; 		// 弹出间隔，每天
	const INTERVAL_WEEKLY = 2; 		// 弹出间隔，每周

	// 点击弹窗后的操作
	const AFTER_CLICK_DEFAULT = 0;	// 点击弹窗后的操作，默认没有任何操作
	const AFTER_CLICK_NO_POP = 1;	// 点击弹窗后就不再弹出

	// 点击关闭后的操作
	const AFTER_CLOSE_DEFAULT = 0; 	// 点击关闭按钮后的操作，默认没有任何操作
	const AFTER_CLOSE_SCALE = 1;	// 点击关闭按钮后缩放


	public static function statusList() {
		return ['关闭', '开启'];
	}

	public static function langList() {
		return [
			'zh-CN' => '中文',
			'en' => '英文'
		];
	}

	public static function sceneList() {
		return [self::SCENE_DEFAULT => '默认（请求到即弹出）'];
	}

	public static function typeList() {
		return [
			self::TYPE_NO_CERT => '未实名弹窗',
			self::TYPE_NO_DEPOSIT => '未入金弹窗',
			self::TYPE_NO_TRADE => '未交易弹窗',
			self::TYPE_NO_LOGIN => '未登录弹窗',
		];
	}

	public static function intervalList() {
		return [
			self::INTERVAL_DEFAULT => '默认（没有时间间隔）',
			self::INTERVAL_DAILY => '每天',
			self::INTERVAL_WEEKLY => '每周'
		];
	}

	public static function afterClickList() {
		return [
			self::AFTER_CLICK_DEFAULT => '默认（点击后不做任何操作）',
			self::AFTER_CLICK_NO_POP => '点击后不再弹出此类弹出',
		];
	}

	public static function afterCloseList() {
		return [
			self::AFTER_CLOSE_DEFAULT => '默认（点击后不做任何操作）',
			self::AFTER_CLOSE_SCALE => '点击后缩小到底部',
		];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pop_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'publish_time', 'expired_time', 'sort', 'scene', 'pop_type', 'pop_times', 'pop_interval', 'after_click', 'after_close', 'created_at', 'updated_at'], 'integer'],
            [['desc'], 'string'],
            [['title'], 'string', 'max' => 64],
            [['lang'], 'string', 'max' => 6],
            [['app_name', 'app_id', 'img', 'redirect'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'active' => 'Active',
            'lang' => 'Lang',
            'app_name' => 'App Name',
            'app_id' => 'App ID',
            'img' => 'Img',
            'redirect' => 'Redirect',
            'desc' => 'Desc',
            'publish_time' => 'Publish Time',
            'expired_time' => 'Expired Time',
            'sort' => 'Sort',
            'scene' => 'Scene',
            'pop_type' => 'Pop Type',
            'pop_times' => 'Pop Times',
            'pop_interval' => 'Pop Interval',
            'after_click' => 'After Click',
            'after_close' => 'After Close',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
	{
		if ($this->isNewRecord) {
			$this->created_at = time();
		}
		$this->updated_at = time();
		return parent::beforeSave($insert); // TODO: Change the autogenerated stub
	}
}
