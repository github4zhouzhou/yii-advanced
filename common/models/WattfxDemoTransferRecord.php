<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wattfx_demo_transfer_record".
 *
 * @property int $id
 * @property int $demo 模拟账号
 * @property int $type 类型:交易奖励，盈利奖励
 * @property string $phone 手机号码
 * @property int $refer_id 兑现奖励的关联记录
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class WattfxDemoTransferRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wattfx_demo_transfer_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['demo'], 'required'],
            [['demo', 'type', 'refer_id', 'created_at', 'updated_at'], 'integer'],
            [['phone'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'demo' => 'Demo',
            'type' => 'Type',
            'phone' => 'Phone',
            'refer_id' => 'Refer ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
