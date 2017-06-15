<?php


namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $code;
    public $username;
    public $password;
    //记住我
    public $rememberMe;
    public function rules(){
        return [
            [['username','password'],'required'],
            ['rememberMe','boolean'],
            //验证码规则
            ['code','captcha','captchaAction'=>'user/captcha'],
            //自定义验证方法
            ['username', 'validateUsername']

        ];

    }
    public function attributeLabels(){
        return[
            'username'=>'用户名',
            'password'=>'密码',
            'code'=>'验证码',
            'rememberMe'=>'记住我',
        ];
    }
    public function validateUsername(){
        //先查找用户名是否存在
        $user=User::findOne(['username'=>$this->username]);
        if($user){
            //存在比对密码
            if(!\Yii::$app->security->validatePassword($this->password,$user->password_hash)){
                $this->addError('username', '用户名或者密码错误');
            }else{

                $user->last_login_time=time();
                $ip=\Yii::$app->getRequest()->getUserIP();
                $user->last_login_ip=$ip;
                $user->save(false);
                //自动登录
                $duration = $this->rememberMe?3600*24*7:0;
                //登录
                \Yii::$app->user->login($user,$duration);
            }
        }else{
            $this->addError('username', '用户名或者密码错误');
        }
    }

}