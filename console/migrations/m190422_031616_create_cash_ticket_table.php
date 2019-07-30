<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cash_ticket`.
 */
class m190422_031616_create_cash_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('cash_ticket', [
			'id' => $this->primaryKey(),
			'event_id' => $this->integer()->notNull()->comment('活动ID'),
			'status' => $this->smallInteger(5)->defaultValue(0)->comment('状态'),
			'valid_month' => $this->string(6)->comment('返现券又可以称为月券，如201905'),
			'accept_period' => $this->string()->comment('可领取时间段，为空则采用默认值。json格式{start:15011114343, end: 12434343434}'),
			'color' => $this->string(64)->comment('返回给客户端的颜色，如#FF00FF'),
			'ticket_type' => $this->smallInteger(5)->defaultValue(0)->comment('返现券类型，返现券规则组合'),
			'ticket_level' => $this->smallInteger()->defaultValue(0)->comment('券级别，银券，金券，白金券'),
			'title' => $this->string(64)->notNull()->comment('标题'),
			'description' => $this->string()->defaultValue('')->comment('描述'),
			'expired_accept' => $this->smallInteger(5)->defaultValue(0)->comment('是否过期自动领取'),
			'dispatch_type' => $this->smallInteger(5)->defaultValue(0)->comment('发放条件类型，如邀请好友'),
			'dispatch_value' => $this->string()->defaultValue('')->comment('发放条件值，如要求好友个数'),
			'extra_data' => $this->text()->comment('预留，方便补充其他信息'),
			'created_at' => $this->integer()->defaultValue(0)->comment('创建时间'),
			'updated_at' => $this->integer()->defaultValue(0)->comment('更新时间')
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cash_ticket');
    }
}
