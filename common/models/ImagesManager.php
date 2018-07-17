<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "images_manager".
 *
 * @property int $id id
 * @property string $title 标题
 * @property int $active 活动状态：1=开启；2=关闭
 * @property string $lang 语言：zh-CN;en-US
 * @property string $app_name app name
 * @property string $app_id app 标识
 * @property string $img 图片路径
 * @property string $desc 描述
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $publish_time 发布时间
 * @property string $url 图片
 * @property int $is_real 是否验证用户：1=验证 0=不验证
 * @property int $parent_id 父类id
 * @property int $sub_id 子类id
 * @property int $img_type 图片分类：1=启动页面 2=首页页面
 * @property string $redirect 图片跳转路由
 * @property int $valid_time 有效期
 * @property int $stay 停留秒数（以秒为单位）
 * @property int $sort 排序字段
 * @property int $platform 0:未设置，1：mobile，2：ios，3：android
 * @property int $is_rule 0:默认不应用，1：应用
 * @property string $rule 版本匹配规则
 */
class ImagesManager extends \yii\db\ActiveRecord
{
    const ACTIVE_N = 0;
    const ACTIVE_Y = 1;

    public static $s_active = [
        self::ACTIVE_N => '关闭',
        self::ACTIVE_Y => '开启',
    ];

    const LANG_ZH_CN = 'zh-CN';
    const LANG_EN_US = 'en';

    public static $s_lang = [
        self::LANG_ZH_CN => '中文',
        self::LANG_EN_US => '英文',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images_manager';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('forexDb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'create_time', 'update_time', 'publish_time', 'is_real', 'parent_id', 'sub_id', 'img_type', 'valid_time', 'stay', 'sort', 'platform', 'is_rule'], 'integer'],
            [['desc'], 'string'],
            [['title', 'app_name'], 'string', 'max' => 64],
            [['lang'], 'string', 'max' => 6],
            [['app_id', 'img', 'redirect'], 'string', 'max' => 256],
            [['url', 'rule'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app', '标题'),
            'active' => Yii::t('app', '活动状态'),
            'lang' => Yii::t('app', '语言'),
            'app_name' => Yii::t('app', 'app'),
            'img' => Yii::t('app', '图片'),
            'desc' => Yii::t('app', '描述'),
            'create_time' => Yii::t('app', '创建时间'),
            'update_time' => Yii::t('app', '更新时间'),
            'publish_time' => Yii::t('app', '发布时间'),
            'img_type' => Yii::t('app', '类型'),
            'redirect' => Yii::t('app', '跳转路由'),
            'valid_time' => Yii::t('app', '有效期'),
            'stay' => Yii::t('app', '停留时间（秒）'),
            'sort' => Yii::t('app', '排序'),
            'platform' => Yii::t('app', '平台'),
            'rule' => Yii::t('app', '版本匹配规则'),
        ];
    }
}
