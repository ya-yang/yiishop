<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    //语言
    'language'=>'zh-CN',
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => \backend\models\User::className(),
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['user/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        ],*/
        //地址美化
        'urlManager' => [   //地址管理
            'enablePrettyUrl' => true, //开启美化地址
            'showScriptName' => false, //显示脚本文件
//            'suffix' => '.html',	// 伪静态后缀
            'rules' => [ //自定义路由规则
            ],
        ],
        //设置七牛云上传的配置
        'qiniu'=>[
            'class'=>\backend\components\Qiniu::className(),
            'up_host'=>'http://up-z2.qiniu.com',
            'accessKey'=>'pZFXUDxDos7APSTST2KyHF3wZQOaZqCp63EkuxHS',
            'secretKey'=>'qGPl9Vg5JUXLkGFAstUuY9E1O180ryQeRKODLrQI',
            'bucket'=>'php0217',
            'domain'=>'http://or9o7h8b8.bkt.clouddn.com/',
        ]

    ],

    'params' => $params,
];
