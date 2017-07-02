<?php


namespace frontend\models;


use yii\base\Model;

class EditPassword extends Model
{
    public $old_password;
    public $password;
    public $re_password;
    public function rules(){
        return [
            [['old_password','password','re_password'],'required'],
            ['re_password','compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
            //自定义验证方法
            [['password', 're_password'], 'validatePass'],
        ];
    }
    public function attributeLabels(){
        return [
            'old_password'=>'旧密码',
            'password'=>'新密码',
            're_password'=>'确认密码',
        ];
    }
    public function validatePass(){
        $member=Member::findOne(['id'=>\Yii::$app->user->identity->getId()]);
        if(!\Yii::$app->security->validatePassword($this->old_password,$member->password_hash)){
            $this->addError('old_password','旧密码有误');
        }
        return true;


    }

}