<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['account/common'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-captcha' => 'get-captcha',//获取验证码
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['api/login'],
        'pluralize' => false,  //不在url链接中的project-team后加s 复数
        'extraPatterns' => [
            'POST login' => 'login',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['api/upload'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST upload-one-img'=>'upload-one-img',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['api/user'],
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
        'controller' => ['api/log'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  list' => 'list'
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['api/system-info'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  list' => 'list'
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['api/to-do'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-to-do-list' => 'get-to-do-list',
            'GET  get-month-to-do-list' => 'get-month-to-do-list',
            'POST add-or-edit'=>'add-or-edit',
            'POST delete-todo'=>'delete-todo'
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['api/system-info'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  server-info' => 'server-info',
            'POST add-or-edit'=>'add-or-edit',
            'POST delete-todo'=>'delete-todo'
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['api/quick-operation'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-quick-list' => 'get-quick-list',//获取快捷方式列表
            'GET  get-user-menu-list' => 'get-user-menu-list',
            'POST  add-quick' => 'add-quick',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['api/notice'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-user-notice-list' => 'get-user-notice-list',//获取通知列表
            'GET  get-admin-notice-list' => 'get-admin-notice-list',//获取通知列表
            'GET  get-notice-info' => 'get-notice-info',
            'POST  add-notice' => 'add-notice',
            'POST  delete-notice' => 'delete-notice',
            'POST  topping-notice' => 'topping-notice',
        ]
    ],
];