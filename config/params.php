<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.apiTokenExpire' => 1*24*3600,
    'default_page_size' => '10',
    'vue_template_cata' => __DIR__ . '/../vue-tempate/src/views',
    'default_pass'=>'123456',
    'notValidationPermissionModules'=>['common'],//不需要验证权限的模块列表
    'admin_user_role_id'=>1//超级管理员角色id
];
