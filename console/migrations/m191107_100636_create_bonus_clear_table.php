<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bonus_clear`.
 */
class m191107_100636_create_bonus_clear_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('bonus_clear', [
			'id' => $this->primaryKey(),
			'mid' => $this->integer()->defaultValue(0)->comment('领取人ID'),
			'record_id' => $this->integer()->notNull()->comment('清零的是赠金哪个记录'),
			'money_id' => $this->integer()->defaultValue(0)->comment('清零赠金在money表的记录'),
			'clear_type' => $this->smallInteger(6)->defaultValue(0)->comment('1 过期清零；2 入金清零；3 出金清零'),
			'clear_amount' => $this->decimal(10, 2)->defaultValue(0)->comment('扣除赠金金额'),
			'has_open_order' => $this->smallInteger(6)->defaultValue(0)->comment('清零赠金时用户是否有持仓订单'),
			'allowance' => $this->decimal(10, 2)->comment('余额为负数，补会0的金额'),
			'allowance_time' => $this->integer()->defaultValue(0)->comment('发放补贴的时间'),
			'open_volume' => $this->integer()->defaultValue(0)->comment('增金期间开仓的手数'),
			'profit' => $this->decimal(10,2)->comment('清零时的盈利情况'),
			'deposit_id' => $this->integer()->defaultValue(0)->comment('增金交易期间有没有入金'),
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
        $this->dropTable('bonus_clear');
    }
}
