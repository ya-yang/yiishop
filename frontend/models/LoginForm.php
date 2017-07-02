<?php


namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $code;
    public $remember;

    const SCENARIO_API_LOGIN = 'api_login';
    const SCENARIO_LOGIN = 'login';
    public function rules()
    {
       return [
           [['username','password'],'required'],
           ['remember','boolean'],
           ['code','captcha','on'=>self::SCENARIO_LOGIN,],
           ['code','captcha','on'=>self::SCENARIO_API_LOGIN,'captchaAction'=>'api/captcha'],
           ['username','validateUsername']
       ];
    }
    public function attributeLabels()
    {

        return [
            'username'=>'用户名：',
            'password'=>'密码：',
            'code'=>'验证码：',
            'remember'=>''
        ];
    }
    public function validateUsername(){
        //先查找用户名是否存在
        $user=Member::findOne(['username'=>$this->username]);
        if($user){
            //存在比对密码
            if(!\Yii::$app->security->validatePassword($this->password,$user->password_hash)){
                $this->addError('username', '用户名或者密码错误');
            }else{

                $user->last_login_time=time();
                $ip=\Yii::$app->getRequest()->getUserIP();
                $ip=ip2long($ip);
                $user->last_login_ip=$ip;
                $user->save(false);
                //自动登录
                $duration = $this->remember?3600*24*7:0;
                //登录
                \Yii::$app->user->login($user,$duration);
            }
        }else{
            $this->addError('username', '用户名或者密码错误');
        }
    }

}