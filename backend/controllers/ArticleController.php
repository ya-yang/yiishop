<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    //列表
    public function actionIndex()
    {
        $query=Article::find()->where('status>-1');
        $total=$query->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>3,
        ]);
        $articles=$query->offset($page->offset)->limit($page->limit)->all();
//        $articles=Article::find()->where('status>-1')->all();
//        $articles=Article::find()->all();
        return $this->render('index',['articles'=>$articles,'page'=>$page]);
    }
    //添加
    public function actionAdd(){
        $model=new Article();
        $articledetail=new ArticleDetail();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $articledetail->load($request->post());
            if($model->validate() && $articledetail->validate()){
                $model->save(false);
                $articledetail->article_id=$model->id;
                $articledetail->save(false);
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }

        return $this->render('add',['model'=>$model,'articledetail'=>$articledetail]);
    }
    //修改
    public function actionEdit($id){
        $model=Article::findOne(['id'=>$id]);
        $articledetail=ArticleDetail::findOne(['article_id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $articledetail->load($request->post());
            if($model->validate()&&$articledetail->validate()){
                $model->save(false);
                $articledetail->save(false);
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('add',['model'=>$model,'articledetail'=>$articledetail]);
    }
    //删除(物理删除)
//    public function actionDel($id){
//        $model=Article::findOne(['id'=>$id]);
//        $model->delete();
//        \Yii::$app->session->setFlash('danger','删除成功');
//        return $this->redirect(['article/index']);
//
//    }
    //逻辑隐藏
    public function actionHidden($id){
        $model=Article::findOne(['id'=>$id]);
        $model->status=0;
        $model->save();
        \Yii::$app->session->setFlash('danger','隐藏成功');
        return $this->redirect(['article/index']);

    }
    //逻辑删除
    public function actionDelete($id){
        $model=Article::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['article/index']);

    }
    public function actionDetail($id){
        $model=Article::findOne(['id'=>$id]);
        return $this->render('detail',['model'=>$model]);

    }

}
