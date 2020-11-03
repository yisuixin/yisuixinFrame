<?php
//api模块url
$api =  require __DIR__ . '/../modules/api/urlRule.php';

//rabc模块url
$rabc =  require __DIR__ . '/../modules/rabc/urlRule.php';

return array_merge($api,$rabc);
