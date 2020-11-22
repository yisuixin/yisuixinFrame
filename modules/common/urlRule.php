<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/user'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST login' => 'login',
            'GET  reg' => 'reg',
            'GET  get-user-info' => 'get-user-info',
            'POST edit-user-info' => 'edit-user-info',
            'POST edit-user-pass' => 'edit-user-pass'
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/captcha'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-captcha' => 'get-captcha',//获取验证码
        ]
    ],
    //上传文件
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/upload'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST upload-one-img'=>'upload-one-img',
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
    //快捷菜单
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/quick-operation'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-quick-list' => 'get-quick-list',//获取快捷方式列表
            'GET  get-user-menu-list' => 'get-user-menu-list',
            'POST  add-quick' => 'add-quick',
        ]
    ],
    //服务器信息
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/system-info'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  server-info' => 'server-info',
        ]
    ],
    //通知公告
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/notice'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-user-notice-list' => 'get-user-notice-list',//获取通知列表
            'GET  get-notice-info' => 'get-notice-info',

        ]
    ],
    //待办事项
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['common/to-do'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-to-do-list' => 'get-to-do-list',
            'GET  get-month-to-do-list' => 'get-month-to-do-list',
            'GET  view-todo' => 'view-todo',
            'POST add-or-edit'=>'add-or-edit',
            'POST delete-todo'=>'delete-todo'
        ]
    ],
];