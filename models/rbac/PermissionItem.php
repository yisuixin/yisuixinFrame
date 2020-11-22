<?php
namespace app\models\rbac;

use Yii;
use app\models\BaseModel;
use app\models\User;
class PermissionItem extends BaseModel{
    const TYPE_ONE = 1;//整站权限
    const TYPE_TWO = 2;//栏目权限

    public static function tableName(){
        return "{{%permission_item}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['add_role']  = ['roleId','menuId','type'];
        $s['edit_role']  = ['id','name','mark','status'];
        return $s;
    }
    public function rules(){
        return [
            [['id'], 'required','message'=>'角色ID不能为空','on'=>['edit_role']],
            [['name'], 'required','message'=>'角色名称不能为空','on'=>['add_role','edit_role']],
            ['name', 'string', 'max'=>8, 'message' => '角色名称最多8个字符','on'=>['add_role','edit_role']],
            ['mark', 'string', 'max'=>30, 'message' => '角色描述最多30个字符','on'=>['add_role','edit_role']],
        ];
    }

    public function getPermissionList($where=[]){
        $list = self::find()->where($where)->asArray()->all();
        return $list;
    }

    public function validateUserPermission($user,$url){
        $where['roleId'] = $user->role;

        if($user->role == Yii::$app->params['admin_user_role_id']){
            return true;
        }
        $permissionList = self::getPermissionList($where);
        $permissionUrl = array_column($permissionList, 'url');
        $no_login_url = Yii::$app->params['no_login_url'];

        $validatePermissionList = array_merge($permissionUrl,$no_login_url);

        if (in_array($url, $validatePermissionList)){
            return true;
        }
        return false;
    }





}
