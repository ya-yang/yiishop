<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Member;

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
                return $this->redirect('index.html');

        }
        return  $this->render('register',['model'=>$model]);
    }
    //登录
    public function actionLogin(){
        $model=new LoginForm();
        if($model->load(\Yii::$app->request->post())&&$model->validate()){
            return $this->redirect('test.html');
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


}
