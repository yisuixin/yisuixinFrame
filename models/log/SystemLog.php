<?php

namespace app\models\log;

use app\models\User;
use Yii;
use app\models\BaseModel;

class SystemLog extends BaseModel{

    public static function tableName(){
        return '{{%system_log}}';
    }

    public function scenarios(){
        $s = parent::scenarios();
        $s['add_log']  = ['user_id','url','desc', 'ip','status'];
        return $s;
    }
    public function rules(){
        return [
            [['user_id','url','desc', 'ip','status'], 'required','on'=>['add_log']],
        ];
    }
    //添加操作日志
    public function addLog($data = []){
        if(!empty($data)){
            $this->setScenario('add_log');
            $this->user_id =  Yii::$app->user->identity->id;
            $this->url     = $data['url'];
            $this->desc    = serialize(['message'=>$data['message'],'model'=>$data['model'],'controller'=>$data['controller'],'action'=>$data['action'],'type'=>$data['type']]);
            $this->status  = $data['status'];
            $this->ip     = getIPaddress();
            if ($this->validate()) {
                $this->save();
            }
        }
    }
    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id'])->select('id,username,nickname,avatar,email')->asArray();
    }
}
