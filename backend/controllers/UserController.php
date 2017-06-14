<?php

namespace backend\controllers;

use backend\models\LoginForm;
use backend\models\User;
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
        $model=new User();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //密码加密
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password_hash);
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
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
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //密码加密
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password_hash);
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
        return $this->render('login',['model'=>$model]);

    }
}
