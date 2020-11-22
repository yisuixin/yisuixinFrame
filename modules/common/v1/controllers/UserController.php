<?php
namespace app\modules\common\v1\controllers;


use Yii;
use app\components\ApiController;
use app\models\User;
use app\models\LoginForm;
use app\models\rbac\Rbac;
use app\models\CodeImgGenerate;


class UserController extends ApiController{
    public $modelClass = 'app\models\User';
    //登录
    public function actionLogin (){
        $post = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        $model = new LoginForm;
        $model->setAttributes($post);
        try {
                //验证验证码
                $validCaptcha = CodeImgGenerate::validCaptcha($post['captchaKey'],$post['captchaCode']);
                if(!$validCaptcha){
                    return $this->ajaxFail('登录失败,验证码错误');
                }
                $user  = $model->login();//登录查询用户
                if($user){
                    //查询账号是否被禁用或者删除
                    if($user->status != User::STATUS_ACTIVE){
                        User::addLoginLog(1,$post);
                        return $this->ajaxFail('登录失败,该账号已被禁用或者已被删除');
                    }else{
                        $user->last_ip = getIPaddress();//更新最后登录ip
                        $user->save();
                    }
                    $d['token'] = $user->api_token;
                    $d['userInfo'] = (new User())->getUserInfo($model->_user->attributes);
                    //获取当前登录用户的角色，通过角色来查询拥有的权限列表和菜单列表
                    $permissionList = Rbac::getLayoutMenu($user);
                    $d['menuList'] = $permissionList['menuList'];
                    $d['vueRoute'] = $permissionList['vueRoute'];
                    User::addLoginLog(2,$post);
                    $transaction->commit();
                    return $this->ajaxSuccess('登录成功',$d);
                }else{
                    User::addLoginLog(3,$post);
                    $transaction->commit();
                    return $this->ajaxFail('登录失败,账号或者密码错误');
                }
        }catch (Exception $e) {
            $transaction->rollBack();
            return $this->ajaxFail('登录失败,未知错误');
        }
    }
    //获取用户信息
    public function actionGetUserInfo(){
        $user = (new User())->getUserInfo(Yii::$app->user->identity->attributes);
        return $this->ajaxSuccess('获取成功', $user);
    }
    //更新用户信息
    public function actionEditUserInfo(){
        $post     = Yii::$app->request->post();
        $user_id = Yii::$app->user->identity->id;
        if(!$user_id){
            return $this->ajaxFail('修改失败,数据错误');
        }
        $model = (new User())->findIdentity($user_id);
        if(!$model){
            return $this->ajaxFail('修改失败,数据错误');
        }
        $model->setScenario('edit_user');
        if($model->load($post,'') && $model->validate()){
            if(!$model->save(false)){
                return $this->ajaxFail('修改失败,未知错误');
            }else{
                $user = (new User())->getUserInfo($model->attributes);
                return $this->ajaxSuccess('修改成功',$user);
            }
        }else{
            return $this->ajaxFail('修改失败.'.current($model->getErrors())[0]);
        }
    }
    //更新用户密码
    public function actionEditUserPass(){
        $post     = Yii::$app->request->post();
        $user_id = Yii::$app->user->identity->id;
        if(!$user_id){
            return $this->ajaxFail('修改失败,数据错误');
        }
        $model = (new User())->findIdentity($user_id);
        if(!$model){
            return $this->ajaxFail('修改失败,数据错误');
        }
        $model->setScenario('edit_pass');
        if($model->load($post,'') && $model->validate()){
            $model->password_hash = (new User())->setPassword($post['newPass']);
            if(!$model->save(false)){
                return $this->ajaxFail('修改失败,未知错误');
            }else{
                return $this->ajaxSuccess('修改成功');
            }
        }else{
            return $this->ajaxFail('修改失败.'.current($model->getErrors())[0]);
        }
    }
}