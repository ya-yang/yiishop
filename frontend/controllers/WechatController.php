<?php


namespace frontend\controllers;


use yii\web\Controller;

class WechatController extends Controller
{
    //微信开发依赖插件 easyWechat
    //关闭csrf验证
    public $enableCsrfValidation=false;
    //这个url地址就是用于接收微信服务器发送的请求的
    public function actionIndex(){

    }

}