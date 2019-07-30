<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pop_config`.
 */
class m190319_034844_create_pop_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pop_config', [
            'id' => $this->primaryKey(),
			'title' => $this->string(64)->defaultValue('')->notNull()->comment('标题'),
			'active' => $this->smallInteger(1)->defaultValue(2)->notNull()->comment('活动状态：1=开启；2=关闭'),
			'lang' => $this->string(6)->defaultValue('')->notNull()->comment('语言：zh-CN;en-US'),
			'app_name' => $this->string(256)->defaultValue('')->notNull()->comment('包名'),
			'app_id' => $this->string(256)->defaultValue('')->notNull()->comment('app 标识'),
			'img' => $this->string(256)->defaultValue('')->notNull()->comment('图片路径'),
			'redirect' => $this->string(256)->defaultValue('')->notNull()->comment('图片跳转路由'),
			'desc' => $this->text()->comment('描述'),
			'publish_time' => $this->integer(11)->defaultValue(0)->notNull()->comment('发布时间'),
			'expired_time' => $this->integer(11)->defaultValue(0)->notNull()->comment('过期时间'),
			'sort' => $this->integer(5)->defaultValue(0)->notNull()->comment('排序字段'),
			'scene' => $this->smallInteger()->defaultValue(0)->notNull()->comment('弹出场景'),
			'pop_type' => $this->smallInteger()->defaultValue(0)->notNull()->comment('弹窗类型'),
			'pop_times' => $this->smallInteger()->defaultValue(0)->notNull()->comment('弹出次数'),
			'pop_interval' => $this->smallInteger()->defaultValue(0)->notNull()->comment('弹出间隔，每天，每周'),
			'after_click' => $this->smallInteger()->defaultValue(0)->notNull()->comment('弹窗跳转后怎么处理'),
			'after_close' => $this->smallInteger()->defaultValue(0)->notNull()->comment('点击关闭按钮后的操作'),
			'min_version' => $this->smallInteger()->defaultValue(0)->notNull()->comment('最小版本'),
			'max_version' => $this->smallInteger()->defaultValue(0)->notNull()->comment('最大版本'),
			'created_at' => $this->integer(11)->defaultValue(0)->notNull()->comment('创建时间'),
			'updated_at' => $this->integer(11)->defaultValue(0)->notNull()->comment('更新时间')
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pop_config');
    }
}
