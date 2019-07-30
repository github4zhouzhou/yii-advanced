<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cash_ticket".
 *
 * @property int $id
 * @property int $event_id 活动ID
 * @property int $status 状态
 * @property string $valid_month 返现券又可以称为月券，如201905
 * @property string $accept_period 可领取时间段，为空则采用默认值。json格式{start:15011114343, end: 12434343434}
 * @property string $color 返回给客户端的颜色，如#FF00FF
 * @property int $ticket_type 返现券类型，返现券规则组合
 * @property int $ticket_level 券级别，银券，金券，白金券
 * @property string $title 标题
 * @property string $description 描述
 * @property int $expired_accept 是否过期自动领取
 * @property int $dispatch_type 发放条件类型，如邀请好友
 * @property string $dispatch_value 发放条件值，如要求好友个数
 * @property string $extra_data 预留，方便补充其他信息
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class CashTicket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cash_ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'valid_month'], 'required'],
            [['event_id', 'status', 'ticket_type', 'ticket_level', 'expired_accept', 'dispatch_type', 'created_at', 'updated_at'], 'integer'],
            [['extra_data'], 'string'],
            [['valid_month'], 'string', 'max' => 6],
            [['accept_period', 'description', 'dispatch_value'], 'string', 'max' => 255],
            [['color', 'title'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'status' => 'Status',
            'valid_month' => 'Valid Month',
            'accept_period' => 'Accept Period',
            'color' => 'Color',
            'ticket_type' => 'Ticket Type',
            'ticket_level' => 'Ticket Level',
            'title' => 'Title',
            'description' => 'Description',
            'expired_accept' => 'Expired Accept',
            'dispatch_type' => 'Dispatch Type',
            'dispatch_value' => 'Dispatch Value',
            'extra_data' => 'Extra Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
