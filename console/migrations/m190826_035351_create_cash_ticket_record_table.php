<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cash_ticket_record`.
 */
class m190826_035351_create_cash_ticket_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('cash_ticket_record', [
			'id' => $this->primaryKey(),
			'mid' => $this->integer()->notNull()->comment('拥有这张券的人的mid'),
			'name' => $this->string(64)->comment('名称'),
			'status' => $this->smallInteger()->defaultValue(0)->comment('0 未使用，1 使用中，2 已使用，3 已过期'),
			'event_id' => $this->integer()->defaultValue(0)->comment('标记返现券是哪个活动发的，非活动发放就用0'),
			'expired_day' => $this->smallInteger()->notNull()->comment('过期天数，发放后多少天不使用就会过期'),
			'valid_day' => $this->smallInteger()->notNull()->comment('有效天数，使用后返现券的有效天数'),
			'money' => $this->decimal(10, 2)->defaultValue(0)->comment('兑换金额，使用中就是预计兑换金额'),
			'color' => $this->string(32)->notNull()->comment('返现券颜色组'),
			'description' => $this->string(255)->defaultValue('')->comment('对返现券的描述，说明等'),
			'ticket_level' => $this->smallInteger()->defaultValue(0)->comment('返现券级别，1 银券，2 金券，3 白金券'),
			'real_money' => $this->decimal(10, 2)->defaultValue(0)->comment('返现券兑换七天后到账，中间如有问题，发放金额可能会有变化'),
			'remark' => $this->string(255)->comment('备注，有需要就备注一下，没需要可以不写'),
			'message' => $this->string(255)->comment('如果实际发放金额和兑换金额不同，这里记录一下原因'),
			'refer_id' => $this->integer()->defaultValue(0)->comment('关联的money表记录'),
			'exchange_type' => $this->integer()->defaultValue(0)->comment('兑换方式；0 到期自动兑换，1 主动兑换'),
			'exchange_time' => $this->integer()->defaultValue(0)->comment('返现券的兑换时间'),
			'used_day' => $this->integer()->defaultValue(0)->comment('返现券的使用时间，按天计算即当天的零点零分'),
			'used_time' => $this->integer()->defaultValue(0)->comment('返现券的使用时间'),
			'expired_time' => $this->integer()->defaultValue(0)->comment('过期时间，通过发放时间和过期天数算的，方便数据库查询'),
			'created_at' => $this->integer()->defaultValue(0)->comment('创建时间即返现券的发放时间'),
			'updated_at' => $this->integer()->defaultValue(0)->comment('更新时间'),
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cash_ticket_record');
    }
}
