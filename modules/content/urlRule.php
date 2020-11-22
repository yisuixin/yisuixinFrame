<?php
return [
    [//通知公告
        'class' => 'yii\rest\UrlRule',
        'controller' => ['content/notice'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-admin-notice-list' => 'get-admin-notice-list',//获取通知列表
            'GET  get-notice-info' => 'get-notice-info',
            'POST  add-notice' => 'add-notice',
            'POST  delete-notice' => 'delete-notice',
            'POST  topping-notice' => 'topping-notice',
        ]
    ],
];