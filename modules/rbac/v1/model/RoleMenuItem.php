<?php

namespace app\modules\rabc\model;

use Yii;
use app\models\BaseModel;
class RoleMenuItem extends BaseModel{

    public static function tableName(){
        return "{{%role_menu_item}}";
    }

    public function getPermissionList($where=[]){
        $list = self::find()->where($where)->asArray()->all();
        return $list;
    }
    public function getMenuList(){
        return $this->hasOne(Menu::className(),['id'=>'menu_id'])->asArray();
    }

}
