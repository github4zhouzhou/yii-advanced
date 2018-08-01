<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wpfx_fc_history".
 *
 * @property int $id
 * @property string $event_id 事件ID
 * @property string $source 事件ID
 * @property string $data json数据
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class WpfxFcHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wpfx_fc_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['data', 'event_id', 'source'], 'string'],
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
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
        }
        $this->updated_at = time();

        return parent::beforeSave($insert);
    }
}
