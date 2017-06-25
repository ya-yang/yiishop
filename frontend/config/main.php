<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    //语言
    'language'=>'zh-CN',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => \frontend\models\Member::className(),
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'urlManager' => [   //地址管理
            'enablePrettyUrl' => true, //开启美化地址
            'showScriptName' => false, //显示脚本文件
            'suffix' => '.html',	// 伪静态后缀
            'rules' => [ //自定义路由规则
            ],
        ],
        //配置短信组件
        'sms'=>[
            'class'=>\frontend\components\Sms::className(),
            'app_key'    => '24479459',
            'app_secret' => '98ac3b47f59e728826921249f1d2a9fb',
            'sign_name'=>'杨雅的网站',
            'template_code'=>'SMS_71475157',

        ],
    ],
    'params' => $params,
];
