<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "push_config".
 *
 * @property int $id
 * @property int $mid 用户ID
 * @property int $push_notice 是否推送公告
 * @property int $push_trade 是否推送交易
 * @property int $push_news 是否推送新闻
 * @property int $push_monitor 是否推送行情监控
 * @property int $push_custom 是否推送我的提醒
 * @property int $period_start 接收推送时间段的开始时间(UTC)，8代表上午8点
 * @property int $period_end 接收推送时间段的结束时间(UTC)，23代表晚上23点
 */
class PushConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'push_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'push_notice', 'push_trade', 'push_news', 'push_monitor', 'push_custom', 'period_start', 'period_end'], 'integer'],
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
            'push_notice' => 'Push Notice',
            'push_trade' => 'Push Trade',
            'push_news' => 'Push News',
            'push_monitor' => 'Push Monitor',
            'push_custom' => 'Push Custom',
            'period_start' => 'Period Start',
            'period_end' => 'Period End',
        ];
    }
}
