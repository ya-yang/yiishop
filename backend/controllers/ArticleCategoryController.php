<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\ArticleCategory;
use yii\web\Request;

class ArticleCategoryController extends BackendController
{
//添加页面权限
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','add','edit','delete'],
            ],

        ];
    }
    //列表
    public function actionIndex()
    {
        $articlecategorys=ArticleCategory::find()->where('status>-1')->all();
//        $articlecategorys=ArticleCategory::find()->all();
        return $this->render('index',['articlecategorys'=>$articlecategorys]);
    }
    //添加
    public function actionAdd(){
        $model=new ArticleCategory();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save(false);
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article-category/index']);
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('add',['model'=>$model]);

    }
    //修改
    public function actionEdit($id){
        $model=ArticleCategory::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save(false);
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article-category/index']);
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('add',['model'=>$model]);
    }
//    //物理删除
//    public function actionDel($id){
//        $model=ArticleCategory::findOne(['id'=>$id]);
//        $model->delete();
//        \Yii::$app->session->setFlash('danger','删除成功');
//        return $this->redirect(['article-category/index']);
//
//
//    }
    //逻辑隐藏
    public function actionHidden($id){
        $model=ArticleCategory::findOne(['id'=>$id]);
        $model->status=0;
        $model->save(false);
        \Yii::$app->session->setFlash('danger','隐藏成功');
        return $this->redirect(['article-category/index']);

    }
    //逻辑删除
    public function actionDelete($id){
        $model=ArticleCategory::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save(false);
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['article-category/index']);

    }
    //验证码配置
    public function actions(){
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
