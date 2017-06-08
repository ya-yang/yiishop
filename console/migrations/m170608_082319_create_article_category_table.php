<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170608_082319_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'intro'=>$this->text()->notNull()->comment('简介'),
            'sort'=>$this->integer(11)->notNull()->comment('排序'),
            'status'=>$this->integer(2)->notNull()->comment('状态'),
            'is_help'=>$this->integer(1)->notNull()->comment('类型'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
