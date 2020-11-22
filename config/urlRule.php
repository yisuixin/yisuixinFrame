<?php
//公共模块url
$common =  require __DIR__ . '/../modules/common/v1/urlRule.php';
//用户模块url
$account =  require __DIR__ . '/../modules/account/v1/urlRule.php';
//菜单模块url
$menu =  require __DIR__ . '/../modules/menu/v1/urlRule.php';
//rbac模块url
$rbac =  require __DIR__ . '/../modules/rbac/v1/urlRule.php';
//logs日志模块url
$logs =  require __DIR__ . '/../modules/log/v1/urlRule.php';
return array_merge($common,$account,$menu,$rbac,$logs);
