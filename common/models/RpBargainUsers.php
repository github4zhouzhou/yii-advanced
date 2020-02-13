<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rp_bargain_users".
 *
 * @property int $id
 * @property int $mid 参与活动的人的mid
 * @property string $current_amount 当前金额
 * @property int $status 当前状态，0 参与中，1 已达标，2 已领取
 * @property int $event_id 活动id
 * @property int $join_number 参与次数
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class RpBargainUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_bargain_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'status', 'event_id', 'join_number', 'created_at', 'updated_at'], 'integer'],
            [['current_amount'], 'number'],
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
            'current_amount' => 'Current Amount',
            'status' => 'Status',
            'event_id' => 'Event ID',
            'join_number' => 'Join Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
