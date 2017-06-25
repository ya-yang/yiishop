<?php


namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\data\Pagination;
use yii\web\Controller;

class IndexController extends Controller
{
    public $layout='index';
    //首页
    public function actionIndex(){
        $categories=GoodsCategory::findAll(['parent_id'=>0]);
        return $this->render('index',['categories'=>$categories]);
    }
    //列表页
    public function actionList($id){
        $this->layout='list';
//        $cate_ids=[];
//        $goods=[];
//        //找到此分类
//        $parent=GoodsCategory::findOne(['id'=>$id]);
//        //找到它的所有子分类（同一棵树,左值大于当前左值，右值小于当前右值）
//        $son=GoodsCategory::find()->where('tree='.$parent->tree)->andWhere('lft>'.$parent->lft)->andWhere('rgt<'.$parent->rgt)->all();
//        //循环所有的id
//        foreach($son as $cate){
//
//            $cate_ids[]=$cate->id;
//        }
//        foreach($cate_ids as $category){
//            $goods[]=Goods::find()->where(['goods_category_id'=>$category])->all();
//        }
//        var_dump($goods);die;
//        $count=0;
//        foreach ($goods as $good){
//            if($good){
//                foreach($good as $goo){
//                    $count++;
//                }
//            }
//        }

        $query=Goods::find()->where('goods_category_id='.$id);
        $total=$query->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>8,
        ]);
//        $lists=Goods::findAll(['goods_category_id'=>$id]);
        $lists=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('list',['lists'=>$lists,'page'=>$page]);
    }
    //详情页
    public function actionGoods($id){
        $this->layout='list';
        $goods=Goods::findOne(['id'=>$id]);
        return $this->render('goods',['goods'=>$goods]);
    }

}