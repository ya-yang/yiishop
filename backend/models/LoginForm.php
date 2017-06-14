<?php


namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public function rules(){
        return [
            [['username','password'],'required'],

        ];

    }
    public function attributeLabels(){
        return[
            'username'=>'用户名',
            'password'=>'密码',
        ];
    }

}