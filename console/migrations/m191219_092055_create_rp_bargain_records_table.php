<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rp_bargain_records`.
 */
class m191219_092055_create_rp_bargain_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rp_bargain_records', [
            'id' => $this->primaryKey(),
			'mid' => $this->integer()->comment('参与活动的人的mid'),
			'type' => $this->smallInteger(6)->comment('类型，加速（分享，入金），助力（好友入金，交易）'),
			'amount' => $this->decimal(10, 2)->comment('本次加速或助力得到金额'),
			'join_number' => $this->smallInteger(6)->comment('第几次参与'),
			'friend_id' => $this->integer()->defaultValue(0)->comment('助力好友的mid'),
			'extras' => $this->text()->comment('额外信息'),
			'created_at' => $this->integer()->defaultValue(0)->comment('创建时间'),
			'updated_at' => $this->integer()->defaultValue(0)->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rp_bargain_records');
    }
}
