<?php

namespace app\common;

use Yii;

class BaseModule extends \yii\base\Module{

    public function init(){
        parent::init();
        //由于RESTful遵循的是无状态可将用户session关闭
        \Yii::$app->user->enableSession = false;
        //关闭登录失败跳转
        \Yii::$app->user->loginUrl = null;
    }
}