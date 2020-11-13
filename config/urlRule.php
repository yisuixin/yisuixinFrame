<?php
//公共模块url
$common =  require __DIR__ . '/../modules/common/v1/urlRule.php';
//用户模块url
$account =  require __DIR__ . '/../modules/account/v1/urlRule.php';


return array_merge($common,$account);
