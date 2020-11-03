<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\BaseModel;

class ToDo extends BaseModel{
    public $type;
    const TO_DO_TYPE_ONE = 1;const TO_DO_TYPE_TWO = 2;const TO_DO_TYPE_THREE = 3;const TO_DO_TYPE_FOUR = 4;//1获取今日待办，2获取全部待办，3获取已经完成的待办，4获取指定日期的待办
    const TO_DO_STATUS_ONE = 1;const TO_DO_STATUS_TWO = 2;//待办状态。1已完成，2进行中
    //表名
    public static function tableName(){
        return "{{%todo}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['add_todo']  = ['type','desc','date','user_id','completed','status'];
        $s['edit_todo'] = ['type','desc','date','user_id','completed','id','status'];
        return $s;
    }
    //规则
    public function rules(){
        return [
            [['user_id'], 'required', 'message' => '待办事项用户参数异常','on'=>['add_todo','edit_todo']],
            [['desc'], 'required', 'message' => '待办事项描述不能为空','on'=>['add_todo','edit_todo']],
            [['date'], 'required', 'message' => '待办事项完成时间不能为空','on'=>['add_todo','edit_todo']],
            [['id'], 'required', 'message' => '待办事项ID不能为空','on'=>['edit_todo']],
            [['completed'], 'required', 'message' => '待办事项完成度不能为空','on'=>['add_todo','edit_todo']],
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