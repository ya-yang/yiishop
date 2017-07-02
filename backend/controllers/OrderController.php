<?php


namespace backend\controllers;


use frontend\models\Order;
use yii\web\Controller;

class OrderController extends Controller
{
    public function actionIndex(){
        $orders=Order::find()->all();
        return $this->render('index',['orders'=>$orders]);
    }
    public function actionUpdate($id){
        $order=Order::findOne(['id'=>$id]);
        $order->status= 3;
        $order->save();
        return $this->redirect(['index']);

    }

}