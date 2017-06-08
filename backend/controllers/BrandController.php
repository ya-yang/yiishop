<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    //列表页面
    public function actionIndex()
    {
        //查询所有数据
        $brands=Brand::find()->all();
        //显示页面
        return $this->render('index',['brands'=>$brands]);
    }
    //添加
    public function actionAdd(){
        //实例化模型 并且绑定场景
        $model=new Brand(['scenario'=>Brand::SCENARIO_ADD]);
        //实例化组件
        $request=new Request();
        //判断是否是post请求方式
        if($request->post()){
            //接收数据
            $model->load($request->post());
            //实例化图片上传类
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            //验证数据有效性
            if($model->validate()){
                //保存图片
                $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                //赋值
                $model->logo=$fileName;
                //存入数据库
                $model->save(false);
                //提示信息
                \Yii::$app->session->setFlash('success','添加成功');
                //跳转到首页
                return $this->redirect(['brand/index']);
            }else{
                //没验证成功就打印错误信息
                var_dump($model->getErrors());
                exit;
            }
        }
        //不是post提交方式就显示视图
        return $this->render('add',['model'=>$model]);
    }

    //修改
    public function actionEdit($id){
        //通过id查询修改的数据
        $model=Brand::findOne(['id'=>$id]);
        //绑定场景
        $model->scenario=Brand::SCENARIO_EDIT;
        //实例化组件
        $request=new Request();
        //判断请求方式
        if($request->post()){
            //接收数据
            $model->load($request->post());
            //实例化图片上传类
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            //验证数据有效性
            if($model->validate()){
                //如果没上传图片的话就不保存
                if(!empty($model->imgFile)){
                    //保存图片
                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    //赋值
                    $model->logo=$fileName;
                }
                //存入数据库
                $model->save(false);
                //设置提示信息
                \Yii::$app->session->setFlash('success','修改成功');
                //跳转
                return $this->redirect(['brand/index']);
            }else{
                //数据验证失败答应错误信息
                var_dump($model->getErrors());
                exit;
            }
        }
        //不是post请求显示视图页面
        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDel($id){
        //通过id查询修改的数据
        $brand=Brand::findOne(['id'=>$id]);
        //删除该对象
        $brand->delete();
        //设置提示信息
        \Yii::$app->session->setFlash('danger','删除成功');
        //跳转
        return $this->redirect(['brand/index']);

    }

    //验证码配置
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,

            ],
        ];

    }

}
