<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/captcha'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-captcha' => 'get-captcha',//获取验证码
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/user'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST login' => 'login',  //登录
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/upload'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST upload-one-img'=>'upload-one-img', //上传单图
        ]
    ],

];