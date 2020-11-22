<?php
namespace app\modules\system\controllers;



use yii;
use app\components\ApiController;
use app\models\menu\menu;
use app\common\lib\Tree;
use app\models\User;
use app\models\rbac\PermissionItem;
use app\models\rbac\RolePermissionItem;
use app\models\rbac\PagePermission;
use app\common\lib\ModelHelper;

class MenuController extends ApiController{
    /**
     * 菜单列表
     * @return array
     */
    public function actionList(){
        $list = (new menu())->getListMenu();
        return $this->ajaxSuccess('获取成功',$list);
    }
    /**
     * 角色管理页面展示所有的菜单列表
     * @return array
     */
    public function actionGetRoleMenuList(){
        $id     = $this->get('roleId','');
        if($id == ''){
            return $this->ajaxFail('获取失败,参数异常');
        }
        $where['roleId'] = $id;
        $roleMenuList = (new PermissionItem())->getPermissionList($where);//角色拥有的菜单列表
        $list = (new menu())->find()->orderBy('sort ASC')->select('id,title,parent_id')->asArray()->all();//所有的菜单列表
        $getRoleMenuListTree = menu::getRoleMenuListTree($list,$roleMenuList);
        $res = Tree::manyArray($getRoleMenuListTree,$pid = 0,'parent_id','id');
        //p($res);
        return $this->ajaxSuccess('获取成功',$res);
    }
    /**
     * 获取单条菜单数据
     * @return array
     */
    public function actionGetOnlyMenu(){
        $id     = $this->get('id','');
        if($id == ''){
            return $this->ajaxFail('获取失败,参数异常');
        }
        $data = (new Menu())->find()->where(['id'=>$id])->asArray()->one();
        return $this->ajaxSuccess('获取成功',$data);
    }
    /**
     * 增加或者菜单
     * @return array
     */
    public function actionAddOrEdit(){
        $post     = Yii::$app->request->post();
        $is_add     = $post['is_add'];
        if($is_add == 1){
            $model = new menu();
            $model->setScenario('add_menu');
            $info = '添加';
        }else{
            $id     = $post['id'];
            if($id == ''){
                return $this->ajaxFail('编辑失败,参数异常');
            }
            $model = (new menu())->findOne($id);
            if(is_null($model)){
                return $this->ajaxFail('编辑失败，未找到菜单信息');
            }
            $model->setScenario('edit_menu');
            $info = '编辑';
        }
        //查找父级菜单信息
        $parent_id = $this->post('parent_id',0);
        if($parent_id != 0){
            $parent = (new Menu())->findOne($parent_id);
            if(is_null($parent)){
                return $this->ajaxFail($info.'失败,未找到菜单父级信息');
            }
            $post['template'] = $parent->template.'/'.$post['href'];
            $model->setMenuLevel($parent->level);
        }else{
            $post['template'] = $post['href'];
            $model->setMenuLevel(0);
        }
        //添加数据
        $post['name'] = $this->post('href');
        if($post['type'] == Menu::MENU_TYPE1){//如果是添加页面菜单，则在page_permisson增加数据默认数据

        }
        if($model->load($post,'') && $model->validate()){
            if(!$model->save(false)){
                return $this->ajaxFail($info.'失败,未知错误',$model->attributes);
            }else{
                return $this->ajaxSuccess($info.'成功',['id'=>$model->attributes['id']]);
            }
        }else{
            return $this->ajaxFail($info.'失败.'.current($model->getErrors())[0]);
        }
    }
    //删除菜单
    public function actionDeleteMenu(){
        $post     = Yii::$app->request->post();
        $id     = $post['id'];
        if($id == ''){
            return $this->ajaxFail('删除失败,参数异常');
        }
        $model = (new Menu())->findOne($id);
        if(is_null($model)){
            return $this->ajaxFail('删除失败，未找到菜单信息');
        }
        //查找是否有子集
        $parent = (new Menu())->findOne(['parent_id'=>$id]);

        if(!is_null($parent)){
            return $this->ajaxFail('删除失败,该菜单下有子菜单，请先删除子菜单之后再删除');
        }
        if($model->delete()){
            return $this->ajaxSuccess('删除成功');
        }else{
            return $this->ajaxFail('删除失败.'.current($model->getErrors())[0]);
        }
    }
    /**
     * 点击菜单排序
     */
    public function actionSortMenu(){
        $id =  $this->post('id','');
        $sortVal =  $this->post('sortVal',1);

        if($id == ''){
            return $this->ajaxFail('排序失败，参数异常.');
        }
        $menu = (new Menu())->findOne($id);
        if(is_null($menu)){
            return $this->ajaxFail('排序失败，未找到菜单信息.');
        }
        $menu->sort = $sortVal;
        if($menu->save()){
            return $this->ajaxSuccess('排序成功');
        }
        return $this->ajaxFail('排序失败，未知错误');
    }
    /**
     * 添加页面权限
     */
    public function actionAddPagePermission(){
        $post     = Yii::$app->request->post();
        $menuId   = $post['menuId'];
        $data     = $post['data'];
//        p($data);
        if($menuId == '' || !is_array($data) || empty($data)){
            return $this->ajaxFail('保存失败,参数异常');
        }
        $model = (new Menu())->findOne($menuId);
        if(is_null($model)){
            return $this->ajaxFail('保存失败，未找到菜单信息');
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $pagePermission = (new PagePermission());
            //添加之前先清空菜单权限
            $deletePagemission = $pagePermission->deleteAll(['menuId'=>$menuId]);
            $row = [];
            foreach($data as $k => $v){
                $row[$k]['menuId'] = $menuId;
                $row[$k]['url'] = $v['url'];
                $row[$k]['title'] = $v['title'];
                $row[$k]['created_at'] = time();
                $row[$k]['updated_at'] = time();
            }
            $res = ModelHelper::saveAll('page_permission',$row);
            if($res){
                $transaction->commit();
                return $this->ajaxSuccess('保存成功');
            }else{
                $transaction->rollBack();
                return $this->ajaxFail('保存失败.'.current($model->getErrors())[0]);
            }
        }catch (Exception $e) {
            $transaction->rollBack();
            return $this->ajaxFail('保存失败,未知错误');
        }
    }
    /**
     * 获取页面权限列表
     * @return array
     */
    public function actionGetPagePermissionList(){
        $get     = Yii::$app->request->get();
        $menuId   = $get['menuId'];
        if($menuId == ''){
            return $this->ajaxFail('获取失败,参数异常');
        }
        $model = (new Menu())->findOne($menuId);
        if(is_null($model)){
            return $this->ajaxFail('获取失败，未找到菜单信息');
        }
        $list = PagePermission::find()->where(['menuId'=>$menuId])->with('pagePermissionItem')->asArray()->all();
        return $this->ajaxSuccess('获取成功',$list);
    }
    /**
     * 获取页面权限列表
     * @return array
     */
    public function actionGetRolePagePermissionList(){
        $get     = Yii::$app->request->get();
        $roleId = $get['roleId'];
        if($roleId == ''){
            return $this->ajaxFail('获取失败,参数异常');
        }
        $list =  (new Menu())->getRolePagePermissionList();//获取用户所拥有的权限组url的id
        $rolePermissionItem   = (new RolePermissionItem())->getPermissionList(['role_id'=>$roleId]);//获取用户所拥有的权限的url
        $rolePermissionItemUrl = array_column($rolePermissionItem,'url');

        foreach ($list as $k=>$v){//去除没有的
            if(!empty($v['pagePermissionList'])){
                foreach ($v['pagePermissionList'] as $kk => $vv){
                    if(in_array($vv['url'],$rolePermissionItemUrl)){
                        $list[$k]['pagePermissionList'][$kk]['checked'] = true;
                    }else{
                        $list[$k]['pagePermissionList'][$kk]['checked'] = false;
                    }
                }
            }
        }
        return $this->ajaxSuccess('获取成功',$list);
    }
}
