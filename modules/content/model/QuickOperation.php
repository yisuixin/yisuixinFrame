<?php
namespace app\modules\common\v1\model;


use Yii;
use app\models\BaseModel;
use app\models\menu\Menu;

class QuickOperation extends BaseModel{

    //表名
    public static function tableName(){
        return "{{%quick_operation}}";
    }
    public function getMenuList(){
        return $this->hasOne(Menu::className(),['id'=>'menu_id'])->select('id,parent_id,icon,name,title,href')->asArray();
    }


}