<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_album".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $img_path
 */
class GoodsAlbum extends \yii\db\ActiveRecord
{
    public $imgFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
            ['imgFile','file','extensions'=>['jpg','jpeg','gif','png']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'img_path' => '图片路径',
        ];
    }
}
