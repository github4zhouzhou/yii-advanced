<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wpfx_news_flash".
 *
 * @property int $id
 * @property string $title 新闻快讯标题
 * @property int $flash_id 快讯ID
 * @property string $third_id 第三方平台的ID,记录从哪里扒的数据
 * @property int $platform_source 平台源，具体数值代表啥还不清楚
 * @property int $type 快讯类型，分类规则也不清楚
 * @property string $content 快讯内容
 * @property int $timestamp 时间戳
 * @property string $source 快讯来源
 * @property string $lang 语言
 * @property string $custom 自定义字段，方便扩展
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class WpfxNewsFlash extends \yii\db\ActiveRecord
{

    const TYPE_FLASH = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wpfx_news_flash';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flash_id', 'timestamp'], 'required'],
            [['flash_id', 'platform_source', 'type', 'timestamp', 'created_at', 'updated_at'], 'integer'],
            [['content', 'custom'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['third_id'], 'string', 'max' => 128],
            [['lang'], 'string', 'max' => 16],
            [['title', 'source'], 'string', 'max' => 64],
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
            'flash_id' => 'Flash ID',
            'third_id' => 'Third ID',
            'platform_source' => 'Platform Source',
            'type' => 'Type',
            'content' => 'Content',
            'timestamp' => 'Timestamp',
            'source' => 'Source',
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
