<?php

namespace app\modules\rabc\model;

use Yii;
use app\models\BaseModel;
class RolePermissionItem extends BaseModel{
    const LOGIN_LOG = 1;//登录日志
    const TYPE_ONE = 1;//1超级管理员
    const TYPE_TWO = 2;//2其它管理员
    public static function tableName(){
        return "{{%role_permission_item}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['add_role']  = ['name','mark','status'];
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

}
