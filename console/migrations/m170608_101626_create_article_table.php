<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170608_101626_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'intro'=>$this->text()->notNull()->comment('简介'),
            'article_category_id'=>$this->integer()->notNull()->comment('文章分类id'),
            'sort'=>$this->integer(11)->notNull()->comment('排序'),
            'status'=>$this->integer(2)->notNull()->comment('状态'),
            'create_time'=>$this->integer(11)->notNull()->comment('创建时间'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
