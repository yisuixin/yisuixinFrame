<?php
namespace app\models\rbac;


use Yii;
use app\models\BaseModel;
use app\models\User;
class PagePermission extends BaseModel{
    const TYPE_ONE = 1;//整站权限
    const TYPE_TWO = 2;//栏目权限

    public $permissionList = [];

    public static function tableName(){
        return "{{%page_permission}}";
    }
    public function rules(){
        return [
            ['permissionList', 'validatePpermissionList','message'=>'账号或者密码错误'],
        ];
    }
    /**验证添加权限组时的数据格式
     * @param $attribute
     * @param $params
     */
    public function validatePpermissionList($attribute, $params){
        if (!$this->hasErrors()) {
            if (is_array($this->permissionList) && !empty($this->permissionList)) {
                foreach ($this->permissionList as $k => $v){
                    //验证权限名称
                    if($v['title'] == ''){
                        $this->addError($attribute, ($k + 1).'权限组名称不能为空.');
                    }
                    //验证权限组下的url
                    if(is_array($v['pagePermissionItem']) && !empty($v['pagePermissionItem']) ){
                        foreach ($v['pagePermissionItem'] as $kk => $vv){
                            if($vv['url'] == ''){
                                $this->addError($attribute, $v['title'].'权限组的第'.($kk + 1).'个权限url不能为空.');
                            }
                        }
                    }
                }
           }
        }
    }

    /**添加页面权限组
     * @param $data
     */
    public function addPagePermission($data){

    }

    public function getPermissionList($where=[]){
        $list = self::find()->where($where)->asArray()->all();
        return $list;
    }
    public function getPagePermissionItem(){
        return $this->hasMany(PagePermissionItem::className(),['page_permission_id'=>'id'])->asArray();
    }





}
