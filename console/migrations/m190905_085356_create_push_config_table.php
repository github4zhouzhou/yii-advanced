<?php

use yii\db\Migration;

/**
 * Handles the creation of table `push_config`.
 */
class m190905_085356_create_push_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('push_config', [
			'id' => $this->primaryKey(),
			'mid' => $this->integer()->defaultValue(0)->comment('用户ID'),
			'push_notice' => $this->smallInteger()->defaultValue(0)->comment('是否推送公告'),
			'push_trade' => $this->smallInteger()->defaultValue(0)->comment('是否推送交易'),
			'push_news' => $this->smallInteger()->defaultValue(0)->comment('是否推送新闻'),
			'push_monitor' => $this->smallInteger()->defaultValue(0)->comment('是否推送行情监控'),
			'push_custom' => $this->smallInteger()->defaultValue(0)->comment('是否推送我的提醒'),
			'period_start' => $this->smallInteger()->defaultValue(0)->comment('接收推送时间段的开始时间(UTC)，8代表上午8点'),
			'period_end' => $this->smallInteger()->defaultValue(0)->comment('接收推送时间段的结束时间(UTC)，23代表晚上23点'),
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('push_config');
    }
}
