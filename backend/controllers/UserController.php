<?php

namespace backend\controllers;

use backend\models\LoginForm;
use backend\models\User;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    //列表
    public function actionIndex()
    {
        $users=User::find()->where(['status'=>1])->all();
        return $this->render('index',['users'=>$users]);
    }
    //添加
    public function actionAdd(){
        $model=new User(['scenario'=>User::SCENARIO_ADD]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){

//                var_dump($model);die;
                $model->save(false);
                //注册成功后自动登录
                \Yii::$app->session->setFlash('success','注册成功');
                return $this->redirect(['user/index']);
            }else{
                var_dump($model->getErrors());

            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //修改
    public function actionEdit($id){
        $model=User::findOne(['id'=>$id]);
        if($model==null){
            throw new  NotFoundHttpException('账号不存在');
        }
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');

                return $this->redirect(['user/index']);
            }else{
                var_dump($model->getErrors());

            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDel($id){
        $model=User::findOne(['id'=>$id]);
        $model->status=0;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['user/index']);

    }
    //登录
    public function actionLogin(){
        $model=new LoginForm();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //跳转到检测页面
                return $this->redirect(['user/index']);
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('login',['model'=>$model]);

    }
    public function actionTest(){
        var_dump(\Yii::$app->user->identity);
    }
    //注销登录
    public function actionLogout(){
        \Yii::$app->user->logout();

        return $this->redirect(['user/login']);
    }
    //设置
    public function actions(){
        return [
            //验证码
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,

            ],
        ];
    }
}
