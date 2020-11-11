<?php
namespace app\modules\common\v1\model;

use app\modules\rabc\model\Menu;
use Yii;
use app\models\BaseModel;
use app\common\lib\Tree;
use app\common\lib\File;
use app\modules\rabc\model\Role;
use yii\db\Expression;


class QuickOperation extends BaseModel{

    //表名
    public static function tableName(){
        return "{{%quick_operation}}";
    }
    public function getMenuList(){
        return $this->hasOne(Menu::className(),['id'=>'menu_id'])->select('id,parent_id,icon,name,title,href')->asArray();
    }


}