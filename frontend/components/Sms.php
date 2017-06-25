<?php

namespace frontend\components;
use yii\base\Component;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class Sms extends Component
{
    public $app_key;
    public $app_secret;
    public $sign_name;
    public $template_code;
    private $_num;
    private $_param=[];


    //设置手机号码
    public function setNum($num){
        $this->_num=$num;
        return $this;

    }
    //设置短信内容
    public function setParm(array $param){
        $this->_param=$param;
        return $this;

    }
    //设置短信签名
    public function setSign($sign){
        $this->sign_name=$sign;
        return $this;

    }
    //设置模板
    public function setTemplate($template){
        $this->template_code=$template;
        return $this;
    }
    public function send(){
        $client = new Client(new App(['app_key'=>$this->app_key,
            'app_secret' =>$this->app_secret,]));
        $req    = new AlibabaAliqinFcSmsNumSend;
        $mscode= rand(100000, 999999);
        $req->setRecNum($this->_num)//手机号码
        ->setSmsParam($this->_param)
            ->setSmsFreeSignName($this->sign_name)//设置短信签名必须是已经审核的签名
            ->setSmsTemplateCode($this->template_code);//设置模板的ID必须审核通过

       return  $client->execute($req);
    }

}