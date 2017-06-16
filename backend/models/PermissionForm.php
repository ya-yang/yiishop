<?php


namespace backend\models;


use yii\base\Model;
use yii\rbac\Permission;

class PermissionForm extends Model
{
    public $name;
    public $description;
    public function rules(){
        return [
            [['name','description'],'required'],
            //验证名称的唯一性
//            ['name','validateName']
        ];

    }
    public function attributeLabels(){
        return [
            'name'=>'名称',
            'description'=>'描述',
        ];
    }

    public function addPermission(){
        //实例化authManager模型
        $authManager=\Yii::$app->authManager;
        $permission=$authManager->getPermission($this->name);
        if($permission){
            $this->addError('name','该权限已存在');
        }else {
            //创建权限
            $permission = $authManager->createPermission($this->name);
            $permission->description = $this->description;
            //保存到数据
            return $authManager->add($permission);
        }
        return false;
    }
    public function loadData(Permission $permission){
        //反着赋值
        $this->name=$permission->name;
        $this->description=$permission->description;

    }
    public function updatePermission($name){
        //实例化组件
        $authManager=\Yii::$app->authManager;
        $permission=$authManager->getPermission($name);
        if($name != $this->name && $authManager->getPermission($this->name)){
            $this->addError('name','该权限已存在');
        }else{
            //赋值
            $permission->name=$this->name;
            $permission->description=$this->description;
            return $authManager->update($name,$permission);
        }
        return false;
    }


}