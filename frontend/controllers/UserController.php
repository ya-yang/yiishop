<?php

namespace frontend\controllers;

use app\models\Cart;
use frontend\models\LoginForm;
use frontend\models\Member;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
use yii\helpers\ArrayHelper;

class UserController extends \yii\web\Controller
{
    public $layout='login';
    public function actionIndex()
    {
        return $this->render('index');
    }
    //注册
    public function actionRegister(){
        $model=new Member();
        if($model->load(\Yii::$app->request->post())&&$model->validate()){
                $model->save(false);
                return $this->redirect('login.html');

        }
        return  $this->render('register',['model'=>$model]);
    }
    //验证短信
    public function actionSendSms(){
        $tel=\Yii::$app->request->post('tel');
        //验证电话号码
        if(!preg_match('/^1[3,4,5,7,8]\d{9}$/',$tel)){
            echo '电话号码不正确';
            exit;
        }
        //发送短信
        $mscode= rand(100000, 999999);
//        $res = \Yii::$app->sms->setNum($tel)->setParm(['name'=>\Yii::$app->request->post('username'),'mscode' => $mscode,])->send();
        $res=1;
        if($res){
            //存入缓存
            \Yii::$app->cache->set('tel_'.$tel,$mscode,5*60);
            echo 'success'.$mscode;

        }else{
            echo '发送失败';
        }
    }
    //登录
    public function actionLogin(){
        $model=new LoginForm();
        if($model->load(\Yii::$app->request->post())&&$model->validate()){
            $model=new Cart();
            $member_id=\Yii::$app->user->id;
            $cart = ArrayHelper::map(Cart::findAll(['member_id' => $member_id]),'goods_id','amount');
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie == null){
                $cart_cookie=[];
            }else{
                $cart_cookie = unserialize($cookie->value);;
            }
            foreach ($cart_cookie as $goodsid_cookie => $amount_cookie) {
                //数据库存在这条记录
                if ($cart && key_exists($goodsid_cookie,$cart)) {
                    $cart_one=Cart::findOne(['member_id' => $member_id,'goods_id'=>$goodsid_cookie]);
                    $cart_one->amount += $amount_cookie;
                    $cart_one->save(false);
                } else {
                    //将缓存中的数据加入数据库
                    $model->goods_id = $goodsid_cookie;
                    $model->amount = $amount_cookie;
                    $model->member_id = $member_id;
                    $model->save(false);
                }
            }
            //清除缓存;
            $cookiess=\Yii::$app->response->cookies;
            $cookiess->remove('cart');
            return $this->redirect(['/index/index']);
        }

        return  $this->render('login',['model'=>$model]);
    }
    //测试
    public function actionTest(){
        var_dump(\Yii::$app->user->identity);
    }
    //注销
    public function actionLogout(){
        \Yii::$app->user->logout();
        return  $this->redirect('login.html');
    }
    //测试短信
    public function actionSms(){

        $mscode= rand(100000, 999999);
        $res = \Yii::$app->sms->setNum(18483698448)->setParm(['name'=>'用户','mscode' => $mscode,])->send();
        if($res){
            echo '发送成功；验证码是'.$mscode;

        }else{
            echo '发送失败';
        }
    }
    //发送邮件

}
