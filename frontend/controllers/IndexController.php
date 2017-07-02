<?php


namespace frontend\controllers;


use backend\components\SphinxClient;
use backend\models\Goods;
use backend\models\GoodsCategory;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
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
    public function actionList(){
        $this->layout='list';
        $request=\Yii::$app->request;
        if($keywords = \Yii::$app->request->get('keywords')) {
            $query=Goods::find();
            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode (SPH_MATCH_ALL);
            $cl->SetLimits(0, 1000);
            $res = $cl->Query($keywords, 'goods');
            if(!isset($res['matches'])){
                $query->where(['id'=>0]);

            }else{
                $ids = ArrayHelper::map($res['matches'],'id','id');
                $query->where(['in','id',$ids]);
            }
            $total=$query->count();
            $page=new Pagination([
                'totalCount'=>$total,
                'defaultPageSize'=>8,
            ]);
            $lists=$query->offset($page->offset)->limit($page->limit)->all();
            $keywords = array_keys($res['words']);
            $options = array(
                'before_match' => '<span style="color:red;">',
                'after_match' => '</span>',
                'chunk_separator' => '...',
                'limit' => 80, //如果内容超过80个字符，就使用...隐藏多余的的内容
            );
            //关键字高亮
            foreach ($lists as $index => $item) {
                $name = $cl->BuildExcerpts([$item->name], 'goods', implode(',', $keywords), $options); //使用的索引不能写*，关键字可以使用空格、逗号等符号做分隔，放心，sphinx很智能，会给你拆分的
                $lists[$index]->name = $name[0];
            }
        }else{
            $cid=$request->get('id');
            $query=Goods::find();
            $parent=GoodsCategory::findOne(['id'=>$cid]);
            if($parent == null ){
                return ['status'=>-1,'msg'=>'没有此分类'];
            }
            $cates=GoodsCategory::find()->where(['tree'=>$parent->tree])->andWhere('lft>'.$parent->lft)->andWhere('rgt<'.$parent->rgt)->all();
            $cids=[];
            foreach ($cates as $cate){
                $cids[]=$cate->id;
            }
            $query = $query->andWhere(['in','goods_category_id',$cids]);
            $total=$query->count();
            $page=new Pagination([
                'totalCount'=>$total,
                'defaultPageSize'=>8,
            ]);
            $lists=$query->offset($page->offset)->limit($page->limit)->all();
        }
        return $this->render('list',['lists'=>$lists,'page'=>$page]);
    }
    //详情页
    public function actionGoods($id){
        $this->layout='list';
        $goods=Goods::findOne(['id'=>$id]);
        return $this->render('goods',['goods'=>$goods]);
    }

}