<?php
//公共模块url
$common =  require __DIR__ . '/../modules/common/urlRule.php';
//公共模块url
$content =  require __DIR__ . '/../modules/content/urlRule.php';
//系统设置模块url
$system =  require __DIR__ . '/../modules/system/urlRule.php';
return array_merge($common,$system,$content);
