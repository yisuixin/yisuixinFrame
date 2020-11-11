<?php

namespace app\modules\rabc\model;

use Yii;
use app\models\BaseModel;
use app\models\User;
class PagePermission extends BaseModel{
    const TYPE_ONE = 1;//整站权限
    const TYPE_TWO = 2;//栏目权限

    public static function tableName(){
        return "{{%page_permission}}";
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
    public function getPagePermissionItem(){
        return $this->hasMany(PagePermissionItem::className(),['page_permission_id'=>'id'])->asArray();
    }





}
