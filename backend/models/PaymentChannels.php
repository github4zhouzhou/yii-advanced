<?php
/**
 * Created by PhpStorm.
 * User: zhouzhou
 * Date: 2018/6/27
 * Time: 下午5:45
 */

namespace backend\models;


use Yii;
use yii\helpers\Html;

class PaymentChannels extends \common\models\PaymentChannels
{
    const STATUS_N = 0;
    const STATUS_Y = 1;

    public static $s_status = [
        self::STATUS_N => '禁用',
        self::STATUS_Y => '启用'
    ];

    static $s_platforms = [
        'web' => 'web',
        'wap' => 'wap',
        'app' => 'app'
    ];

    static $s_server_labels = [
        1 => '主标',
        2 => '白标'
    ];

    static $show_proof = [
        0 => '不需要',
        1 => '需要'
    ];

    static $s_countries = [
        'cn' => '中国',
        'us' => '美国',
        'br' => '巴西',
        'pt' => '葡萄牙',
        'pl' => '波兰',
        'tw' => '台湾',
        'de' => '德国',
        'my' => '马来西亚',
        'th' => '泰国',
        'id' => '印尼',
    ];

    public function afterFind()
    {
        parent::afterFind();
        //yii\helpers\Html::renderTagAttributes()

        if(!is_array($this->platform)) {
            $d = json_decode($this->platform, true);
            $this->platform = $d ?: [];
        }

        if(!is_array($this->country)) {
            $d = json_decode($this->country, true);
            $this->country = $d ?: [];
        }

        if(!is_array($this->domain)) {
            $d = json_decode($this->domain, true);
            $this->domain = $d ?: [];
        }

        if(!is_array($this->server_label)) {
            $d = json_decode($this->server_label, true);
            $this->server_label = $d ?: [];
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'channel' => Yii::t('app', '渠道'),
            'channelcode' => Yii::t('app', '子渠道'),
            'img' => Yii::t('app', '图标'),
            'max_amount' => Yii::t('app', '最大金额'),
            'min_amount' => Yii::t('app', '最小金额'),
            'server_label' => Yii::t('app', '标'),
            'need_proof' => Yii::t('app', '支付凭证'),
            'platform' => Yii::t('app', '平台'),
            'country' => Yii::t('app', '国家'),
            'show_limit' => Yii::t('app', '展示限额文档'),
            'status' => Yii::t('app', '状态'),
            'sort' => Yii::t('app', '排序'),
            'domain' => Yii::t('app', '网站域名'),
            'currency' => Yii::t('app', '货币'),
            'proportion' => Yii::t('app', '手续费比例'),
            'fixed_fee' => Yii::t('app', '固定手续费'),
            'which_fee' => Yii::t('app', '收取手续费方式'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '最后修改时间'),
            'open_mode' => Yii::t('app', '打开方式'),
        ];
    }

}