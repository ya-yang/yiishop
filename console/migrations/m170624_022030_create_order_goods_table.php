<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_goods`.
 */
class m170624_022030_create_order_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_goods', [
            'id' => $this->primaryKey(),
            'order_id'=>$this->integer()->comment('订单id'),
            'goods_id'=>$this->integer()->comment('商品id'),
            'goods_name'=>$this->string(20)->comment('商品名称'),
            'logo'=>$this->string(20)->comment('图片'),
            'price'=>$this->decimal(10,2)->comment('价格'),
            'amount'=>$this->integer()->comment('数量'),
            'total'=>$this->decimal(10,2)->comment('小计'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_goods');
    }
}
