<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus_records".
 *
 * @property int $id
 * @property int $mid 用户ID
 * @property int $login mt4账号
 * @property int $amount 赠金金额
 * @property string $currency 赠金币种默认是USD
 * @property int $status 状态，1：赠金已发放;2:赠金已扣除;
 * @property int $trade_volume 扣除赠金前交易手数(需要除以100)
 * @property int $clear_reason 赠金扣除原因，1：过期扣除；2：入金扣除；3：出金扣除
 * @property int $cert_time 实名时间
 * @property int $bonus_time 获得赠金时间
 * @property int $refer_id 赠金期间如有入金，则关联入金订单ID，如有出金则关联出金订单ID
 * @property int $clear_time 扣除赠金时间
 * @property string $clear_amount 扣除赠金金额
 * @property int $force_close_orders 是否强制平仓，1：强制平仓；0：未强制平仓
 * @property string $close_orders_detail 记录强制平仓时订单，余额，等信息
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 */
class BonusRecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus_records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid'], 'required'],
            [['mid', 'login', 'amount', 'status', 'trade_volume', 'clear_reason', 'cert_time', 'bonus_time', 'refer_id', 'clear_time', 'force_close_orders', 'create_at', 'update_at'], 'integer'],
            [['clear_amount'], 'number'],
            [['close_orders_detail'], 'string'],
            [['currency'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mid' => 'Mid',
            'login' => 'Login',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'status' => 'Status',
            'trade_volume' => 'Trade Volume',
            'clear_reason' => 'Clear Reason',
            'cert_time' => 'Cert Time',
            'bonus_time' => 'Bonus Time',
            'refer_id' => 'Refer ID',
            'clear_time' => 'Clear Time',
            'clear_amount' => 'Clear Amount',
            'force_close_orders' => 'Force Close Orders',
            'close_orders_detail' => 'Close Orders Detail',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
