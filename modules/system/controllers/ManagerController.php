<?php
namespace app\modules\system\controllers;


use Yii;
use app\components\ApiController;
use app\models\User;
use yii\db\Query;
use app\models\rbac\Role;
use yii\db\Expression;
class ManagerController extends ApiController{

    /**
     * 增加管理员
     * @return int[]
     */
    public function actionAddManager(){
        $post     = Yii::$app->request->post();
        $model = new User();
        $model->setScenario('add_manager');
        if($model->load($post,'') && $model->validate()){
            $model->password_hash = (new User())->setPassword($post['password']);
            $model->auth_key = (new User())->generateAuthKey();
            if(!$model->save(false)){
                return $this->ajaxFail('添加失败,未知错误');
            }else{
                return $this->ajaxSuccess('添加成功');
            }
        }else{
            return $this->ajaxFail('添加失败.'.current($model->getErrors())[0]);
        }
    }
    /**
     *获取管理员列表
     */
    public function actionGetManagerList(){
        $page      = $this->get('page', 0);
        $pageSize  = $this->get('pageSize', $this->getParams('default_page_size'));
        $offset    = ($page - 1) * $pageSize;
        $keys      = $this->get('keys', '');
        $status    = $this->get('status', '');

        $sql = (new Query())->select(
            [
                'user.id',
                'username',
                'nickname',
                'avatar',
                'email',
                'user.mark' ,
                'user.status',
                'last_ip',
                'user.updated_at',
                'role.type AS roleType',
                'role.id AS roleId',
                'role.name AS roleName'
            ])->from(User::tableName().' AS user');
        $sql->leftJoin(Role::tableName(), 'role.id = user.roleId');
        $where = "(`user`.`status` <> 0) 
        AND ((`username` LIKE '%".$keys."%') OR (`nickname` LIKE '%".$keys."%') OR (`user`.`mark` LIKE '%".$keys."%')  OR (`role`.`NAME` LIKE '%".$keys."%'))";
        if($status != ''){
            $where .= "AND (`user`.`status` = ".$status.")";
        }
        $expression = new Expression($where);
        $sql->where($expression);

        $d['count'] = (int)$sql->count();
        $d['list'] =  $sql->orderBy('user.roleId DESC,user.created_at DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->all();
            //p($this->printSql($sql));
        return $this->ajaxSuccess('获取成功',$d);
    }
    /**
     * 修改字段
     * @return int[]
     */
    public function actionEditManager(){
        $post     = Yii::$app->request->post();
        $id    = $post['editManagerId'];
        $type  = $post['editManagerType'];
        $value = $post['editManagerValue'];
        //p($post);
        $model = (new User())->findOne($id);
        if(is_null($model)){
            return $this->ajaxFail('操作失败.未找到管理员信息');
        }
        if($model->roleId == Role::TYPE_ONE){
            return $this->ajaxFail('操作失败,超级管理员无法操作');
        }
        $model->setScenario('edit_manager');
        $model->load($post,'');
        if($type == $model::REQUEST_TYPE_ONE){
            $info = '重置密码成功，重置密码为：'.$this->getParams('default_pass');
            $model->password_hash = $model->setPassword($this->getParams('default_pass'));
            $model->auth_key = $model->generateAuthKey();
        }elseif($type == $model::REQUEST_TYPE_TWO){
            $info = '修改状态成功';
            $model->status = $value;
        }else{
            $info = '删除成功';
            $model->status = $model::STATUS_DELETED;
        }
        if(!$model->save(false)){
            return $this->ajaxFail('操作失败,未知错误');
        }else{
            return $this->ajaxSuccess($info);
        }
    }
    /**
     *修改管理员角色
     */
    public function actionChangeManagerRole(){
        $post     = Yii::$app->request->post();
        $userId    = $post['userId'];
        $roleId    = $post['roleId'];

        //p($post);
        $model = (new User())->findOne($userId);
        if(is_null($model)){
            return $this->ajaxFail('操作失败.未找到管理员信息');
        }
        if($model->roleId == Role::TYPE_ONE){
            return $this->ajaxFail('操作失败,超级管理员无法操作');
        }
        $model->roleId = $roleId;
        if(!$model->save(false)){
            return $this->ajaxFail('操作失败,未知错误');
        }else{
            return $this->ajaxSuccess('修改成功');
        }
    }




}
