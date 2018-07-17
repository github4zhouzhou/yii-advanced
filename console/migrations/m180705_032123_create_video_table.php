<?php

use yii\db\Migration;

/**
 * Handles the creation of table `video`.
 */
class m180705_032123_create_video_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('video', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('新闻标题'),
            'url' => $this->string(255)->notNull()->comment('视频地址'),
            'image' => $this->string(255)->notNull()->comment('图片地址'),
            'status' => $this->smallInteger(1)->defaultValue(0)->comment('状态，0:禁用，1:启用'),
            'category' => $this->smallInteger(6)->notNull()->comment('大分类，如新闻直播,视频教程等'),
            'sub_category' => $this->smallInteger(6)->defaultValue(0)->comment('子分类，如视频教程分为基础教学，高级教学等,0 表示没有子分类'),
            'sort' => $this->smallInteger(6)->defaultValue(0)->comment('排序'),
            'custom' => $this->text()->comment('方便扩充，暂时没有'),
            'created_at' => $this->integer(11)->comment('创建时间'),
            'updated_at' => $this->integer(11)->comment('更新时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('video');
    }
}
