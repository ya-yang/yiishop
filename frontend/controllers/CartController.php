<?php


namespace frontend\controllers;


use app\models\Cart;
use backend\models\Goods;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class CartController extends Controller
{
    public $layout='cart';
    public $enableCsrfValidation=false;
    //添加购物车
    public function actionAdd(){
        //接收goods_id和amount
        $goods_id=\Yii::$app->request->post('goods_id');
        $amount=\Yii::$app->request->post('amount');
        $goods = Goods::findOne(['id'=>$goods_id]);
        if($goods==null){
            throw new NotFoundHttpException('商品不存在');
        }
        //验证是游客登录
        if(\Yii::$app->user->isGuest){
            //获取response里面的cookie
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie == null){
                $cart=[];
            }else{
                $cart = unserialize($cookie->value);;
            }
            $cookiess=\Yii::$app->response->cookies;
            //如果不存在这个建名就创建
            if(key_exists($goods->id,$cart)){
                $cart[$goods_id] += $amount;
            }else{
                $cart[$goods_id] = $amount;
            }
            $cookie=new Cookie([
                'name'=>'cart',
                'value'=>serialize($cart)
            ]);
            $cookiess->add($cookie);
        }else{
            //登录状态
            $model=new Cart();
            $member_id=\Yii::$app->user->id;
            $cart = Cart::find()->where(['member_id' => $member_id])->andWhere(['goods_id'=>$goods_id])->one();
            if(\Yii::$app->request->isPost){
                if($cart){
                   $cart->amount  +=$amount;
                   $cart->save();
                }else{
                    $model->goods_id=$goods_id;
                    $model->amount=$amount;
                    $model->member_id=$member_id;
                    $model->save(false);
                }

            }
        }
        return $this->redirect(['/cart/cart']);

    }
    //购物车
    public function actionCart()
    {
        //验证是游客登录
        if (\Yii::$app->user->isGuest) {
            //获取response里面的cookie
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            if ($cookie == null) {
                $cart = [];
            } else {
                $cart = unserialize($cookie->value);
            }
            $models = [];
            foreach ($cart as $goods_id => $amount) {
                $goods = Goods::findOne(['id' => $goods_id])->attributes;
                $goods['amount'] = $amount;
                $models[] = $goods;

            }
        } else {
            //登录
            $member_id = \Yii::$app->user->id;
            $carts = Cart::findAll(['member_id' => $member_id]);
            $models = [];
            foreach ($carts as $cart) {
                $goods = Goods::findOne(['id' => $cart->goods_id])->attributes;
                $goods['amount'] = $cart->amount;
                $models[] = $goods;
            }
//            return $this->render('index',['models'=>$models]);
//        var_dump($models);die;

        }
        return $this->render('index', ['models' => $models]);
    }
    //更新购物车
    public function actionUpdate()
    {
        //接收goods_id和amount
        $goods_id = \Yii::$app->request->post('goods_id');
        $amount = \Yii::$app->request->post('amount');
        $goods=Goods::findOne(['id'=>$goods_id]);
        if($goods == null){
            throw new NotFoundHttpException('没有该商品');
        }
        //验证是游客登录
        if (\Yii::$app->user->isGuest) {

            //获取response里面的cookie
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            var_dump($cookie);
            if ($cookie == null) {
                $cart = [];
            } else {
                $cart = unserialize($cookie->value);;
            }
            $cookiess= \Yii::$app->response->cookies;

            if($amount){
                $cart[$goods->id]=$amount;

            }else{
                //删除
                if(key_exists($goods['id'],$cart)){
                    unset($cart[$goods_id]);
                }
            }

            $cookie1=new Cookie([
                'name'=>'cart',
                'value'=>serialize($cart)
            ]);
            $cookiess->add($cookie1);
            var_dump(unserialize($cookie->value));


        }else{
            $member_id=\Yii::$app->user->id;
            $cart = Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$member_id]);
            if($cart){
                if($amount){
                    $cart->amount=$amount;
                    $cart->save();
                }
                else{
                    $cart->delete();
                }
            }else{
                throw new NotFoundHttpException('没有此商品');
            }

        }
    }

}