<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lottery_collection_prizes`.
 */
class m191213_075137_create_lottery_collection_prizes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('lottery_collection_prizes', [
			'id' => $this->primaryKey(),
			'type' => $this->smallInteger(6)->defaultValue(0)->comment('奖品类型，字，积分'),
			'title' => $this->string(32)->comment('奖项名称，如友、邦、外、汇、10积分等'),
			'award_points' => $this->integer()->defaultValue(0)->comment('奖项价值（积分）'),
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('lottery_collection_prizes');
    }
}
