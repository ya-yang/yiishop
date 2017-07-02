<?php


namespace frontend\controllers;


use yii\web\Controller;

class GameController extends Controller
{
    public $enableCsrfValidation=false;
    public $layout=false;
    public function actionNew($start=0,$end=9,$length=4){
        $connt=0;
        $temp=array();
        while($connt<$length){
            $temp[]=mt_rand($start,$end);
            $data=array_unique($temp);
            $connt=count($data);
        }
        sort($data);
//        $num =implode('',$data);
//        echo $num;die;
        \Yii::$app->cache->delete('num');
        \Yii::$app->cache->add('num',$data);
//        var_dump(\Yii::$app->cache->get('num'));die;
        return $this->redirect(['index']);
    }
//    public static function get_rand_number($start=0,$end=9,$length=4){
//        $connt=0;
//        $temp=array();
//        while($connt<$length){
//            $temp[]=mt_rand($start,$end);
//            $data=array_unique($temp);
//            $connt=count($data);
//        }
//        sort($data);
//        return $data;
//    }
    public function actionIndex(){
        $num=\Yii::$app->cache->get('num');
        $num1=\Yii::$app->request->post('num1');
        $num2=\Yii::$app->request->post('num2');
        $num3=\Yii::$app->request->post('num3');
        $num4=\Yii::$app->request->post('num4');
        $num13=$num1.$num2.$num3.$num4;
        $num12=$num1.','.$num2.','.$num3.','.$num4;
        $num11=explode(",",$num12);
        $A = 0;
        $B = 0;
        for($i=0;$i<4;$i++) {
            for($j=0;$j<4;$j++) {
                if($i==$j && $num[$i]==$num11[$j]) {
                    $A++;
                    break;
                } else if ($i!=$j && $num[$i]==$num11[$j]) {
                    $B++;
                    break;
                }
            }
        }
        $result = $A.'A'.$B.'B';
        return $this->render('index',['num13'=>$num13,'result'=>$result]);
    }

}