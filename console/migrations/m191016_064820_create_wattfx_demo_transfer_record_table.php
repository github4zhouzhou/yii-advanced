<?php

use yii\db\Migration;

/**
 * Handles the creation of table `wattfx_demo_transfer_record`.
 */
class m191016_064820_create_wattfx_demo_transfer_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('wattfx_demo_transfer_record', [
            'id' => $this->primaryKey(),
			'demo' => $this->integer(11)->notNull()->comment('模拟账号'),
			'type' => $this->smallInteger(6)->defaultValue(0)->comment('类型:交易奖励，盈利奖励'),
			'phone' => $this->string(32)->comment('手机号码'),
			'refer_id' => $this->integer(11)->defaultValue(0)->comment('兑现奖励的关联记录'),
			'created_at' => $this->integer(11)->defaultValue(0)->comment('创建时间'),
			'updated_at' => $this->integer(11)->defaultValue(0)->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('wattfx_demo_transfer_record');
    }
}
