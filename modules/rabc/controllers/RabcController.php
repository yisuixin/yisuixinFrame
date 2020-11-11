<?php

namespace app\modules\rabc\controllers;

use app\modules\rabc\model\Role;
use Yii;
use app\components\ApiController;
use app\models\User;
use yii\db\Query;
class RabcController extends ApiController{

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
    public function actionGetUserList(){
        $page      = $this->get('page', 0);
        $pageSize  = $this->get('pageSize', $this->getParams('default_page_size'));
        $offset    = ($page - 1) * $pageSize;

        $keys  = $this->get('keys', '');
        $status  = $this->get('status', '');


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
        $sql->leftJoin(Role::tableName(), 'role.id = user.role');
        $sql->andWhere(['<>','user.status',User::STATUS_DELETED]);
        $sql->andFilterWhere(['like','username','%'.$keys.'%',false]);
        $sql->orFilterWhere(['like','nickname','%'.$keys.'%',false]);
        $sql->orFilterWhere(['like','user.mark','%'.$keys.'%',false]);
        $sql->andFilterWhere(['=','user.status',$status]);




        $d['count'] = (int)$sql->count();
        $d['list'] =  $sql->orderBy('user.created_at DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->all();

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
        if($model->role == Role::TYPE_ONE){
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




}
