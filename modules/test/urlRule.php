<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['test/test'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  list' => 'list',
        ]
    ],
];