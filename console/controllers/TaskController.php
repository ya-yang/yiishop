<?php
namespace console\controllers;


use backend\models\Goods;
use frontend\models\Order;
use yii\console\Controller;

class TaskController extends Controller
{
    //清理未超时未处理的订单（1小时）
    public function actionClean(){
        set_time_limit(0);
        while (1){
            $models=Order::find()->where(['status'=>1])->andWhere(['<','create_time',time()-3600])->all();
            foreach($models as $model){
                $model->status = 0;
                $model->save();
                //返还库存
                foreach ($model->order_goods as $order_goods){
//                   $goods=Goods::updateAllCounters(['id'=>$order_goods->goods_id]);
                    $goods=Goods::findOne(['id'=>$order_goods->goods_id]);
                    $goods->stock +=$order_goods->amount;
                    $goods->save();
                }


            }
            sleep(10);
        }
    }


}