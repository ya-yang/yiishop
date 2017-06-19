<?php

namespace backend\controllers;

use backend\models\Menu;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class MenuController extends \yii\web\Controller
{
    //列表
    public function actionIndex()
    {
        $models=Menu::find()->all();
        return $this->render('index',['models'=>$models]);
    }
    //添加
    public function actionAdd(){
        $model=new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','添加菜单成功');
            return $this->redirect('index');
        }else{
            var_dump($model->getErrors());
        }
        return $this->render('add',['model'=>$model]);
    }
    //修改
    public function actionEdit($id){
        $model=Menu::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','修改菜单成功');
            return $this->redirect('index');
        }else{
            var_dump($model->getErrors());
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDel($id){
        $model=Menu::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除菜单成功');
        return $this->redirect('index');
    }

}
