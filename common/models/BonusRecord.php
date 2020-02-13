<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus_record".
 *
 * @property int $id
 * @property int $mid 领取人ID
 * @property int $mt_login 领取人mt4账号
 * @property string $mt_group 切换赠金组前的组，恢复时会用到
 * @property string $amount 赠金金额
 * @property int $valid_time 赠金的有效时间（秒）
 * @property int $expired_time 赠金过期时间
 * @property int $status 状态：0 未发放；1 使用中；2 已清零；
 * @property int $money_id 这笔赠金在money表的记录
 * @property int $event_id 哪个活动发放的赠金，非活动发放为0
 * @property int $clear_id 清除赠金记录管理id
 * @property int $clear_type 1 过期清零；2 入金清零；3 出金清零
 * @property string $extras 扩展字段，方便不同类型时有不同的意义的字段
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class BonusRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'mt_login', 'valid_time', 'expired_time'], 'required'],
            [['mid', 'mt_login', 'valid_time', 'expired_time', 'status', 'money_id', 'event_id', 'clear_id', 'clear_type', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['extras'], 'string'],
            [['mt_group'], 'string', 'max' => 16],
            [['mid'], 'unique'],
            [['mt_login'], 'unique'],
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
            'mt_login' => 'Mt Login',
            'mt_group' => 'Mt Group',
            'amount' => 'Amount',
            'valid_time' => 'Valid Time',
            'expired_time' => 'Expired Time',
            'status' => 'Status',
            'money_id' => 'Money ID',
            'event_id' => 'Event ID',
            'clear_id' => 'Clear ID',
            'clear_type' => 'Clear Type',
            'extras' => 'Extras',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
