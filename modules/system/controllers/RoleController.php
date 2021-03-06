<?php
namespace app\modules\system\controllers;

use app\models\menu\Menu;
use app\models\rbac\PagePermissionItem;
use Yii;
use app\components\ApiController;
use app\common\lib\ModelHelper;
use app\models\rbac\PagePermission;
use app\models\rbac\RolePermissionItem;
use app\models\rbac\Role;
use app\models\rbac\RoleMenuItem;
use app\common\lib\Tree;
class RoleController extends ApiController{
    /**
     * 增加管理角色
     * @return int[]
     */
    public function actionAddRole(){
        $post     = Yii::$app->request->post();
        $is_add     = $post['is_add'];
        if($is_add == 1){
            $model = new Role();
            $model->setScenario('add_role');
            $info = '添加';
        }else{
            $id     = $post['id'];
            if($id == ''){
                return $this->ajaxFail('编辑失败,参数异常');
            }
            $model = (new Role())->findOne($id);
            if(is_null($model)){
                return $this->ajaxFail('编辑失败，未找到角色信息');
            }
            $model->setScenario('edit_role');
            $info = '编辑';
        }
        if($model->load($post,'') && $model->validate()){
            if(!$model->save(false)){
                return $this->ajaxFail($info.'失败,未知错误');
            }else{
                return $this->ajaxSuccess($info.'成功');
            }
        }else{
            return $this->ajaxFail($info.'失败.'.current($model->getErrors())[0]);
        }
    }
    /**
     *获取管理角色列表
     */
    public function actionGetRoleList(){
        $page      = $this->get('page', 0);
        $pageSize  = $this->get('pageSize', $this->getParams('default_page_size'));
        $keys  = $this->get('keys', '');
        $status  = $this->get('status', '');
        $offset    = ($page - 1) * $pageSize;
        $type= $this->get('type', '');

        $sql = (new Role())->find();
        $sql->andFilterWhere(['like','name','%'.$keys.'%',false]);
        $sql->orFilterWhere(['like','mark','%'.$keys.'%',false]);
        $sql->andFilterWhere(['=','type',$type]);
        $sql->andFilterWhere(['=','status',$status]);

        $d['count'] = (int)$sql->count();
        $d['list'] =  $sql->orderBy('id DESC,created_at DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->all();
        return $this->ajaxSuccess('获取成功',$d);
    }
    /**
     *获取所有的管理角色列表
     */
    public function actionGetRoleInfo(){
        $id  = $this->get('id', '');
        if($id == ''){
            return $this->ajaxFail('获取角色信息失败，参数异常');
        }
        $roleInfo = (new Role())->find()->where(['id'=>$id])->asArray()->one();
        if(is_null($roleInfo)){
            return $this->ajaxFail('获取失败，未找到角色信息');
        }

        return $this->ajaxSuccess('获取成功',$roleInfo);
    }
    //删除角色
    public function actionDeleteRole(){
        $post     = Yii::$app->request->post();
        $id     = $post['id'];
        if($id == ''){
            return $this->ajaxFail('删除失败,参数异常');
        }
        $model = (new Role())->findOne($id);
        if(is_null($model)){
            return $this->ajaxFail('删除失败，未找到角色信息');
        }
        if($model->type == $model::TYPE_ONE){
            return $this->ajaxFail('删除失败,超级管理员无法操作');
        }
        if($model->delete()){
            return $this->ajaxSuccess('删除成功');
        }else{
            return $this->ajaxFail('删除失败.'.current($model->getErrors())[0]);
        }
    }
    /**
     * 为角色添加权限列表
     */
    public function actionAddRolePermission(){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $post   = Yii::$app->request->post();
            $items  = $post['permissionsData'];
            $roleId =  $post['roleId'];
            $menuItems = $items['menuIdItems'];
            if(empty($menuItems)){
                return $this->ajaxFail('添加失败，请先选择权限.');
            }
            $roleInfo = (new Role())->findOne(['id'=>$roleId]);
            if(is_null($roleInfo)){
                return $this->ajaxFail('添加失败，未找到用户角色信息.');
            }
            //处理所有的菜单id
            $allMenuIds = [];
            foreach ($menuItems as $k=>$v){
                foreach ($v as $kk => $vv){
                    array_push($allMenuIds,$vv);
                }
            }
            $allMenuIds = array_unique($allMenuIds);
            //处理所有的菜单id数组，然后批量插入数据库
            $roleMenuRows =  [];
            foreach ($allMenuIds as $k=>$v){
                $roleMenuRows[$k]['menu_id'] = $v;
                $roleMenuRows[$k]['role_id'] = $roleId;
            }

//            $roleMenuRows =  [];
//            foreach ($allMenuIds as $k=>$v){
//                $roleMenuRows[$k]['menu_id'] = $v;
//                $roleMenuRows[$k]['role_id'] = $roleId;
//            }

            //处理所有的权限数组，然后批量插入数据库
            $permissionItems = $items['permissionItems'];
            foreach ($permissionItems as $k => $v){
                    $permissionRows[$k]['page_permission_id'] = $v;
                    $permissionRows[$k]['role_id'] = $roleId;
            }
            //批量插入之前，先删除数据库之前的数据
            RolePermissionItem::deleteAll('role_id = :roleId', [':roleId' => $roleId]);//删除当前角色的菜单的id
            RoleMenuItem::deleteAll('role_id = :roleId', [':roleId' => $roleId]);//删除当前角色的权限的url
            if(ModelHelper::saveAll(RoleMenuItem::tableName(), $roleMenuRows) && ModelHelper::saveAll(RolePermissionItem::tableName(), $permissionRows)){
                $transaction->commit();
                return $this->ajaxSuccess('添加成功');
            }
            $transaction->rollBack();
            return $this->ajaxFail('添加失败，未知错误.');
        }catch (Exception $e) {
            $transaction->rollBack();
            return $this->ajaxFail('添加失败,服务器异常');
        }
    }
}
