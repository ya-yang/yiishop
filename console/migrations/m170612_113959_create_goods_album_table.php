<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_album`.
 */
class m170612_113959_create_goods_album_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_album', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->comment('商品id'),
            'img_path'=>$this->integer()->comment('图片路径'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_album');
    }
}
