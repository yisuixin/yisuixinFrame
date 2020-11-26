<?php
namespace app\models\rbac;

use Yii;
use app\models\BaseModel;
use app\models\User;
class PagePermissionItem extends BaseModel{
    const TYPE_ONE = 1;//整站权限
    const TYPE_TWO = 2;//栏目权限

    public static function tableName(){
        return "{{%page_permission_item}}";
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
    /**添加权限组url
     * @param $data
     */
    public function addPageMissionItem($pageMissionId,$arr=[]){
        $data = [];
        foreach ($arr as $k =>$v){
            $data[$k]['page_permission_id'] = $pageMissionId;
            $data[$k]['title'] =  $v['title'];
            $data[$k]['url']   = $v['url'];
        }

        return Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['page_permission_id','title','url'], $data)->execute();
    }









}
