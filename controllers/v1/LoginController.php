<?php
namespace app\controllers\v1;


use app\common\BaseController;

class LoginController extends BaseController {
    public $modelClass = 'app\models\User';
    public function actionLogin($uid = ''){
        return $uid;
    }
    public function actionTest(){
        return 456;
    }
}
