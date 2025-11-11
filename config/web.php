<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name'=>'Teszt',
    'language' => 'hu-HU',
    'sourceLanguage' => 'hu-HU',
    'timeZone' => 'Europe/Budapest',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [

         'user' => [
    'identityClass' => 'app\models\User', //<= this
    'enableAutoLogin' => true,
    ],

        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'js/jquery.js',
                    ]
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => '6OMfds89716U86ZEQkvD8WWqqOpekykxvEjfkdlVnmIVBOvCNREl',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'class' => 'app\components\CustomUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'termekek' => 'site/products',
            ],
        ],
        'view' => [
            'class' => 'yii\web\View',
            'theme' => [
                'basePath' => '@app/themes/main',
                'baseUrl' => '@web/themes/main',
                'pathMap' => [
                    '@app/views' => '@app/themes/main',
                    '@app/modules' => '@app/themes/main/modules'
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['shopmentor1@gmail.com' => 'ShopMentor'],
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'shopmentor1@gmail.com',
                'password' => 'acznfervsijlwfgv',
                'port' => '465',
                'encryption' => 'ssl',
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1']
        ],

    ],
    
    'params' => $params,
];

return $config;
