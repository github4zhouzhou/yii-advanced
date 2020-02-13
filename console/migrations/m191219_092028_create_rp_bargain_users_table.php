<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rp_bargain_users`.
 */
class m191219_092028_create_rp_bargain_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rp_bargain_users', [
            'id' => $this->primaryKey(),
			'mid' => $this->integer()->comment('参与活动的人的mid'),
			'current_amount' => $this->decimal(10,2)->comment('当前金额'),
			'status' => $this->smallInteger(6)->comment('当前状态，0 参与中，1 已达标，2 已领取'),
			'event_id' => $this->integer()->comment('活动id'),
			'join_number' => $this->integer()->comment('参与次数'),
			'created_at' => $this->integer()->defaultValue(0)->comment('创建时间'),
			'updated_at' => $this->integer()->defaultValue(0)->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rp_bargain_users');
    }
}
