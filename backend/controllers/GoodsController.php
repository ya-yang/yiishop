<?php

namespace backend\controllers;



use backend\components\RbacFilter;
use backend\components\SphinxClient;
use backend\models\Goods;
use backend\models\GoodsAlbum;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsIntro;
use backend\models\GoodsSearchForm;
use kucha\ueditor\UEditor;
use xj\uploadify\UploadAction;
use yii\base\Controller;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends BackendController
{
    //添加页面权限
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','add','edit','del'],
            ],

        ];
    }

    //列表
    public function actionIndex()
    {
        $search=new GoodsSearchForm();
        $query=Goods::find()->where(['status'=>1]);
        if($keywords = \Yii::$app->request->get('keywords')){
            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode ( SPH_MATCH_ALL);
            $cl->SetLimits(0, 1000);
            $res = $cl->Query($keywords, 'goods');
            if(!isset($res['matches'])){
                $query->andWhere(['id'=>0]);
            }else{
                $ids = ArrayHelper::map($res['matches'],'id','id');
                $query->andWhere(['in','id',$ids]);
            }
        }
        $search->search($query);
        $total=$query->count();
        $page = new Pagination([
            'totalCount'=>$total,
            'pageSize'=>5
        ]);

        $models = $query->limit($page->limit)->offset($page->offset)->all();
        return $this->render('index',['models'=>$models,'page'=>$page,'search'=>$search]);
    }
    //添加
    public function actionAdd()
    {
        $model = new Goods();
        $intro=new GoodsIntro();
        $request = new Request();
        if ($request->isPost) {
            $model->load($request->post());
            $intro->load($request->post());
            if ($model->validate() && $intro->validate()) {
                //生成sn
                //先根据日期查询daycount表
                $goodscount=GoodsDayCount::findOne(['day'=>date('Y-m-d')]);
                if($goodscount == null){
                    $goodscount=new GoodsDayCount();
                    $goodscount->day=date('Y-m-d');
                    $goodscount->count = 0;
                    $goodscount->save();
                }
                //%d - 包含正负号的十进制数（负数、0、正数）
//                var_dump($goodscount->count);die;
                $goods_sn=date('Ymd').sprintf("%05d",$goodscount->count+1);
                $model->sn=$goods_sn;
                //保存goods表
                $model->save();
                //保存intro表
                $intro->goods_id=$model->id;
                $intro->save();
                //保存daycount表
                $goodscount->day=date('Y-m-d');
                $goodscount->count=($goodscount->count)+1;
                $goodscount->save();
                \Yii::$app->session->setFlash('success','添加商品成功,请添加相册');
                return $this->redirect(['/goods-album/album','id'=>$model->id]);
            }else{
                var_dump($model->getErrors());
                exit();
            }
        }
        $categories = GoodsCategory::find()->all();
        $categories = Json::encode($categories);
        return $this->render('add', ['model' => $model, 'categories' => $categories,'intro'=>$intro]);
    }
    //修改
    public function actionEdit($id){
        $model=Goods::findOne(['id'=>$id]);
        $intro=GoodsIntro::findOne(['goods_id'=>$id]);
        $request = new Request();
        if ($request->isPost) {
            $model->load($request->post());
            $intro->load($request->post());
            if ($model->validate() && $intro->validate()) {

                //保存goods表
                $model->save();
                //保存intro表
                $intro->goods_id=$model->id;
                $intro->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['goods/index']);
            }else{
                var_dump($model->getErrors());
                exit();
            }
        }
        $categories = GoodsCategory::find()->all();
        $categories = Json::encode($categories);
        return $this->render('add', ['model' => $model, 'categories' => $categories,'intro'=>$intro]);

    }
    //删除
    public function actionDel($id){
        $model=Goods::findOne(['id'=>$id]);

        $model->status = 0;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['goods/index']);

    }

    //配置
    public function actions()
    {
        return [
            //图片上传
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                //不分目录上传
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filename = sha1_file($action->uploadfile->tempName);
//                    return "{$filename}.{$fileext}";
//                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png', 'jpeg'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {
                },
                'beforeSave' => function (UploadAction $action) {
                },
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    $action->output['Path'] = $action->getSavePath();
                },
            ],
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://admin.yiishop.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];

    }
    //测试
    public function actionTest(){
        $model = new Goods();
//        $txt = sprintf("%05d",11);
//        echo $txt;
//        die();
        return $this->render('test',['model'=>$model]);
    }
    //sphinx测试（分词搜索）
    public function actionSphinxTest(){
        $cl = new SphinxClient();
        $cl->SetServer ( '127.0.0.1', 9312);
//$cl->SetServer ( '10.6.0.6', 9312);
//$cl->SetServer ( '10.6.0.22', 9312);
//$cl->SetServer ( '10.8.8.2', 9312);
        $cl->SetConnectTimeout ( 10 );
        $cl->SetArrayResult ( true );
// $cl->SetMatchMode ( SPH_MATCH_ANY);SPH_MATCH_EXTENDED2
        $cl->SetMatchMode ( SPH_MATCH_ALL);
        $cl->SetLimits(0, 1000);
        $info = '海信手机';
        $res = $cl->Query($info, 'goods');//shopstore_search
//print_r($cl);
        var_dump($res);

    }

}
