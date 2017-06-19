<?php


namespace backend\components;


use yii\base\ActionFilter;
use yii\web\HttpException;

class RbacFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        $user= \Yii::$app->user;
        if(!$user->can($action->uniqueId)){
            if($user->isGuest){
                //跳转到登录页面
               return  $action->controller->redirect($user->loginUrl);
            }
            //抛出异常
            throw new HttpException(403,'您没有该权限');
            return false;
        }
        return parent::beforeAction($action);
    }


}