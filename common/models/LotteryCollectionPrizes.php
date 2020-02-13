<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lottery_collection_prizes".
 *
 * @property int $id
 * @property int $type 奖品类型，字，积分
 * @property string $title 奖项名称，如友、邦、外、汇、10积分等
 * @property int $award_points 奖项价值（积分）
 */
class LotteryCollectionPrizes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lottery_collection_prizes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'award_points'], 'integer'],
            [['title'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'title' => 'Title',
            'award_points' => 'Award Points',
        ];
    }
}
