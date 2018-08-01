<?php

use yii\db\Migration;

/**
 * Class m180726_071953_add_middle_name_to_db_account_table_account
 */
class m180726_071953_add_middle_name_to_db_account_table_account extends Migration
{
    private $table = 'ub_verify_idcard';
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->db = $this->accountDb;
        $this->addColumn($this->table, 'middle_name', $this->string(45)->comment('中间名'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn($this->table, 'middle_name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180726_071953_add_middle_name_to_db_account_table_account cannot be reverted.\n";

        return false;
    }
    */
}
