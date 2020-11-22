<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['log/login-log'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  list' => 'list',
        ]
    ],
];