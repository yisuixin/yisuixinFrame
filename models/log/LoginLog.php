<?php
namespace app\models\log;

use Yii;
use app\models\BaseModel;
//username、password、desc、ip、login_time
class LoginLog extends BaseModel{
    const LOGIN_LOG = 1;//登录日志
    public static function tableName(){
        return "{{%login_log}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['add_login_log']  = ['type','url','desc','title','ip'];
        return $s;
    }
    public function rules(){
        return [
            [['type','url', 'title','desc', 'ip'], 'required','on'=>['add_login_log']],
        ];
    }
    public function addLog($setScenario,$type,$title,$desc){
        $this->setScenario($setScenario);
        $this->uId    =  Yii::$app->user->identity->id;
        $this->type   = $type;
        $this->url    = Yii::$app->request->getHostInfo().Yii::$app->request->url;//Yii::$app->request->getHostInfo().Yii::$app->request->url;
        $this->title  = $title;
        $this->desc   = serialize($desc);
        $this->ip     = getIPaddress();
        if ($this->validate() && $this->save()) {
               return true;
        }
        return false;
    }
}
