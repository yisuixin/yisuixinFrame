<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.apiTokenExpire' => 1*24*3600,
    'default_page_size' => '10',
    'vue_template_cata' => __DIR__ . '/../vueTempate/src/views',
    'default_pass'=>'123456',
    'commonId'=>'common',//公共权限模块名称，这个模块下的url全部可以访问，不受rbac限制
//    'common_url'=>[//公共权限，全部可以访问
//        'common/captcha/get-captcha',
//        'common/user/login',
//        'common/quick-operation/get-quick-list',
//        'common/quick-operation/add-quick',
//        'common/quick-operation/get-user-menu-list',
//        'common/system-info/server-info',
//        'account/user/get-user-info',
//        'account/user/edit-user-info',
//        'account/user/edit-user-pass',
//        'upload/upload/upload-one-img',
//
//        'api/log/list',
//
//        'api/to-do/list',
//        'api/to-do/get-to-do-list',
//        'api/to-do/get-month-to-do-list',
//        'api/to-do/add-or-edit',
//
//
//
//        'api/notice/get-user-notice-list',
//        'api/notice/get-notice-info',
//    ],
    'admin_user_role_id'=>1//超级管理员角色id
];
