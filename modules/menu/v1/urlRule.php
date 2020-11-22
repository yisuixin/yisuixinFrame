<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['menu/menu'],
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
];