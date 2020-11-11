<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
//        'api' => [
//            'class' => 'app\modules\api\Module',
//        ],
//        'rabc' => [
//            'class' => 'app\modules\rabc\Module',
//        ],
        'upload' => [
            'class' => 'app\modules\upload\v1\Module',
        ],
        'account' => [
            'class' => 'app\modules\account\v1\Module',
        ],
        'common' => [
            'class' => 'app\modules\common\v1\Module',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            // 上面这种是Yii默认的缓存方式，标准文件缓存数据，当然也可以使用其他方式，如：
            // 'class' => 'yii\caching\MemCache',
            // 'class' => 'yii\caching\ApcCache',
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $code = $response->getStatusCode();
                $msg = $response->statusText;
                if ($code == 404) {
                    $data = '页面未找到';
                    !empty($response->data['message']) && $msg = $response->data['message'];
                }else{
                    $data = $response->data;
                }
                //设置固定返回数据参数
                $data = [
                    'code' => $code,
//                    'msg' => $msg,
                    'data' => $data
                ];
                $code == 200 && $data['data'] = $response->data;
                $response->data = $data;
                $response->format = yii\web\Response::FORMAT_JSON;
            },
        ],
        'request' => [
            'cookieValidationKey' => 'FpEye-KYGjG9JCirAXqm2Ie1Ffem51s5',
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' =>true,
            'rules' => require(__DIR__ . '/urlRule.php'),
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
