<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dot_config`.
 */
class m190730_092424_create_dot_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dot_config', [
            'id' => $this->primaryKey(),
			'name' => $this->string()->comment('显示名称'),
			'path' => $this->string()->notNull()->comment('红点位置（路径），如uc/account'),
			'status' => $this->smallInteger(1)->defaultValue(0)->comment('状态：0禁用，1启用'),
			'platform' => $this->smallInteger(3)->defaultValue(0)->comment('平台：0 全平台或者不区分平台，1 iOS，2 Android'),
			'package' => $this->string()->defaultValue('all')->comment('包名'),
			'time_period' => $this->float(2)->defaultValue(0)->comment('间隔时间段，即每隔多久就显示一次红点'),
			'publish_at' => $this->integer()->defaultValue(0)->comment('在某个时间段显示红点，时间段的开始时间'),
			'expired_at' => $this->integer()->defaultValue(0)->comment('在某个时间段显示红点，时间段的结束时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dot_config');
    }
}
