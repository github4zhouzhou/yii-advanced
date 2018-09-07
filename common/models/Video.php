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

    public static $bank_list = [
        '01020000' => 'ICBC',       // '工商银行',
        '01050000' => 'CCB',        // '建设银行',
        //'01040000' => 'BOC',        // '中国银行',
        '01030000' => 'ABC',        // '农业银行',
        //'03010000' => 'BCM',        // '交通银行',
        //'03080000' => 'CMB',        // '招商银行',
        //'03020000' => 'CITIC',      // '中信银行',
        '03050000' => 'CMBC',       // '民生银行',
        //'03090000' => 'CIB',        // '兴业银行',
        //'03100000' => 'SPDB',       // '浦发银行',
        '01000000' => 'PSBC',       // '中国邮储银行',
        '03030000' => 'CEB',        // '光大银行',
        //'03070000' => 'PAB',        // '平安银行',
        //'03040000' => 'HXB',        // '华夏银行',
        '04031000' => 'BOB',        // '北京银行',
        //'03060000' => 'GDB',        // '广发银行',
        '04012900' => 'SHBANK',     // '上海银行',
    ];


    public static $bank_name = [
        '01020000' => '工商银行',       // '工商银行',
        '01050000' => '建设银行',        // '建设银行',
        //'01040000' => 'BOC',        // '中国银行',
        '01030000' => '农业银行',        // '农业银行',
        //'03010000' => 'BCM',        // '交通银行',
        //'03080000' => 'CMB',        // '招商银行',
        //'03020000' => 'CITIC',      // '中信银行',
        '03050000' => '民生银行',       // '民生银行',
        //'03090000' => 'CIB',        // '兴业银行',
        //'03100000' => 'SPDB',       // '浦发银行',
        '01000000' => '中国邮储银行',       // '中国邮储银行',
        '03030000' => '光大银行',        // '光大银行',
        //'03070000' => 'PAB',        // '平安银行',
        //'03040000' => 'HXB',        // '华夏银行',
        '04031000' => '北京银行',        // '北京银行',
        //'03060000' => 'GDB',        // '广发银行',
        '04012900' => '上海银行',     // '上海银行',
    ];

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
