<?php

namespace backend\controllers;

use backend\models\PermissionForm;
use yii\web\NotFoundHttpException;

class RbacController extends \yii\web\Controller
{

    //权限列表
    public function actionPermissionIndex()
    {
        $permissions=\Yii::$app->authManager->getPermissions();
        return $this->render('permission-index',['permissions'=>$permissions]);
    }

    //添加权限
    public function actionAddPermission(){
        $model=new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addPermission()){
                \Yii::$app->session->setFlash('添加权限成功');
                return $this->redirect('permission-index');
            }
        }
        return $this->render('add-permission',['model'=>$model]);
    }

    //修改权限
    public function actionEditPermission($name){
        $permission=\Yii::$app->authManager->getPermission($name);
        //判断是否有该权限
        if($permission == null){
            throw new NotFoundHttpException('没有该权限');
        }
        $model=new PermissionForm();
        //加载数据到表单页面
        $model->loadData($permission);
        //
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->updatePermission($name)){
                \Yii::$app->session->setFlash('修改权限成功');
                return $this->redirect('permission-index');
            }

        }
        return $this->render('add-permission',['model'=>$model]);
    }

    //删除权限
    public function actionDelPermission($name){
        //实例化组件
        $authManger=\Yii::$app->authManager;
        //查找删除的对象
        $permission=$authManger->getPermission($name);
        //删除
        $authManger->remove($permission);
        //提示跳转
        \Yii::$app->session->setFlash('删除权限成功');
        return $this->redirect('permission-index');

    }

    //添加角色
    public function actionAddRole(){

    }

}
