<?php

use yii\db\Migration;

/**
 * Handles the creation of table `wattfx_demo_trade_cache`.
 */
class m191016_064901_create_wattfx_demo_trade_cache_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('wattfx_demo_trade_cache', [
            'id' => $this->primaryKey(),
			'trade_hand' => $this->decimal(10, 2)->defaultValue(0)->comment('交易手数'),
			'trade_timestamp' => $this->integer(11)->defaultValue(0)->comment('计算交易手数的截止时间'),
			'created_at' => $this->integer(11)->defaultValue(0)->comment('创建时间'),
			'updated_at' => $this->integer(11)->defaultValue(0)->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('wattfx_demo_trade_cache');
    }
}
