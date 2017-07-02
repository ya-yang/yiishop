<?php

namespace frontend\controllers;


use frontend\models\Address;
use frontend\models\Locations;
use yii\filters\AccessControl;
use yii\web\Controller;

class AddressController extends Controller
{
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    [
                        'allow'=>true,
                        'roles'=>['@'],
                    ]
                ],
            ],
        ];
    }
    public $layout='address';
    //首页
    public function actionIndex(){
        $models=Address::findAll(['member_id'=>\Yii::$app->user->id]);
        $model=new Address();
        if(\Yii::$app->request->isPost){
            if($model->load(\Yii::$app->request->post()) && $model->validate()){
                //如果它选择了设为默认地址的话要先清空原来
                if($model->is_default){
                    $addresses=Address::find()->all();
                    foreach ($addresses as $address){
                        $address->is_default = 0;
                        $address->save();
                    }
                }
                $model->member_id=\Yii::$app->user->getId();
                $model->save();
                return $this->refresh();
            }
            if(!$model->validate()){
                var_dump($model->getErrors());
            }
        }
        return $this->render('index',['model'=>$model,'models'=>$models]);
    }
    //修改
    public function actionEdit($id){
        $model=Address::findOne(['id'=>$id]);
        if(\Yii::$app->request->isPost){
            if($model->load(\Yii::$app->request->post()) && $model->validate()){
                //如果它选择了设为默认地址的话要先清空原来
                if($model->is_default){
                    $addresses=Address::find()->all();
                    foreach ($addresses as $address){
                        $address->is_default = 0;
                        $address->save();
                    }
                }
                $model->save();
                return $this->redirect('index.html');
            }
            if(!$model->validate()){
                var_dump($model->getErrors());
            }
        }

        return $this->render('edit',['model'=>$model]);
    }
    //删除
    public function actionDel($id){
        $model=Address::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect('index.html');
    }
    //设置为默认地址
    public function actionDefault($ad_id){
        $addresses=Address::find()->all();
        foreach ($addresses as $address){
            $address->is_default = 0;
            $address->save();
        }
        $model=Address::findOne(['id'=>$ad_id]);
        $model->is_default = 1;
        $model->save();
        return $this->redirect('index.html');


    }
    //配置
//    public function actions()
//    {
//        $actions=parent::actions();
//        $actions['get-region']=[
//            'class'=>\chenkby\region\RegionAction::className(),
//            'model'=>\frontend\models\Address::className()
//        ];
//        return $actions;
//    }




}
