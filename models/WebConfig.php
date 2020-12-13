<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\BaseModel;

class WebConfig extends BaseModel{
    public $configData;
    const TYPE_ONE = 1;const TYPE_TWO = 2;//1获取月的事项，2获取周的事项，3获取天的事项

    //表名
    public static function tableName(){
        return "{{%web_config}}";
    }
//    public function scenarios(){
//        $s = parent::scenarios();
//        $s['edit_config'] = ['type','configData'];
//        return $s;
//    }
//    //规则
//    public function rules(){
//        return [
//            [['type'], 'required', 'message' => '配置类型不能为空','on'=>['edit_config']],
//            [['configData'], 'required', 'message' => '配置参数不能为空','on'=>['edit_config']],
//        ];
//    }




}