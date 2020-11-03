<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['rabc/rabc'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST  add-manager' => 'add-manager',
            'GET  get-user-list' => 'get-user-list',
            'POST  edit-manager' => 'edit-manager',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['rabc/menu'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  list' => 'list',
            'GET  get-role-menu-list' => 'get-role-menu-list',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['rabc/menu'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  list' => 'list',
            'POST add-or-edit'=>'add-or-edit',
            'POST delete-menu'=>'delete-menu',
            'POST add-menu'=>'add-menu'
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['rabc/menu'],
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
    [//增加管理角色url
        'class' => 'yii\rest\UrlRule',
        'controller' => ['rabc/role'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST  add-role' => 'add-role',
            'GET  get-role-list' => 'get-role-list',
            'GET  get-role-info' => 'get-role-info',
            'POST  delete-role' => 'delete-role',
            'POST add-role-permission' => 'add-role-permission',
        ]
    ],
];