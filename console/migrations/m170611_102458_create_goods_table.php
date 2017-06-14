<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170611_102458_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(20)->notNull()->comment('商品名称'),
            'sn'=>$this->string(20)->notNull()->comment('货号'),
            'logo'=>$this->string(255)->notNull()->comment('LOGO图片'),
            'goods_category_id'=>$this->integer()->notNull()->comment('商品分类id'),
            'brand_id'=>$this->integer()->notNull()->comment('品牌分类'),
            'market_price'=>$this->decimal(10,2)->comment('市场价格'),
            'shop_price'=>$this->decimal(10,2)->comment('商品价格'),
            'stock'=>$this->integer()->notNull()->comment('库存'),
            'is_on_sale'=> $this->smallInteger()->notNull()->unsigned()->defaultValue(1)->comment('是否在售（1在售  0下架）'),
            'status'=> $this->smallInteger()->notNull()->defaultValue(1)->comment('1正常 0回收站'),
            'sort'=> $this->integer()->unsigned()->comment('排序'),
            'create_time'=> $this->integer()->unsigned()->comment('创建时间')
        ]);

        $this->createTable('goods_intro', [
            'goods_id'=> $this->primaryKey(),
            'content'=> $this->text()->comment('商品详情'),
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
