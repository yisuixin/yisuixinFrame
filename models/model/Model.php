<?php
namespace app\models\model;

use Yii;
use yii\db\ActiveRecord;
use app\models\BaseModel;

class Model extends BaseModel{
    const STATUS_ONE = 1;const STATUS_TWO = 2;//1启用，2禁用

    public static function tableName(){
        return "{{%model}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['add_model']  = ['name','desc','table_name','status','created_at','updated_at'];
        $s['edit_model'] = ['name','desc','table_name','status','created_at','updated_at'];
        return $s;
    }
    //规则
    public function rules(){
        return [
            [['name'], 'required', 'message' => '模型名称不能为空','on'=>['add_model','edit_model']],
            [['table_name'], 'required', 'message' => '模型标识不能为空','on'=>['add_model','edit_model']],
            ['name', 'string', 'max'=>10, 'message' => '模型名称最多10个字符','on'=>['add_model','edit_model']],
            ['table_name', 'string', 'max'=>20, 'message' => '模型标识最多20个字符','on'=>['add_model','edit_model']],
            ['desc', 'string', 'max'=>30, 'message' => '模型描述最多30个字符','on'=>['add_model','edit_model']],
        ];
    }




}