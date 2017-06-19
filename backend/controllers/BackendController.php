<?php


namespace backend\controllers;


use backend\components\RbacFilter;

class BackendController extends \yii\web\Controller
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