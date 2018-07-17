<?php

use yii\db\Migration;

/**
 * Class m180710_071659_create_wpfx_financial_calendar
 */
class m180710_071659_create_wpfx_financial_calendar extends Migration
{
    private $table = 'wpfx_financial_calendar';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1)->comment('状态'),
            'title' => $this->string(255)->comment('标题'),
            'event_id' => $this->integer(11)->notNull()->comment('事件ID'),
            'data_tag' => $this->string(128)->comment('数据标签，未知'),
            'country' => $this->string('32')->comment('国家'),
            'country_code' => $this->string(16)->comment('国家简写'),
            'currency' => $this->string(8)->comment('货币'),
            'content' => $this->text()->comment('内容'),
            'important' => $this->smallInteger(6)->comment('重要程度'),
            'actual' => $this->string(16)->comment('实际值'),
            'forecast' => $this->string(16)->comment('预期值'),
            'previous' => $this->string(16)->comment('前值'),
            'revised' => $this->string(16)->comment('修正值'),
            'timestamp' => $this->integer(11)->notNull()->comment('时间戳'),
            'meta_id' => $this->integer(11)->comment('媒体ID,未知用途'),
            'platform_source' => $this->integer(11)->comment('平台源，具体数值代表啥还不清楚'),
            'third_id' => $this->string(128)->comment('第三方平台的ID,记录从哪里扒的数据'),
            'type' => $this->smallInteger(6)->comment('类型，分类规则也不清楚'),
            'event_type' => $this->string(64)->comment('事件类型'),
            'effect_rule' => $this->string(32)->comment('未知'),
            'effect' => $this->string(32)->comment('未知'),
            'lang' => $this->string(16)->comment('语言zh_CN, en'),
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
        echo "m180710_071659_create_wpfx_financial_calendar cannot be reverted.\n";

        return false;
    }
    */
}
