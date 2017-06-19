<?php


namespace backend\models;


use yii\base\Model;

class RoleForm extends Model
{
    public $name;
    public $description;
    public $permissions=[];

    //验证规则
    public function rules(){
        return [
            [['name','description'],'required'],
            ['permissions','safe'],//表示该字段不需要验证
        ];
    }

    //中文名
    public function attributeLabels(){
        return [
            'name'=>'角色名称',
            'description'=>'描述',
            'permissions'=>'权限',
        ];

    }

    //获取所有权限选项
    public static function getPermissionOptions(){
        $authManger=\Yii::$app->authManager;
        $permissions=$authManger->getPermissions();
        return \yii\helpers\ArrayHelper::map($permissions,'name','description');

    }

    //添加角色
    public function addRole(){
        $authManger=\Yii::$app->authManager;
        if($authManger->getRole($this->name)){
            $this->addError('name','该角色已存在');
        }else{
            //创建角色
            $role=$authManger->createRole($this->name);
            $role->name=$this->name;
            $role->description=$this->description;
            //写入数据库
            if($authManger->add($role)){
                //权限添加
                foreach($this->permissions as $permissionName){
                    $permission=$authManger->getPermission($permissionName);
                    $authManger->addChild($role,$permission);

                }
                return true;
            }
        }
        return false;
    }

    //加载数据
    public function loadData($role){
        $this->name=$role->name;
        $this->description=$role->description;
        //权限回显
        $permissions=\Yii::$app->authManager->getPermissionsByRole($role->name);
        foreach ($permissions as $permission){
            $this->permissions[]=$permission->name;
        }
    }

    //修改角色
    public function updateRole($name){
        $authManger=\Yii::$app->authManager;
        $role = $authManger->getRole($name);
        if($name != $this->name && $authManger->getRole($this->name)){
            $this->addError('name','该角色已存在');
        }else{
            //赋值
            $role->name=$this->name;
            $role->description=$this->description;
            if($authManger->update($name,$role)){
                //先清除所有权限
                $authManger->removeChildren($role);
                //在赋值
                foreach ($this->permissions as $permissionName){
                    $permission = $authManger->getPermission($permissionName);
                    if($permission) $authManger->addChild($role,$permission);
                }
                return true;
            }
        }
        return false;

    }
}