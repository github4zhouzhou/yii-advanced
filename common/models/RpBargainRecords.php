<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rp_bargain_records".
 *
 * @property int $id
 * @property int $mid 参与活动的人的mid
 * @property int $type 类型，加速（分享，入金），助力（好友入金，交易）
 * @property string $amount 本次加速或助力得到金额
 * @property int $join_number 第几次参与
 * @property int $friend_id 助力好友的mid
 * @property string $extras 额外信息
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class RpBargainRecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_bargain_records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'type', 'join_number', 'friend_id', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
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
            'type' => 'Type',
            'amount' => 'Amount',
            'join_number' => 'Join Number',
            'friend_id' => 'Friend ID',
            'extras' => 'Extras',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
