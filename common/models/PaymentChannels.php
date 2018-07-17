<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_channels".
 *
 * @property int $id
 * @property string $channel 渠道
 * @property string $channelcode 子渠道
 * @property string $img 渠道图片
 * @property int $max_amount 最高入金金额，0则不限
 * @property int $min_amount 最低入金金额
 * @property string $platform 平台：web/wap/app
 * @property string $country 国家
 * @property int $show_limit 是否展示限额说明
 * @property int $status 状态
 * @property int $sort 排序
 * @property int $created_at 创建时间
 * @property int $updated_at 最后更新时间
 * @property string $domain 域名
 * @property string $currency 入金货币
 * @property string $proportion 手续费比例
 * @property string $fixed_fee 单笔固定手续费
 * @property string $which_fee 启用那种手续费P/F
 * @property int $open_mode 客户端打开方式 0-浏览器 1-应用内
 * @property string $server_label 服务器标，主标，白标
 * @property int $need_proof 是否需要上传支付证明，默认0不需要上传
 */
class PaymentChannels extends \yii\db\ActiveRecord
{

    const OPEN_MODE_WEB = 0;
    const OPEN_MODE_APP = 1;

    public static $s_open_modes = [
        self::OPEN_MODE_APP => '应用内打开',
        self::OPEN_MODE_WEB => '浏览器打开',
    ];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_channels';
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
            [['max_amount', 'min_amount', 'show_limit', 'status', 'sort', 'created_at', 'updated_at', 'open_mode', 'need_proof'], 'integer'],
            [['domain'], 'required'],
            [['proportion', 'fixed_fee'], 'number'],
            [['channel', 'channelcode', 'img', 'platform', 'country', 'domain'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
            [['which_fee'], 'string', 'max' => 2],
            [['server_label'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'channelcode' => 'Channelcode',
            'img' => 'Img',
            'max_amount' => 'Max Amount',
            'min_amount' => 'Min Amount',
            'platform' => 'Platform',
            'country' => 'Country',
            'show_limit' => 'Show Limit',
            'status' => 'Status',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'domain' => 'Domain',
            'currency' => 'Currency',
            'proportion' => 'Proportion',
            'fixed_fee' => 'Fixed Fee',
            'which_fee' => 'Which Fee',
            'open_mode' => 'Open Mode',
            'server_label' => 'Server Label',
            'need_proof' => 'Need Proof',
        ];
    }
}
