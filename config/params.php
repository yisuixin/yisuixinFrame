<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.apiTokenExpire' => 1*24*3600,
    'default_page_size' => '10',
    'vue_template_cata' => __DIR__ . '/../vueTempate/src/views',
    'default_pass'=>'123456',
    'common_url'=>[//公共权限，全部可以访问
        'common/captcha/get-captcha',
        'common/user/login',
        'api/user/get-user-info',
        'api/user/edit-user-info',
        'api/user/edit-user-pass',
        'api/upload/upload-one-img',

        'api/log/list',
        'api/system-info/server-info',
        'api/to-do/list',
        'api/to-do/get-to-do-list',
        'api/to-do/get-month-to-do-list',
        'api/to-do/add-or-edit',
        'api/quick-operation/get-quick-list',
        'api/quick-operation/get-user-menu-list',
        'api/quick-operation/add-quick',
        'api/notice/get-user-notice-list',
        'api/notice/get-notice-info',
    ],
    'admin_user_role_id'=>1//超级管理员角色id
];
