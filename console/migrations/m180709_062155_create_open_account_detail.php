<?php

use yii\db\Migration;

/**
 * Class m180709_062155_create_open_account_detail
 */
class m180709_062155_create_open_account_detail extends Migration
{
    private $table = '{{%open_account_detail}}';

    public function up()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'mid' => $this->integer(11)->notNull()->comment('用户的ID，唯一标识符'),
            'platform' => $this->smallInteger(2)->notNull()->comment('开户平台, 0: ubfx, 1: hantec'),
            'status' => $this->smallInteger(1)->defaultValue(-1)->comment('开户状态, -1未完成，0审核中，1审核通过，2审核未通过'),
            'completed_step' => $this->smallInteger(3)->defaultValue(0)->comment('完成第几步了'),
            'next_step' => $this->text()->comment('下一步的信息'),
            'foreign_uid' => $this->string(128)->comment('第三方数据库用户ID'),
            'nick_name' => $this->string(64)->comment('用户昵称'),
            'first_name' => $this->string(64)->comment('名'),
            'middle_name' => $this->string(64)->comment('中间名，外国人会用到'),
            'last_name' => $this->string(64)->comment('姓'),
            'email' => $this->string(128)->comment('邮件'),
            'phone' => $this->string(32)->comment('电话'),
            'country' => $this->string(32)->comment('开户时选的国家'),
            'language' => $this->string(16)->comment('开户时用户选的语言'),
            'base_currency' => $this->string(16)->comment('货币单位'),
            'leverage' => $this->integer(11)->comment('交易杠杆'),
            'title' => $this->smallInteger(1)->defaultValue(0)->comment('称谓，枚举值'),
            'title_other' => $this->string(64)->comment('自定义称谓'),
            'birth_date' => $this->string(16)->comment('出生日期'),
            'birth_country' => $this->string(32)->comment('出生国家'),
            'nationality' => $this->string(32)->comment('国籍'),
            'identify_type' => $this->smallInteger(1)->defaultValue(0)->comment('证件类型'),
            'identification' => $this->string(64)->comment('证件号码'),
            'question' => $this->smallInteger(1)->comment('安全问题，枚举值'),
            'answer' => $this->string(256)->comment('安全问题答案'),
            'account_type' => $this->smallInteger(1)->defaultValue(0)->comment('0:Forex/CFD,1:Spread Bet'),
            'password' => $this->string(64)->comment('第三方平台（hantec）开始时的密码'),
            'address_detail' => $this->text()->comment('用户地址的详细信息'),
            'financial_detail' => $this->text()->comment('用户的财务信息'),
            'experience_detail' => $this->text()->comment('用户的外汇经验'),
            'experience_questions' => $this->text()->comment('用户回答的外汇问题和答案'),
            'document' => $this->text()->comment('用户上传的文件信息'),
            'mt_login' => $this->integer(11)->defaultValue(0)->comment('开户成功后分配的mt4 login,非必要字段'),
            'extra_msg' => $this->text()->comment('预留字段，添加额外信息'),
            'reserved' => $this->text()->comment('预留字段，添加额外信息'),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11)
        ]);

        // 创建唯一索引
        $this->createIndex('mp', $this->table, ['mid', 'platform'], true);
    }

    public function down()
    {
        $this->dropTable($this->table);
    }
}
