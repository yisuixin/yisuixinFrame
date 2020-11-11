<?php
namespace app\modules\api\controllers;

use Yii;
use app\components\ApiController;
use app\models\User;
use app\models\LoginForm;

class LoginController extends ApiController{
    public $modelClass = 'app\models\User';
    public function actionLogin(){
        $d['username'] = $this->post('username');
        $d['password'] = $this->post('password');
        $t = Yii::$app->request->post();



        $user = new User();
        $user->username = $this->post('username');
        $user->email = '1036753791@qq.com';
        $user->setPassword($this->post('password'));
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save();



//        $model = new LoginForm();
//        if ($model->load($t,'') && $model->login()) {
//                return $this->ajaxSuccess('登录成功','',$model->_user);
//        }else{
//            return $this->ajaxFail('登录失败.'.current($model->getErrors())[0]);
//        }

    }
}