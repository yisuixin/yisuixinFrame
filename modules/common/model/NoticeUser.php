<?php
namespace app\modules\common\v1\model;

use app\models\BaseModel;


class NoticeUser extends BaseModel{
    const NOTICE_STATUS_ONE = 1;const NOTICE_STATUS_TWO = 2;//用户通知状态，1未读，2已读
    //表名
    public static function tableName(){
        return "{{%notice_user}}";
    }
    public function getMenuList(){
        return $this->hasOne(Menu::className(),['id'=>'menu_id'])->select('id,parent_id,icon,name,title,href')->asArray();
    }


}