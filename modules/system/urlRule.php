<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['system/menu'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  list' => 'list',
            'GET  get-only-menu' => 'get-only-menu',
            'GET  get-level-menu' => 'get-level-menu',
            'POST add-or-edit'=>'add-or-edit',
            'POST delete-menu'=>'delete-menu',
            'POST add-menu'=>'add-menu',
            'POST sort-menu'=>'sort-menu',
            'POST add-page-permission'=>'add-page-permission',
            'GET get-page-permission-list'=>'get-page-permission-list',
            'GET get-role-page-permission-list'=>'get-role-page-permission-list',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['system/manager'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST  add-manager' => 'add-manager',
            'GET  get-manager-list' => 'get-manager-list',
            'POST  edit-manager' => 'edit-manager',
            'POST  change-manager-role' => 'change-manager-role',
        ]
    ],
    [//角色管理url
        'class' => 'yii\rest\UrlRule',
        'controller' => ['system/role'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST  add-role' => 'add-role',
            'GET  get-role-list' => 'get-role-list',
            'GET  get-role-info' => 'get-role-info',
            'POST  delete-role' => 'delete-role',
            'POST add-role-permission' => 'add-role-permission',
        ]
    ],
    [//后台登录日志
        'class' => 'yii\rest\UrlRule',
        'controller' => ['system/login-log'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  list' => 'list',
        ]
    ],
    [//后台操作日志
        'class' => 'yii\rest\UrlRule',
        'controller' => ['system/operation-log'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  list' => 'list',
            'POST  del' => 'del',
        ]
    ],
];