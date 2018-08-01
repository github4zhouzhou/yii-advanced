<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wpfx_dynamic_news".
 *
 * @property int $id
 * @property int $status 状态，启用和禁用
 * @property string $title 标题
 * @property string $doc_id id
 * @property string $detail_url 详情的url
 * @property int $timestamp 时间戳
 * @property string $summary 摘要
 * @property string $first_key 第一关键字
 * @property string $tags 所有关键字
 * @property string $image 图片的url
 * @property int $type 快讯类型，分类规则也不清楚
 * @property string $content 快讯内容
 * @property int $lmid
 * @property string $source 快讯来源
 * @property string $lang 语言 zh_CN, en
 * @property string $custom 自定义字段，方便扩展
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class WpfxDynamicNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wpfx_dynamic_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'timestamp', 'type', 'lmid', 'created_at', 'updated_at'], 'integer'],
            [['doc_id', 'timestamp'], 'required'],
            [['summary', 'tags', 'content', 'custom'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['doc_id', 'detail_url', 'first_key'], 'string', 'max' => 128],
            [['image'], 'string', 'max' => 256],
            [['source'], 'string', 'max' => 64],
            [['lang'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'title' => 'Title',
            'doc_id' => 'Doc ID',
            'detail_url' => 'Detail Url',
            'timestamp' => 'Timestamp',
            'summary' => 'Summary',
            'first_key' => 'First Key',
            'tags' => 'Tags',
            'image' => 'Image',
            'type' => 'Type',
            'content' => 'Content',
            'lmid' => 'Lmid',
            'source' => 'Source',
            'lang' => 'Lang',
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
