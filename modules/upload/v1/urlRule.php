<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['upload/upload'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST upload-one-img'=>'upload-one-img',
        ]
    ],


];