<?php
namespace app\modules\common\v1\controllers;


use app\common\lib\ModelHelper;
use app\common\lib\Tree;
use app\components\ApiController;
use app\models\menu\Menu;
use app\models\rbac\Role;
use app\models\rbac\RoleMenuItem;
use Yii;
use app\modules\common\V1\model\QuickOperation;
use yii\db\Query;

class QuickOperationController extends ApiController{
    /**
     * 获取登录用户快捷操作列表
     */
    public function actionGetQuickList(){
        $page      = $this->get('page', 0);
        $pageSize  = $this->get('pageSize', $this->getParams('default_page_size'));
        $offset    = ($page - 1) * $pageSize;
        $sql = (new QuickOperation())->find()->where(['user_id'=>$this->uId]);

        $d['count'] = (int)$sql->count();
        $d['list'] =  $sql->orderBy('created_at DESC')
            ->with('menuList')
            ->limit($pageSize)
            ->offset($offset)
            ->asArray()
            ->all();
        //p($d);
        //$this->printSql($sql);
        return $this->ajaxSuccess('获取成功',$d);
    }
    /**
     * 获取快捷操作菜单列表
     * @return array
     */
    public function actionGetUserMenuList(){
        $user = $this->user;
        if($user->role ==  Role::TYPE_ONE){//超级管理员，直接返回全部的菜单和路由列表
            $list = (new menu())->find()->where(['status'=>menu::MENU_STATUS1,'type'=>Menu::MENU_TYPE1])->orderBy('sort ASC')->asArray()->all();
        }else{//不是超级管理员的话，先去查询permission_item表中有哪些权限，再返回
            $where['role_id'] = $user->role;
            $subQuery = RoleMenuItem::find()->where($where);
            $list = (new Query())->from(['roleMenuItems' => $subQuery])->andwhere(['type'=>Menu::MENU_TYPE1]) // 在这里使用了子查询
            ->leftJoin(['menu' => Menu::tableName()], 'roleMenuItems.menu_id = menu.id')
                ->createCommand()
                ->queryAll();
        }
        $allMenuList = (new menu())->find()
            ->select('id,parent_id,title,type,icon')
            ->orderBy('sort ASC')
            ->asArray()->all();

        $userQuickItem =  (new QuickOperation())->find()->where(['user_id'=>$user->id])->select('menu_id')->asArray()->all();
        $d['userQuickItem'] =  array_column($userQuickItem,'menu_id');
        foreach ($list as $k=>$v){//去除没有的
            $all_parent_title =  Tree::getMenuColumns($allMenuList,$v['id'],'parent_id','id','title');
            $list[$k]['all_parent_title'] = implode(' / ',$all_parent_title);
        }
        $d['list'] = $list;
        //p($list);
        return $this->ajaxSuccess('获取成功',$d);
    }
    /**
     * 为用户增加快捷操作
     */
    public function actionAddQuick(){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $post   = Yii::$app->request->post();
            $menuIds  = $post['menuIds'];
            $user_id =  $this->uId;

            //处理所有的菜单id数组，然后批量插入数据库
            $roleMenuRows =  [];
            foreach ($menuIds as $k=>$v){
                $roleMenuRows[$k]['menu_id'] = $v;
                $roleMenuRows[$k]['user_id'] = $user_id;
                $roleMenuRows[$k]['created_at'] = time();
                $roleMenuRows[$k]['updated_at'] = time();
            }

            //批量插入之前，先删除数据库之前的数据
            QuickOperation::deleteAll('user_id = :user_id', [':user_id' => $user_id]);
            if (!ModelHelper::saveAll(QuickOperation::tableName(), $roleMenuRows)) {
                $transaction->rollBack();
                return $this->ajaxFail('添加失败，未知错误.');
            }
            $transaction->commit();
            return $this->ajaxSuccess('添加成功');
        }catch (Exception $e) {
            $transaction->rollBack();
            return $this->ajaxFail('添加失败,服务器异常');
        }
    }
}