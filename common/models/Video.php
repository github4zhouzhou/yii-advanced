<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property int $id
 * @property string $title 新闻标题
 * @property string $url 视频地址
 * @property string $image 图片地址
 * @property int $status 状态，0:禁用，1:启用
 * @property int $category 大分类，如新闻直播,视频教程等
 * @property int $sub_category 子分类，如视频教程分为基础教学，高级教学等,0 表示没有子分类
 * @property int $sort 排序
 * @property int $view_conditions 观看条件,按位与的值 1,2,4
 * @property string $custom 方便扩充，暂时没有
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Video extends \yii\db\ActiveRecord
{
    // status
    const STATUS_N = 0;
    const STATUS_Y = 1;

    // category
    const CATE_CCTV = 1;
    const CATE_TEACH = 2;   // 教学

    // sub_category
    const SUB_CATE_NULL = 0;   // 表示没有子分类
    const SUB_CATE_TECH_1 = 1; // 基础知识，往期回顾
    const SUB_CATE_TECH_2 = 2; // 每日分析
    const SUB_CATE_CCTV_1 = 11;
    const SUB_CATE_CCTV_2 = 12;

    const VIEW_COND_LOGIN = 1;
    const VIEW_COND_DEPOSIT = 2;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url', 'category'], 'required'],
            [['status', 'sort', 'category', 'sub_category', 'view_conditions', 'created_at', 'updated_at'], 'integer'],
            [['custom'], 'string'],
            [['title', 'url', 'image'], 'string', 'max' => 255],
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
            'url' => 'Url',
            'image' => 'Image',
            'status' => 'Status',
            'category' => 'Category',
            'sub_category' => 'Sub Category',
            'custom' => 'Custom',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
