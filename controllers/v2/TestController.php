<?php

namespace app\v2\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\rest\ActiveController;

class UserController extends ActiveController {
    public $modelClass = 'app\models\User';
        public function actionIndex(){
        echo 11111;
    }
}

//class TestController extends Controller{
//
//    public function actionIndex(){
//        echo 11111;
//    }
//
//
//}
