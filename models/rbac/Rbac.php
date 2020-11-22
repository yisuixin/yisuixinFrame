<?php
namespace app\models\rbac;

use app\common\lib\File;
use app\common\lib\Tree;
use app\modules\rabc\model\RolePermissionItem;
use Yii;
use app\models\BaseModel;
use yii\db\Expression;
use yii\db\Query;
use app\models\menu\Menu;

class Rbac extends BaseModel{
    const MENU_TYPE1 = 1;const MENU_TYPE2 = 2;//菜单类型1页面2菜单；
    const MENU_LEVEL1 = 1;const MENU_LEVEL2 = 2;const MENU_LEVEL3 = 3;//菜单等级；1一级菜单，2二级菜单，3三级菜单
    const MENU_STATUS1 = 1;const MENU_STATUS2 = 2;//菜单状态；1显示2隐藏
    const CREATE_TAMPLATE_ONE = 1;const CREATE_TAMPLATE_TWO = 2;//是否生成前端模板，1是，2否

    /**
     * 获取全部导航菜单列表
     */
    public static function getLayoutMenu($user){
        if(is_null($user)){
            $d['menuList'] = [];
            $d['vueRoute'] = [];
        }else{
            if($user->role ==  Role::TYPE_ONE){//超级管理员，直接返回全部的菜单和路由列表
                $list = (new menu())->find()->where(['status'=>self::MENU_STATUS1])->orderBy('sort ASC')->asArray()->all();
                $data = Tree::manyArray($list,$pid = 0,'parent_id','id');
                $d['menuList'] = $data;
                $d['vueRoute'] = self::getVueRoute($list);
            }else{//不是超级管理员的话，先去查询permission_item表中有哪些权限，再返回
                $where['role_id'] = $user->role;
                $permissionMenuList = self::getPermissionMenu($where);
                $d['menuList'] = $permissionMenuList['menuList'];
                $d['vueRoute'] = $permissionMenuList['vueRoute'];
            }
        }
        return $d;
    }
    /**
     * 根据所拥有的权限获取菜单
     */
    public static function getPermissionMenu($where = []){
        //获取角色所拥有的菜单
        $subQuery = RoleMenuItem::find()->where($where);
        $list = (new Query())->from(['roleMenuItems' => $subQuery]) // 在这里使用了子查询
            ->leftJoin(['menu' => Menu::tableName()], 'roleMenuItems.menu_id = menu.id')
            ->createCommand()
            ->queryAll();
        if(empty($list)){
            $data['menuList'] =  [];
            $data['vueRoute'] =  [];
            return $data;
        }
        $data['menuList'] =  Tree::manyArray($list,$pid = 0,'parent_id','id');
        $data['vueRoute'] =  self::getVueRoute($list);
        return $data;
    }
    /**获取菜单列表，组装前端vue路由列表
     * @return
     */
    public static function getVueRoute($cate){
        $arr = [];
        $index = 0;
        foreach ($cate as $k => $v) {
            if($v['type'] == self::MENU_TYPE1){
                $arr[$index]['path'] = '/'.$v['href'];
                $arr[$index]['name'] = $v['href'];
                $arr[$index]['component'] = $v['template'];
                $arr[$index]['meta']['needLogin'] = true;
                $arr[$index]['meta']['keepAlive'] = true;
                $arr[$index]['meta']['title'] = $v['title'];
                $index++;
            }

        }
        return $arr;
    }
    /**
     * 获取用户角色拥有的全部权限url
     */
    public static function getRoleUrlPermission($user){
        if($user->role ==  Role::TYPE_ONE){//超级管理员，直接返回true
            return true;
        }else{
            $permissionList = (new RolePermissionItem())->find()->where(['role_id'=>$user->role])->asArray()->all();
            $permissionUrl  = array_column($permissionList, 'url');
            return $permissionUrl;
        }
    }
    /**
     * 获取用户是否对请求的url有权限
     */
    public static function validationRolePermission($user,$url){
        $permissionList = self::getRoleUrlPermission($user);
        if (in_array($url, $permissionList)){
            return true;
        }
        return false;
    }



}
