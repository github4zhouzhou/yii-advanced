<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lottery_collection_records`.
 */
class m191213_075221_create_lottery_collection_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('lottery_collection_records', [
			'id' => $this->primaryKey(),
			'mid' => $this->integer()->comment('获奖人mid'),
			'prize_id' => $this->integer()->comment('获得奖项id'),
			'prize_type' => $this->integer()->comment('奖项类型，字，积分，谢谢惠顾'),
			'remark' => $this->string(64)->comment('备注'),
			'created_at' => $this->integer()->defaultValue(0)->comment('创建时间'),
			'updated_at' => $this->integer()->defaultValue(0)->comment('更新时间'),
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('lottery_collection_records');
    }
}
