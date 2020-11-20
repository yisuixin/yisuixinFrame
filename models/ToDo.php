<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\BaseModel;

class ToDo extends BaseModel{
    public $type;
    const TO_DO_TYPE_ONE = 1;const TO_DO_TYPE_TWO = 2;const TO_DO_TYPE_THREE = 3;//1获取月的事项，2获取周的事项，3获取天的事项
    const TO_DO_STATUS_ONE = 1;const TO_DO_STATUS_TWO = 2;const TO_DO_STATUS_THIRD = 3;const TO_DO_STATUS_FOUR = 4;//待办状态。1未开始，2进行中，3已完成，4已过期
    //表名
    public static function tableName(){
        return "{{%todo}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['add_todo']  = ['type','title','desc','start','end','user_id','status'];
        $s['edit_todo'] = ['type','title','desc','start','end','user_id','id','status'];
        return $s;
    }
    //规则
    public function rules(){
        return [
            [['user_id'], 'required', 'message' => '待办事项用户参数异常','on'=>['add_todo','edit_todo']],
            [['title'], 'required', 'message' => '待办事项标题不能为空','on'=>['add_todo','edit_todo']],
            [['desc'], 'required', 'message' => '待办事项描述不能为空','on'=>['add_todo','edit_todo']],
            [['start'], 'required', 'message' => '待办事项开始时间不能为空','on'=>['add_todo','edit_todo']],
            [['end'], 'required', 'message' => '待办事项完成时间不能为空','on'=>['add_todo','edit_todo']],
            [['id'], 'required', 'message' => '待办事项ID不能为空','on'=>['edit_todo']],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'id' => 'ID',
            'type' => 'Type',
            'desc' => '所属模型',
            'date' => 'Domain',
            'completed' => '所属父级',
            'status' => '所属父级',
        ];
    }



}