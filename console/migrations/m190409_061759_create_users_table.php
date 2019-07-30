<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m190409_061759_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
			'phone_number' => $this->string(16)->notNull()->comment('手机号'),
			'access_token' => $this->string(64)->defaultValue('')->comment('token'),
			'email' => $this->string(64)->defaultValue('')->comment('邮箱'),
			'status' => $this->smallInteger()->defaultValue(0)->comment('状态'),
			'created_at' => $this->integer(11)->defaultValue(0)->notNull()->comment('创建时间'),
			'updated_at' => $this->integer(11)->defaultValue(0)->notNull()->comment('更新时间')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
