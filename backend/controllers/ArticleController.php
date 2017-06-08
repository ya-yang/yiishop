<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $articles=Article::find()->all();
        return $this->render('index',['articles'=>$articles]);
    }
    public function actionAdd(){
        $model=new Article();
        $articledetail=new ArticleDetail();
        $articlecategorys=ArticleCategory::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $articledetail->load($request->post());
            if($model->validate()){
                $model->save(false);
                $articledetail->save(false);
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('add',['model'=>$model,'articlecategorys'=>$articlecategorys,'articledetail'=>$articledetail]);
    }
    //修改
    public function actionEdit($id){
        $model=Article::findOne(['id'=>$id]);
        $articlecategorys=ArticleCategory::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save(false);
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('add',['model'=>$model,'articlecategorys'=>$articlecategorys]);

    }
    //删除
    public function actionDel($id){
        $model=Article::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['article/index']);

    }
    public function actionDetail($id){
        $model=Article::findOne(['id'=>$id]);
    }

}
