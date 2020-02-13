<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lottery_collection_users`.
 */
class m191213_074929_create_lottery_collection_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('lottery_collection_users', [
			'id' => $this->primaryKey(),
			'mid' => $this->integer()->comment('抽奖人mid'),
			'trade_volumes' => $this->integer()->comment('已交易手数'),
			'deposit_amount' => $this->integer()->comment('已充值金额（非净入金）'),
			'invited_num' => $this->integer()->comment('邀请人数'),
			'current_lottery_times' => $this->integer()->comment('当前可抽奖次数，每抽一次减少一次'),
			'total_lottery_times' => $this->integer()->comment('当前用户一共可抽奖次数'),
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
        $this->dropTable('lottery_collection_users');
    }
}
