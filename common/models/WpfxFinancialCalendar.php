<?php

namespace common\models;

use Yii;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "wpfx_financial_calendar".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $event_id 事件ID
 * @property string $data_tag 数据标签，未知
 * @property string $country 国家
 * @property string $country_code 国家简写
 * @property string $currency 货币
 * @property string $content 内容
 * @property int $important 重要程度
 * @property string $actual 实际值
 * @property string $forecast 预期值
 * @property string $previous 前值
 * @property string $revised 修正值
 * @property int $timestamp 时间戳
 * @property string $meta_id 媒体ID,未知用途
 * @property int $platform_source 平台源，具体数值代表啥还不清楚
 * @property string $third_id 第三方平台的ID,记录从哪里扒的数据
 * @property int $type 类型，分类规则也不清楚
 * @property string $event_type 事件类型
 * @property string $effect_rule 未知
 * @property string $effect 未知
 * @property string $lang 语言
 * @property string $custom 自定义字段，方便扩展
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class WpfxFinancialCalendar extends \yii\db\ActiveRecord
{
    const TYPE_NORMAL = 1;
    const TYPE_REPORT = 2;      // 报告，演讲
    const TYPE_FESTIVAL = 3;    // 节日

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wpfx_financial_calendar';
    }

    public static function getDb()
    {
        try {
            return Yii::$app->get('db');
        } catch (InvalidConfigException $e) {
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'event_id', 'timestamp'], 'required'],
            [['important', 'timestamp', 'platform_source', 'type', 'created_at', 'updated_at'], 'integer'],
            [['content', 'custom'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['data_tag', 'third_id', 'event_id', 'meta_id'], 'string', 'max' => 128],
            [['country', 'effect_rule', 'effect'], 'string', 'max' => 32],
            [['country_code', 'lang', 'actual', 'forecast', 'previous', 'revised'], 'string', 'max' => 16],
            [['currency'], 'string', 'max' => 8],
            [['event_type'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'event_id' => 'Event ID',
            'data_tag' => 'Data Tag',
            'country' => 'Country',
            'country_code' => 'Country Code',
            'currency' => 'Currency',
            'content' => 'Content',
            'important' => 'Important',
            'actual' => 'Actual',
            'forecast' => 'Forecast',
            'previous' => 'Previous',
            'revised' => 'Revised',
            'timestamp' => 'Timestamp',
            'meta_id' => 'Meta ID',
            'platform_source' => 'Platform Source',
            'third_id' => 'Third ID',
            'type' => 'Type',
            'event_type' => 'Event Type',
            'effect_rule' => 'Effect Rule',
            'effect' => 'Effect',
            'custom' => 'Custom',
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
