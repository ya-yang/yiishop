<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\Brand;
use xj\uploadify\UploadAction;
use yii\base\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;

class BrandController extends BackendController
{
    //添加页面权限
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','add','edit','hidde','delete'],
            ],

        ];
    }
    //列表页面
    public function actionIndex()
    {
        //查询所有数据
        $brands=Brand::find()->where('status>-1')->all();
//        $brands=Brand::find()->all();
        //显示页面
        return $this->render('index',['brands'=>$brands]);
    }
    //添加
    public function actionAdd(){
        //实例化模型 并且绑定场景
//        $model=new Brand(['scenario'=>Brand::SCENARIO_ADD]);
        $model=new Brand();
        //实例化组件
        $request=new Request();
        //判断是否是post请求方式
        if($request->post()){
            //接收数据
            $model->load($request->post());
            //实例化图片上传类
//            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            //验证数据有效性
            if($model->validate()){
                //保存图片
//                $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
//                $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                //赋值
//                $model->logo=$fileName;
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
        if($model==null){
            throw new NotFoundHttpException('品牌不存在');
        }
        //实例化组件
        $request=new Request();
        //判断请求方式
        if($request->post()){
            //接收数据
            $model->load($request->post());
            //实例化图片上传类
//            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            //验证数据有效性
            if($model->validate()){
                //如果没上传图片的话就不保存
//                if(!empty($model->imgFile)){
//                    //保存图片
//                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
//                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
//                    //赋值
//                    $model->logo=$fileName;
//                }
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
    //物理删除
//    public function actionDel($id){
//        //通过id查询修改的数据
//        $brand=Brand::findOne(['id'=>$id]);
//        //删除该对象
//        $brand->delete();
//        //设置提示信息
//        \Yii::$app->session->setFlash('danger','删除成功');
//        //跳转
//        return $this->redirect(['brand/index']);
//
//    }
    //逻辑隐藏

    public function actionHidden($id){
        $model=Brand::findOne(['id'=>$id]);
        $model->status=0;
        $model->save(false);
        \Yii::$app->session->setFlash('danger','隐藏成功');
        return $this->redirect(['brand/index']);

    }
    //逻辑删除
    public function actionDelete($id){
        $model=Brand::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save(false);
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['brand/index']);

    }
    //验证码配置
//    public function actions()
//    {
//
//        return [
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//                'minLength'=>4,
//                'maxLength'=>4,
//
//            ],
//        ];
//    }

    public function actionTest(){
        $ak = 'pZFXUDxDos7APSTST2KyHF3wZQOaZqCp63EkuxHS';
        $sk = 'qGPl9Vg5JUXLkGFAstUuY9E1O180ryQeRKODLrQI';
        $domain = 'http://or9o7h8b8.bkt.clouddn.com/';
        $bucket = 'php0217';
        $qiniu = new Qiniu($ak, $sk,$domain, $bucket);
        $fileName=\Yii::getAlias('@webroot').'/upload/1.jpg';
        $key = '1.jpg';
        $qiniu->uploadFile($fileName,$key);
        $url = $qiniu->getLink($key);
        var_dump($url);
    }

    public function actions() {
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
                    'extensions' => ['jpg', 'png','jpeg'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //得到这个上传图片的地址
                    $imgUrl = $action->getWebUrl();
//                    $action->output['fileUrl'] = $action->getWebUrl();
                    //调用七牛云组件，将图片上传到七牛云
                    //实例化七牛云类
                    $qiniu=\Yii::$app->qiniu;
                    //上传图片到七牛云上面
                    $qiniu->UploadFile(\Yii::getAlias('@webroot').$imgUrl,$imgUrl);
                    //得到图片地址
                    $url = $qiniu->getLink($imgUrl);
                    //将回显地址显示成七牛云地址
                    $action->output['fileUrl'] = $url;
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
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
