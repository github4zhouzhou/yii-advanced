<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "open_account_detail".
 *
 * @property int $id
 * @property int $mid 用户的ID，唯一标识符
 * @property int $platform 开户平台, 0: ubfx, 1: hantec
 * @property int $status 开户状态, -1未完成，0审核中，1审核通过，2审核未通过
 * @property int $completed_step 完成第几步了
 * @property string $next_step 下一步的信息
 * @property string $foreign_uid 第三方数据库用户ID
 * @property string $nick_name 用户昵称
 * @property string $first_name 名
 * @property string $middle_name 中间名，外国人会用到
 * @property string $last_name 姓
 * @property string $email 邮件
 * @property string $phone 电话
 * @property string $country 开户时选的国家
 * @property string $language 开户时用户选的语言
 * @property string $base_currency 货币单位
 * @property int $leverage 交易杠杆
 * @property int $title 称谓，枚举值
 * @property string $title_other 自定义称谓
 * @property string $birth_date 出生日期
 * @property string $birth_country 出生国家
 * @property string $nationality 国籍
 * @property int $identify_type 证件类型
 * @property string $identification 证件号码
 * @property int $question 安全问题，枚举值
 * @property string $answer 安全问题答案
 * @property int $account_type 0:Forex/CFD,1:Spread Bet
 * @property string $password 第三方平台（hantec）开始时的密码
 * @property string $address_detail 用户地址的详细信息
 * @property string $financial_detail 用户的财务信息
 * @property string $experience_detail 用户的外汇经验
 * @property string $experience_questions 用户回答的外汇问题和答案
 * @property string $document 用户上传的文件信息
 * @property int $mt_login 开户成功后分配的mt4 login,非必要字段
 * @property string $extra_msg 预留字段，添加额外信息
 * @property string $reserved 预留字段，添加额外信息
 * @property int $created_at
 * @property int $updated_at
 */
class OpenAccountDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'open_account_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'platform'], 'required'],
            [['mid', 'platform', 'status', 'completed_step', 'leverage', 'title', 'identify_type', 'question', 'account_type', 'mt_login', 'created_at', 'updated_at'], 'integer'],
            [['next_step', 'address_detail', 'financial_detail', 'experience_detail', 'experience_questions', 'document', 'extra_msg', 'reserved'], 'string'],
            [['foreign_uid', 'email'], 'string', 'max' => 128],
            [['nick_name', 'first_name', 'middle_name', 'last_name', 'title_other', 'identification', 'password'], 'string', 'max' => 64],
            [['phone', 'country', 'birth_country', 'nationality'], 'string', 'max' => 32],
            [['language', 'base_currency', 'birth_date'], 'string', 'max' => 16],
            [['answer'], 'string', 'max' => 256],
            [['mid', 'platform'], 'unique', 'targetAttribute' => ['mid', 'platform']],
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
            'platform' => 'Platform',
            'status' => 'Status',
            'completed_step' => 'Completed Step',
            'next_step' => 'Next Step',
            'foreign_uid' => 'Foreign Uid',
            'nick_name' => 'Nick Name',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'country' => 'Country',
            'language' => 'Language',
            'base_currency' => 'Base Currency',
            'leverage' => 'Leverage',
            'title' => 'Title',
            'title_other' => 'Title Other',
            'birth_date' => 'Birth Date',
            'birth_country' => 'Birth Country',
            'nationality' => 'Nationality',
            'identify_type' => 'Identify Type',
            'identification' => 'Identification',
            'question' => 'Question',
            'answer' => 'Answer',
            'account_type' => 'Account Type',
            'password' => 'Password',
            'address_detail' => 'Address Detail',
            'financial_detail' => 'Financial Detail',
            'experience_detail' => 'Experience Detail',
            'experience_questions' => 'Experience Questions',
            'document' => 'Document',
            'mt_login' => 'Mt Login',
            'extra_msg' => 'Extra Msg',
            'reserved' => 'Reserved',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
