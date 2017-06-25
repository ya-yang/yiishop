<?php

namespace backend\controllers;

use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\web\NotFoundHttpException;

class RbacController extends BackendController
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
        $model=new RoleForm();
        if($model->load(\Yii::$app->request->post())&& $model->validate() ){
            if($model->addRole()){
                \Yii::$app->session->setFlash('添加角色成功');
                return $this->redirect('role-index');
            }
        }
        return $this->render('add-role',['model'=>$model]);
    }

    //修改角色
    public function actionEditRole($name){
        $authManager=\Yii::$app->authManager;
        $role=$authManager->getRole($name);
        //判断是否有该角色
        if($role == null){
            throw new NotFoundHttpException('没有此角色');
        }
        $model=new RoleForm();
        //加载数据
        $model->loadData($role);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->updateRole($name)){
                \Yii::$app->session->setFlash('修改角色成功');
                return $this->redirect('role-index');

            }

        }
        return $this->render('add-role',['model'=>$model]);
    }

    //删除角色
    public function actionDelRole($name){
        $authManger=\Yii::$app->authManager;
        $role = $authManger->getRole($name);
        $authManger->remove($role);
        \Yii::$app->session->setFlash('success','删除角色成功');
        return $this->redirect('role-index');

    }

    //角色列表
    public function actionRoleIndex(){
        $authManger=\Yii::$app->authManager;
        $roles=$authManger->getRoles();
        return $this->render('role-index',['roles'=>$roles]);
    }

}
