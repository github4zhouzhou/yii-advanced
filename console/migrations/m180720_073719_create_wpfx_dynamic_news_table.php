<?php

use yii\db\Migration;

/**
 * Handles the creation of table `wpfx_dynamic_news`.
 */
class m180720_073719_create_wpfx_dynamic_news_table extends Migration
{
    private $table = 'wpfx_dynamic_news';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1)->comment('状态，启用和禁用'),
            'title' => $this->string(255)->comment('标题'),
            'doc_id' => $this->string(128)->notNull()->comment('id'),
            'detail_url' => $this->string(128)->comment('详情的url'),
            'timestamp' => $this->integer(11)->notNull()->comment('时间戳'),
            'summary' => $this->text()->comment('摘要'),
            'first_key' => $this->string(128)->comment('第一关键字'),
            'tags' => $this->text()->comment('所有关键字'),
            'image' => $this->string(256)->comment('图片的url'),
            'type' => $this->smallInteger(6)->comment('快讯类型，分类规则也不清楚'),
            'content' => $this->text()->comment('快讯内容'),
            'lmid' => $this->integer(11)->comment(''),
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
}
