<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wattfx_demo_trade_cache".
 *
 * @property int $id
 * @property string $trade_hand 交易手数
 * @property int $trade_timestamp 计算交易手数的截止时间
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class WattfxDemoTradeCache extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wattfx_demo_trade_cache';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trade_hand'], 'number'],
            [['trade_timestamp', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trade_hand' => 'Trade Hand',
            'trade_timestamp' => 'Trade Timestamp',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
