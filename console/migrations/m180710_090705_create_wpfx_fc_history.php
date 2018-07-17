<?php

use yii\db\Migration;

/**
 * Class m180710_090705_create_wpfx_fc_history
 */
class m180710_090705_create_wpfx_fc_history extends Migration
{
    private $table = 'wpfx_fc_history';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1)->comment("状态"),
            'event_id' => $this->integer(11)->notNull()->comment('事件ID'),
            'data' => $this->text()->comment('json数据'),
            'created_at' => $this->integer(11)->comment('创建时间'),
            'updated_at' => $this->integer(11)->comment('更新时间')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180710_090705_create_wpfx_fc_history cannot be reverted.\n";

        return false;
    }
    */
}
