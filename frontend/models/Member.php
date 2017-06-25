<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;
    public $repassword;
    public $code;
    public $read;
    public $smscode;//短信验证码

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','password','repassword','email', 'tel','code','smscode','read'], 'required'],
            [['last_login_time', 'last_login_ip', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'email'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 11],
            [['username'], 'unique','message'=>'该用户名已存在'],
            [['email'], 'unique','message'=>'该邮箱已注册'],
            [['tel'], 'unique','message'=>'该电话已注册'],

            //两次密码验证
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
            //邮箱验证
            ['email','email'],
            //验证电话
            ['tel','match','pattern'=>'/^1[3,4,5,7,8,9]\d{9}$/','message'=>'手机号码格式不正确'],
            //验证码
            ['code','captcha','captchaAction'=>'site/captcha'],
            //
            ['smscode','validateSms'],
            ['read','validateRead'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名：',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码(密文)',
            'email' => '邮箱：',
            'tel' => '电话：',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
            'status' => '状态(1正常 0删除)',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'password'=>'密码：',
            'repassword'=>'确认密码：',
            'code'=>'验证码：',
            'smscode'=>'验证码：',
            'read'=>'',
        ];
    }
    public function validateSms(){
        $value=Yii::$app->cache->get('tel_'.$this->tel);
        if(!$value || $value != $this->smscode){
            $this->addError('smscode','验证码错误');
        }
    }
    public function validateRead(){
        if(!$this->read){
            $this->addError('read','请阅读用户协议');
        }
    }
    public function beforeSave($insert)
    {
        if($insert){
            $this->created_at=time();
            $this->status = 1;
            $this->auth_key = Yii::$app->security->generateRandomString();
        }else{
            $this->updated_at=time();
        }
        //密码加密
        if($this->password){
            $this->password_hash=\Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        //通过id获取账号
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }
}
