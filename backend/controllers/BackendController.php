<?php


namespace backend\controllers;


use backend\components\RbacFilter;
use yii\base\Controller;

class BackendController extends Controller
{
    //添加权限
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className()
            ],
        ];
    }

}