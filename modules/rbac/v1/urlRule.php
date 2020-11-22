<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['rbac/manager'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST  add-manager' => 'add-manager',
            'GET  get-manager-list' => 'get-manager-list',
            'POST  edit-manager' => 'edit-manager',
        ]
    ],
    [//角色管理url
        'class' => 'yii\rest\UrlRule',
        'controller' => ['rbac/role'],
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