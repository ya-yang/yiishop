<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170609_083040_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree'=> $this->integer()->notNull()->comment('树id'),
            'lft'=>$this->integer()->notNull()->comment('左值'),
            'rgt'=>$this->integer()->notNull()->comment('右值'),
            'depth'=>$this->integer()->notNull()->comment('层级'),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'parent_id'=>$this->integer()->notNull()->comment('上级分类id'),
            'intro'=>$this->text()->notNull()->comment('简介'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
