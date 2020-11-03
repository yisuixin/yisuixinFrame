<?php
namespace app\controllers\v1;


use app\common\BaseController;

class TestController extends BaseController {
    public $modelClass = 'app\models\User';
    public function actionIndex($id = ''){
        return $id;
    }
    public function actionTest(){
        return 456;
    }
}
