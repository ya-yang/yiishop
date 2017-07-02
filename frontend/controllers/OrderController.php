<?php


namespace frontend\controllers;


use frontend\models\Cart;
use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;

class OrderController extends Controller
{
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    [
                        'allow'=>true,
                        'roles'=>['@'],
                    ]
                ],
            ],
        ];
    }

    public $layout='cart';
    public $enableCsrfValidation=false;
    public function actionIndex(){
        $order=new Order();
        if(\Yii::$app->request->isPost){
            if($order->load(\Yii::$app->request->post())){
                $order->member_id=\Yii::$app->user->id;
                $address_id= \Yii::$app->request->post('address_id');
                $address = Address::findOne(['id'=>$address_id,'member_id'=>\Yii::$app->user->id]);
                $order->name=$address->name;
                $order->province=$address->province;
                $order->city=$address->city;
                $order->area=$address->area;
                $order->address=$address->detail;
                $order->tel=$address->tel;
                if($order->validate()){
                    $order->delivery_id=Order::$deliveries[$order->delivery_id-1]['id'];
                    $order->delivery_name=Order::$deliveries[$order->delivery_id-1]['delivery_name'];
                    $order->delivery_price=Order::$deliveries[$order->delivery_id-1]['delivery_price'];
                    $order->payment_id=Order::$payments[$order->payment_id-1]['id'];
                    $order->payment_name=Order::$payments[$order->payment_id-1]['payment_name'];
                }
                $order->total=\Yii::$app->request->post('total');
                $order->create_time=time();
                $order->status = 1;
                //事务处理
                $db=\Yii::$app->db;
                $transaction=$db->beginTransaction();
                try{
                    $order->save(false);
                    $carts=Cart::findAll(['member_id'=>\Yii::$app->user->id]);

                    foreach ($carts as $cart){
                        $order_goods= new OrderGoods();
                        $goods=Goods::findOne(['id'=>$cart->goods_id]);
                        if($goods == null){
                            throw new Exception('商品'.$goods->name.'不存在');
                        }
                        $order_goods->order_id=$order->id;
                        $order_goods->goods_id=$cart->goods_id;
                        $order_goods->goods_name=$goods->name;
                        $order_goods->logo=$goods->logo;
                        $order_goods->price=$goods->shop_price;
                        $order_goods->amount=$cart->amount;
                        $order_goods->total=($goods->shop_price)*($cart->amount);
                        if($cart->amount > $goods->stock){
                            throw new Exception('商品'.$goods->name.'库存不足');
                        }
                        //减少商品表中库存
                        $goods->stock=$goods->stock - $cart->amount;
                        $goods->save();
                        $order_goods->save(false);
                        $cart->delete();
//
                    }

                    //提交事务
                    $transaction->commit();
                    return $this->redirect(['success']);
                }catch (Exception $e){
                    //事务回滚
                    $transaction->rollBack();
                    //打印错误有信息
                    var_dump($e->getMessage());die;
                    }
                }

            }
        $member_id=\Yii::$app->user->id;
        $carts=Cart::findAll(['member_id'=>$member_id]);

        $models=[];
        foreach($carts as $cart){
            $goods=Goods::find()->where(['id'=>$cart->goods_id])->asArray()->one();
            $goods['amount']=$cart->amount;
            $models[]=$goods;
        }

        $address=Address::findAll(['member_id'=>$member_id]);
        return $this->render('index',['address'=>$address,'carts'=>$carts,'models'=>$models]);
    }
    public function actionSuccess(){
        return $this->render('success');
    }
    public function actionDetail(){
        $this->layout='address';
        $orders=Order::findAll(['member_id'=>\Yii::$app->user->id]);
        return $this->render('detail',['orders'=>$orders]);
    }
    //清理未超时未处理的订单（1小时）
//    public function actionClean(){
//        set_time_limit(0);
//        while (1){
//            $models=Order::find()->where(['status'=>1])->andWhere(['<','create_time',time()-10])->all();
//            foreach($models as $model){
//                $model->status = 0;
//                $model->save();
//                //返还库存
//                foreach ($model->order_goods as $order_goods){
////                   $goods=Goods::updateAllCounters(['id'=>$order_goods->goods_id]);
//                    $goods=Goods::findOne(['id'=>$order_goods->goods_id]);
//                    $goods->stock +=$order_goods->amount;
//                    $goods->save();
//                }
//            echo '111'.'<br/>';
//            }
//
//            sleep(1);
//        }
//    }
    public function actionGoods($id){
        $this->layout='address';
        $orders=Order::findOne(['member_id'=>\Yii::$app->user->id,'id'=>$id]);
        return $this->render('goods',['order_goods'=>$orders->order_goods]);
    }
    public function actionDel($id){
        $order=Order::findOne(['id'=>$id]);
        $order->delete();
        return $this->redirect(['detail']);
    }
    public function actionEdit($id){
        $order=Order::findOne(['id'=>$id]);
        $order->status=4;
        $order->save();
        return $this->redirect(['detail']);
    }

}