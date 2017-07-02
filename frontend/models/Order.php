<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property integer $payment_id
 * @property string $payment_name
 * @property string $total
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    public static $statusoptions=[
      0=>'已取消',
      1=>'待付款',
      2=>'待发货',
      3=>'已发货',
      4=>'完成',
    ];
    public static $deliveries=[
        ['id'=>1,'delivery_name'=>'普通快递','delivery_price'=>'10','info'=>'每张订单不满499.00元,运费10.00元, '],
        ['id'=>2,'delivery_name'=>'顺丰快递','delivery_price'=>'40','info'=>'每张订单不满499.00元,运费40.00元, '],
        ['id'=>3,'delivery_name'=>'加急快递','delivery_price'=>'40','info'=>'每张订单不满499.00元,运费40.00元, '],
        ['id'=>4,'delivery_name'=>'平邮','delivery_price'=>'10','info'=>'每张订单不满499.00元,运费10.00元, '],
    ];
    public static $payments=[
        ['id'=>'1','payment_name'=>'货到付款','info'=>'	送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        ['id'=>'2','payment_name'=>'在线支付','info'=>'	即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
        ['id'=>'2','payment_name'=>'上门自提','info'=>'自提时付款，支持现金、POS刷卡、支票支付'],
        ['id'=>'2','payment_name'=>'邮局汇款','info'=>'	通过快钱平台收款 汇款后1-3个工作日到账'],
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'delivery_id', 'payment_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'total'], 'number'],
            [['name', 'province', 'city', 'area', 'delivery_name', 'payment_name', 'trade_no'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
            [['member_id', 'delivery_id', 'payment_id', 'status', 'create_time', 'total'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户id',
            'name' => '	收货人',
            'province' => '省',
            'city' => '市',
            'area' => '县',
            'address' => '详细地址',
            'tel' => '电话号码',
            'delivery_id' => '配送方式id',
            'delivery_name' => '配送方式名称',
            'delivery_price' => '配送方式价格',
            'payment_id' => '支付方式id',
            'payment_name' => '支付方式名称',
            'total' => '订单金额',
            'status' => '	订单状态（0已取消1待付款2待发货3待收货4完成）',
            'trade_no' => '第三方支付交易号',
            'create_time' => '创建时间',
        ];
    }
    public function getOrder_goods(){
        return $this->hasMany(OrderGoods::className(),['order_id'=>'id']);
    }
}
