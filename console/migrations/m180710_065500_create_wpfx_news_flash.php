<?php

use yii\db\Migration;

/**
 * Class m180710_065500_create_wpfx_news_flash
 */
class m180710_065500_create_wpfx_news_flash extends Migration
{
    private $table = 'wpfx_news_flash';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1)->comment('状态，启用和禁用'),
            'title' => $this->string(255)->comment('新闻快讯标题'),
            'flash_id' => $this->integer(11)->notNull()->comment('快讯ID'),
            'third_id' => $this->string(128)->comment('第三方平台的ID,记录从哪里扒的数据'),
            'platform_source' => $this->integer(11)->comment('平台源，具体数值代表啥还不清楚'),
            'type' => $this->smallInteger(6)->comment('快讯类型，分类规则也不清楚'),
            'content' => $this->text()->comment('快讯内容'),
            'timestamp' => $this->integer(11)->notNull()->comment('时间戳'),
            'source' => $this->string(64)->comment('快讯来源'),
            'lang' => $this->string(16)->comment('语言 zh_CN, en'),
            'custom' => $this->text()->comment('自定义字段，方便扩展'),
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
        echo "m180710_065500_create_wpfx_news_flash cannot be reverted.\n";

        return false;
    }
    */
}
