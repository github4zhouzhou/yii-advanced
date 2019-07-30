<?php

use yii\db\Migration;

/**
 * Handles the creation of table `manual_certs`.
 */
class m181026_032319_create_manual_certs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('manual_certs', [
            'id' => $this->primaryKey(),
			'mid' => $this->integer(11)->defaultValue(0)->comment('mid'),
			'country' => $this->string(16)->defaultValue('')->comment('国籍'),
			'first_name' => $this->string(16)->defaultValue('')->comment('名'),
			'last_name' => $this->string(16)->defaultValue('')->comment('姓'),
			'sex' => $this->tinyInteger(2)->defaultValue(0)->comment('称谓'),
			'cert_type' => $this->tinyInteger(2)->defaultValue(0)->comment('证件类型'),
			'cert_number' => $this->string(32)->defaultValue('')->comment('证件号码'),
			'birthday' => $this->string(32)->defaultValue('')->comment('出生日期'),
			'address' => $this->string(255)->defaultValue('')->comment('居住地址'),
			'file1' => $this->string('255')->defaultValue('')->comment('证件正面'),
			'file2' => $this->string('255')->defaultValue('')->comment('证件反面'),
			'created_at' => $this->integer(11)->comment('创建时间'),
			'updated_at' => $this->integer(11)->comment('更新时间')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('manual_certs');
    }
}
