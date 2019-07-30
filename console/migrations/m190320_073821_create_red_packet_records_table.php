<?php

use yii\db\Migration;

/**
 * Handles the creation of table `red_packet_records`.
 */
class m190320_073821_create_red_packet_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('red_packet_records', [
            'id' => $this->primaryKey(),
			'title' => $this->string(32)->notNull()->defaultValue('')->comment('标题'),
			'owner_id' => $this->integer()->notNull()->comment("红包的拥有者"),
			'amount' => $this->decimal(10, 2)->defaultValue(0)->comment("红包金额"),
			'currency' => $this->string(8)->comment('货币种类'),
			'achieve_condition_type' => $this->smallInteger()->defaultValue(0)->comment('红包领取类型:建仓手数，入金等'),
			'achieve_condition_value' => $this->string(10)->defaultValue('')->comment("满足条件类型值 如：大于10手数此处填10"),
			'expire_hours' => $this->integer()->defaultValue(0)->comment('过期小时数'),
			'relative_line' => $this->smallInteger()->defaultValue(0)->comment('相对于什么时间  0注册时间  1活动开始时间'),
			'status' => $this->smallInteger()->defaultValue(0)->comment('状态；0：未拆开 1：已拆开；2：已过期'),
			'add_condition' => $this->string(255)->defaultValue('')->comment('附加条件'),
			'created_at' => $this->integer(11)->defaultValue(0)->notNull()->comment('创建时间'),
			'updated_at' => $this->integer(11)->defaultValue(0)->notNull()->comment('更新时间')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('red_packet_records');
    }
}
