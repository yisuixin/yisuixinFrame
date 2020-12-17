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
    [//模型管理
        'class' => 'yii\rest\UrlRule',
        'controller' => ['content/model'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET  get-model-list' => 'get-model-list',//获取模型列表
            'GET  get-model-info' => 'get-model-info',//获取模型信息
            'POST  add-model' => 'add-model',//添加模型
            'POST  edit-model' => 'edit-model',//编辑模型
            'POST  delete-model' => 'delete-model',//删除模型
        ]
    ],
];