<?php
namespace app\models\systemModel;

use Yii;
use app\models\BaseModel;

class ModelsList extends BaseModel{


    const STATUS_ONE = 1;const STATUS_TWO = 2;//状态。1启用，2禁用
    //表名
    public static function tableName(){
        return "{{%modules}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['add_todo']  = ['type','title','desc','start','end','user_id','status'];
        $s['edit_todo'] = ['type','title','desc','start','end','user_id','id','status'];
        return $s;
    }
     public function getModelList(){
        $list = $this->find()->select('name,status')->where(['status'=>self::STATUS_ONE])->asArray()->all();

        foreach ($list as $k => $v){
            $modules[$v['name']]['class'] =  'app\modules\\'.$v['name'].'\\Module';
        }

         Yii::configure(Yii::$app, [
                 'modules' => $modules
             ]
         );
        //return $modules;
     }




}