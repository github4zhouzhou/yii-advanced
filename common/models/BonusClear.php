<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus_clear".
 *
 * @property int $id
 * @property int $mid 领取人ID
 * @property int $record_id 清零的是赠金哪个记录
 * @property int $money_id 清零赠金在money表的记录
 * @property int $clear_type 1 过期清零；2 入金清零；3 出金清零
 * @property string $clear_amount 扣除赠金金额
 * @property int $has_open_order 清零赠金时用户是否有持仓订单
 * @property string $allowance 余额为负数，补会0的金额
 * @property int $allowance_time 发放补贴的时间
 * @property int $open_volume 增金期间开仓的手数
 * @property string $profit 清零时的盈利情况
 * @property int $deposit_id 增金交易期间有没有入金
 * @property string $extras 扩展字段，方便不同类型时有不同的意义的字段
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class BonusClear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus_clear';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'record_id', 'money_id', 'clear_type', 'has_open_order', 'allowance_time', 'open_volume', 'deposit_id', 'created_at', 'updated_at'], 'integer'],
            [['record_id'], 'required'],
            [['clear_amount', 'allowance', 'profit'], 'number'],
            [['extras'], 'string'],
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
            'record_id' => 'Record ID',
            'money_id' => 'Money ID',
            'clear_type' => 'Clear Type',
            'clear_amount' => 'Clear Amount',
            'has_open_order' => 'Has Open Order',
            'allowance' => 'Allowance',
            'allowance_time' => 'Allowance Time',
            'open_volume' => 'Open Volume',
            'profit' => 'Profit',
            'deposit_id' => 'Deposit ID',
            'extras' => 'Extras',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
