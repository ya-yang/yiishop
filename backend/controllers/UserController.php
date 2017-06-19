<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\LoginForm;
use backend\models\PasswdForm;
use backend\models\User;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    //添加页面权限
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','add','edit','del','edit-passwd','edit-role'],
            ],

        ];
    }
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
                if($model->save(false)){
                    //添加用户角色
                    $authManager=\Yii::$app->authManager;
                    foreach($model->roles as $roleName ){
                        $role=$authManager->getRole($roleName);
                        $authManager->assign($role,$model->id);

                    }
                }
                //注册成功后自动登录
                if(\Yii::$app->user->login($model)){
                    $model->last_login_time=time();
                    $model->last_login_ip=\Yii::$app->getRequest()->getUserIP();
                    $model->save(false);
                }
                \Yii::$app->session->setFlash('success','注册成功');
                \Yii::$app->user->login($model);
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
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['user/index']);
            }else{
                var_dump($model->getErrors());

            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //修改密码
    public function actionEditPasswd(){
        $model=new PasswdForm();
        $request=New Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $user=User::findOne(['id'=> \Yii::$app->user->identity->getId()]);
                $user->password_hash= \Yii::$app->security->generatePasswordHash($model->passwd);
                $user->save(false);
                \Yii::$app->session->setFlash('success','修改密码成功,请重新登录');
                return $this->redirect('logout');
            }
        }
        return $this->render('edit-passwd',['model'=>$model]);

    }

    //修改权限
    public function actionEditRole($id){
        $model=new User();
        //加载角色数据
        $model->loadData($id);
        //判断账号是否存在
        if($model==null){
            throw new  NotFoundHttpException('账号不存在');
        }
        //接收post提交的数据
        if($model->load(\Yii::$app->request->post())){
            //更新角色
            $model->updateRole($id);
            \Yii::$app->session->setFlash('success','修改角色成功');
            return $this->redirect(['user/index']);
        }
        return $this->render('edit-role',['model'=>$model]);
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

    //测试
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
