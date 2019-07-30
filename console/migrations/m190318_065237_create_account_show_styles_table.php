<?php

use yii\db\Migration;

/**
 * Handles the creation of table `account_show_styles`.
 */
class m190318_065237_create_account_show_styles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('account_show_styles', [
            'id' => $this->primaryKey(),
			'bg_color' => $this->string(64)->comment('背景颜色'),
			'text_color' => $this->string(32)->comment('文字颜色'),
			'login_group' => $this->string(32)->comment('账号分组'),
			'group_icon' => $this->string(255)->comment('图片链接'),
			'created_at' => $this->integer(11),
			'updated_at' => $this->integer(11)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('account_show_styles');
    }
}
