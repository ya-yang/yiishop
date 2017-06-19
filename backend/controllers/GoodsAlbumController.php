<?php

namespace backend\controllers;

use backend\models\GoodsAlbum;
use yii\helpers\Url;
use yii\web\UploadedFile;

class GoodsAlbumController extends BackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    //相册上传
    public function actionAlbum($id){
        // 假设商品的图片是 $relationBanners,$id是商品的id
        // $relationBanners的数据结构如：
        /**
         * Array
         *(
         * [0] => Array
         * (
         * [id] => 1484314
         * [goods_id] => 1173376
         * [banner_url] => ./uploads/20160617/146612713857635322241f2.png
         * )
         *
         *)
         */
        $album = GoodsAlbum::find()->where(['goods_id' => $id])->asArray()->all();
        // 对商品相册图进行处理
        $p1 = $p2 = [];
        if ($album) {
            foreach ($album as $k => $v) {
                $p1[$k] = $v['img_path'];
                $p2[$k] = [
                    'url' => Url::toRoute('/goods-album/delete'),
                    'key' => $v['id'],
                ];
            }
        }
        $model = new GoodsAlbum;
        return $this->render('album', [
            'model' => $model,
            'p1' => $p1,
            'p2' => $p2,
            'id' => $id
        ]);

    }
    //异步上传
    public function actionAsyncImage ()
    {
        // 商品ID
        $id = \Yii::$app->request->post('goods_id');
        $p1 = $p2 = [];
//        var_dump($_FILES['GoodsAlbum']['name']['img_path']);die;
        if (empty($_FILES['GoodsAlbum']['name']) || empty($_FILES['GoodsAlbum']['name']['imgFile']) || !$id) {
            echo '{}';
            return;
        }
        for ($i = 0; $i < count($_FILES['GoodsAlbum']['name']['imgFile']); $i++) {
            $url = '/goods-album/delete';
            $model = new GoodsAlbum();
            $model->imgFile = UploadedFile::getInstance($model, 'imgFile');
            //验证数据有效性
            if ($model->validate()) {
                //保存图片
                $fileName = '/images/album/' . uniqid() . '.' . $model->imgFile->extension;
                $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $fileName, false);
                $imageUrl = $fileName; //调用图片接口上传后返回图片地址
                // 图片入库操作，此处不可以批量直接入库，因为后面我们还要把key返回 便于图片的删除
                $model->goods_id = $id;
                $model->img_path = $imageUrl;
                $key = 0;
                if ($model->save(false)) {
                    $key = $model->id;
                }
                // $pathinfo = pathinfo($imageUrl);var_dump($pathinfo);die;
                // $caption = $pathinfo['basename'];var_dump($pathinfo);die;
                // $size = $_FILES['Banner']['size']['banner_url'][$i];
                $p1[$i] = $imageUrl;
                $p2[$i] = ['url' => $url, 'key' => $key];
            }else{
                var_dump($model->getErrors());
            }
            echo json_encode([
                'initialPreview' => $p1,
                'initialPreviewConfig' => $p2,
                'append' => true,
            ]);
        }
        return ;
    }

    //删除相册图片
    public function actionDelete ()
    {
        if ($id = \Yii::$app->request->post('key')) {
//            var_dump($id);die;

//            var_dump($this->model);die;
            $model=GoodsAlbum::findOne(['id'=>$id]);
//            $model = $this->findModel($id);
            $model->delete();
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['success' => true];
    }

}
