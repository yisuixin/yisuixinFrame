<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['account/user'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST login' => 'login',
            'GET  reg' => 'reg',
            'GET  get-user-info' => 'get-user-info',
            'POST edit-user-info' => 'edit-user-info',
            'POST edit-user-pass' => 'edit-user-pass'
        ]
    ],
];