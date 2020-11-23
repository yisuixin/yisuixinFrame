<?php
namespace app\modules\test\controllers;


use Yii;
use app\components\ApiController;


class TestController extends ApiController{
    public $modelClass = 'app\models\test';

    public function actionList(){
       p(2222);
    }

}
