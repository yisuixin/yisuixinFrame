<?php
namespace app\modules\account\v1\controllers;

use app\common\lib\Tree;
use app\components\ApiController;
use app\modules\rabc\model\PagePermission;
use app\modules\rabc\model\RolePermissionItem;
use Yii;
use app\models\User;
use app\models\LoginForm;
use app\modules\rabc\model\Menu;
use app\models\Log;
use app\modules\rabc\model\Role;
use yii\db\Query;
use yii\db\Expression;
use app\modules\rabc\model\Rbac;
use app\models\CodeImgGenerate;


class UserController extends ApiController{
    public $modelClass = 'app\models\User';
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