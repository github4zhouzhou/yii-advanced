<?php

use yii\db\Migration;

/**
 * Class m190222_071253_bonus_records
 */
class m190222_071253_bonus_records extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('{{%bonus_records}}', [
			'id' => $this->primaryKey(),
			'mid' => $this->integer()->notNull()->comment('用户ID'),
			'login' => $this->integer(11)->defaultValue(0)->notNull()->comment('mt4账号'),
			'amount' => $this->integer()->defaultValue(0)->comment('赠金金额'),
			'currency' => $this->string()->defaultValue('')->comment('赠金币种默认是USD'),
			'status' => $this->smallInteger()->defaultValue(0)->comment('状态，1：赠金已发放;2:赠金已扣除;'),
			'trade_volume' => $this->integer()->defaultValue(0)->comment('扣除赠金前交易手数(需要除以100)'),
			'clear_reason' => $this->smallInteger()->defaultValue(0)->comment('赠金扣除原因，1：过期扣除；2：入金扣除；3：出金扣除'),
			'cert_time' => $this->integer(11)->defaultValue(0)->notNull()->comment('实名时间'),
			'bonus_time' =>  $this->integer(11)->defaultValue(0)->notNull()->comment('获得赠金时间'),
			'refer_id' => $this->integer()->defaultValue(0)->comment('赠金期间如有入金，则关联入金订单ID，如有出金则关联出金订单ID'),
			'clear_time' => $this->integer(11)->defaultValue(0)->notNull()->comment('扣除赠金时间'),
			'clear_amount' => $this->decimal(8, 2)->defaultValue(0)->comment('扣除赠金金额'),
			'force_close_orders' => $this->smallInteger()->defaultValue(0)->comment('是否强制平仓，1：强制平仓；0：未强制平仓'),
			'close_orders_detail' => $this->text()->comment('记录强制平仓时订单，余额，等信息'),
			'create_at' => $this->integer(11)->defaultValue(0)->notNull()->comment('创建时间'),
			'update_at' => $this->integer(11)->defaultValue(0)->notNull()->comment('更新时间'),
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190222_071253_bonus_records cannot be reverted.\n";

		$this->dropTable('{{%bonus_records}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190222_071253_bonus_records cannot be reverted.\n";

        return false;
    }
    */
}
