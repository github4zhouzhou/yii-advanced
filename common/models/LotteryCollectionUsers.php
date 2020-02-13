<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lottery_collection_users".
 *
 * @property int $id
 * @property int $mid 抽奖人mid
 * @property int $trade_volumes 已交易手数
 * @property int $deposit_amount 已充值金额（非净入金）
 * @property int $invited_num 邀请人数
 * @property int $current_lottery_times 当前可抽奖次数，每抽一次减少一次
 * @property int $total_lottery_times 当前用户一共可抽奖次数
 * @property string $remark 备注
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class LotteryCollectionUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lottery_collection_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'trade_volumes', 'deposit_amount', 'invited_num', 'current_lottery_times', 'total_lottery_times', 'created_at', 'updated_at'], 'integer'],
            [['remark'], 'string', 'max' => 64],
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
            'trade_volumes' => 'Trade Volumes',
            'deposit_amount' => 'Deposit Amount',
            'invited_num' => 'Invited Num',
            'current_lottery_times' => 'Current Lottery Times',
            'total_lottery_times' => 'Total Lottery Times',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
