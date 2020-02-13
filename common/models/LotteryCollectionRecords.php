<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lottery_collection_records".
 *
 * @property int $id
 * @property int $mid 获奖人mid
 * @property int $prize_id 获得奖项id
 * @property int $prize_type 奖项类型，字，积分，谢谢惠顾
 * @property string $remark 备注
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class LotteryCollectionRecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lottery_collection_records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'prize_id', 'prize_type', 'created_at', 'updated_at'], 'integer'],
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
            'prize_id' => 'Prize ID',
            'prize_type' => 'Prize Type',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
