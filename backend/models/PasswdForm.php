<?php


namespace backend\models;


use yii\base\Model;

class PasswdForm extends Model
{
    public $oldpasswd;
    public $passwd;
    public $repasswd;
    public $code;
    public function rules(){
        return [
            [['oldpasswd','passwd','repasswd'],'required'],
            ['repasswd','compare','compareAttribute'=>'passwd','message'=>'两次密码不一致'],
            //验证码规则
            ['code','captcha','captchaAction'=>'user/captcha'],
            //自定义验证方法
            [['passwd', 'repasswd'], 'validatePass'],
        ];
    }
    public function attributeLabels(){
        return [
            'oldpasswd'=>'旧密码',
            'passwd'=>'新密码',
            'repasswd'=>'确认密码',
            'code'=>'验证码',
        ];
    }
    public function validatePass(){
        $user=User::findOne(['id'=>\Yii::$app->user->identity->getId()]);
        if(!\Yii::$app->security->validatePassword($this->oldpasswd,$user->password_hash)){
            $this->addError('oldpasswd','旧密码有误');
        }
        return true;


    }

}