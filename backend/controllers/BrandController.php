<?php

namespace backend\controllers;

use backend\models\Brand;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAdd(){
        $brand=new Brand();
        return $this->render('add',['brand'=>$brand]);
    }

}
