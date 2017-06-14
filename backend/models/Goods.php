<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property string $intro
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property string $sort
 * @property string $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    public static $saleoptions = [1=>'上架',0=>'下架'];
    public static $statusoptions = [1=>'正常',0=>'删除'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // 'sn','intro',
            [['name',  'logo', 'goods_category_id', 'brand_id', 'stock'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'sn'], 'string', 'max' => 20],
            [['logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '货号',
            'logo' => 'LOGO图片',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '添加时间',
        ];
    }
    public static function getBrand(){
        return ArrayHelper::map(Brand::find()->where(['status'=>1])->all(),'id','name');
    }
    public function getGoods_intro(){
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
    }
    public function getGoods_ablum(){
        return $this->hasOne(GoodsAlbum::className(),['goods_id'=>'id']);
    }
    public function beforeSave($insert){
        if($insert){
            $this->create_time=time();
        }
        return parent::beforeSave($insert);

    }
}
