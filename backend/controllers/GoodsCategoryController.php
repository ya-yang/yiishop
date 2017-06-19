<?php

namespace backend\controllers;


use backend\models\GoodsCategory;
use yii\helpers\Json;
use yii\web\Request;

class GoodsCategoryController extends BackendController
{
    //列表
    public function actionIndex()
    {
        $models=GoodsCategory::find()->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC])->all();
        return $this->render('index',['models'=>$models]);
    }

    //添加
    public function actionAdd(){
        $model=new GoodsCategory();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id){
                    //创建非一级分类
                    $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent);

                }else{
                    //创建一级分类
                    $model->makeRoot();
                }

                //跳转
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods-category/index']);

            }else{
                var_dump($model->getErrors());
            }
        }
        //找到所有分类
        $categories=GoodsCategory::find()->asArray()->all();
        //将顶级分类添加到分类中
        $categories[]=['id'=>0,'name'=>'顶级分类','parent_id'=>'0'];
        //转换成json数组
        $categories=Json::encode($categories);
        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }

    //修改
    public function actionEdit($id){
        $model=GoodsCategory::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id){
                    //创建非一级分类
                    $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent);

                }else{
                    if($model->getOldAttribute('parent_id')==0){
                        $model->save();
                    }else{
                        //创建一级分类
                        $model->makeRoot();
                    }
                }

                //跳转
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['goods-category/index']);

            }else{
                var_dump($model->getErrors());
            }
        }
        $categories=GoodsCategory::find()->asArray()->all();
        //设置顶级分类
        $categories[]=['id'=>0,'name'=>'顶级分类','parent_id'=>'0'];
        $categories=Json::encode($categories);
        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }

    //测试
    public function actionTest(){
//        $jydq= new GoodsCategory();
//        $jydq->name='生活用品';
//        $jydq->parent_id=0;
//        $jydq->makeRoot();
//        var_dump($jydq);
//        $parent=GoodsCategory::findOne(['id'=>1]);
//        $xjd= new GoodsCategory();
//        $xjd->name='小家电';
//        $xjd->parent_id=$parent->id;
//        $xjd->prependTo($parent);
//        echo '操作成功';


    }

    //测试真实数据
    public function actionZtree(){
        $categories=GoodsCategory::find()->all();

        return $this->renderPartial('ztree',['categories'=>$categories]);
    }


}
