<?php
/**
 * Created by PhpStorm.
 * User: zhouzhou
 * Date: 2018/7/5
 * Time: 上午11:48
 */

namespace backend\models;


use Yii;
use yii\web\UploadedFile;

class Video extends \common\models\Video
{
    public static $arr_status = [
        self::STATUS_Y => '启用',
        self::STATUS_N => '禁用',
    ];

    public static $arr_cate = [
        self::CATE_CCTV => 'CCTV',
        self::CATE_TEACH => '视频教学',
    ];

    public static $arr_sub_cate = [
        self::SUB_CATE_NULL => '无',
        self::SUB_CATE_TECH_1 => '往期回顾',
        self::SUB_CATE_TECH_2 => '视频教学'
    ];

    public static $arr_sub_category = [
        self::CATE_CCTV => [
            self::SUB_CATE_NULL => '无',
            self::SUB_CATE_CCTV_1 => 'CCTV1',
            self::SUB_CATE_CCTV_2 => 'CCTV2',
        ],
        self::CATE_TEACH => [
            self::SUB_CATE_NULL => '无',
            self::SUB_CATE_TECH_1 => '往期回顾',
            self::SUB_CATE_TECH_2 => '视频教学'
        ]
    ];

    public static $arr_view_conditions = [
        self::VIEW_COND_LOGIN => '登录才能观看',
        self::VIEW_COND_DEPOSIT => '充值才能观看',
    ];

    public static function getSubCate($category) {
        if (!$category) {
            $category = 1;
        }

        return self::$arr_sub_category[$category];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'url' => '视频地址',
            'image' => '图片地址',
            'status' => '状态',
            'category' => '分类',
            'sub_category' => '子分类',
            'sort' => '排序',
            'custom' => '自定义内容',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function makeViewConditionsArray($val) {
        $result = [];
        if (in_array(self::$arr_view_conditions)) {
            $result[] = $val;

        }
        return $result;
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
        }
        $this->updated_at = time();

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function beforeValidate()
    {
        if (is_array($this->view_conditions)) {
            $result = 0;
            foreach ($this->view_conditions as $val) {
                $result += $val;
            }
            $this->view_conditions = $result;
        }

        $img = UploadedFile::getInstance($this, 'image');

        if ($img && $img->extension) {
            $cdn_dir = '/data/cdn';
            $filePath = sprintf('/video/%s/%s.%s', date('Y/m/d'), uniqid(), $img->extension);
            $full_path = $cdn_dir . $filePath;
            $dir = dirname($full_path);
            if(!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $res = $img->saveAs($full_path);
            if($res){
                $this->image = $filePath;
            }
        }

        return parent::beforeValidate();
    }
}