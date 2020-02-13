<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bonus_record`.
 */
class m191107_100319_create_bonus_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('bonus_record', [
			'id' => $this->primaryKey(),
			'mid' => $this->integer()->unique()->notNull()->comment('领取人ID'),
			'mt_login' => $this->integer()->unique()->notNull()->comment('领取人mt4账号'),
			'mt_group' => $this->string(16)->comment('切换赠金组前的组，恢复时会用到'),
			'amount' => $this->decimal(10, 2)->defaultValue(0)->comment('赠金金额'),
			'valid_time' => $this->integer()->notNull()->comment('赠金的有效时间（秒）'),
			'expired_time' => $this->integer()->notNull()->comment('赠金过期时间'),
			'status' => $this->smallInteger(6)->defaultValue(1)->comment('状态：0 未发放；1 使用中；2 已清零；'),
			'money_id' => $this->integer()->defaultValue(0)->comment('这笔赠金在money表的记录'),
			'event_id' => $this->integer()->defaultValue(0)->comment('哪个活动发放的赠金，非活动发放为0'),
			'clear_id' => $this->integer()->defaultValue(0)->comment('清除赠金记录管理id'),
			'clear_type' => $this->smallInteger(6)->defaultValue(0)->comment('1 过期清零；2 入金清零；3 出金清零'),
			'extras' => $this->text()->comment('扩展字段，方便不同类型时有不同的意义的字段'),
			'created_at' => $this->integer()->defaultValue(0)->comment('创建时间'),
			'updated_at' => $this->integer()->defaultValue(0)->comment('更新时间')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('bonus_record');
    }
}
