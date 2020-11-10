<?php
namespace app\modules\api\controllers;

use app\components\ApiController;
use Yii;
use app\models\User;
use app\models\LoginForm;
use app\models\LoginLog;
use app\common\SystemInfoWindows;
use app\common\wmi;

class SystemInfoController extends ApiController{
    public $modelClass = 'app\models\User';

    //获取服务器信息
    public function actionServerInfo(){
        $info = [
            [
                'name'=>'服务器IP',
                'value'=>$_SERVER['SERVER_ADDR'],
            ],
            [
                'name'=>'服务器域名',
                'value'=>$_SERVER['SERVER_NAME'],
            ],
            [
                'name'=>'服务器端口',
                'value'=>$_SERVER['SERVER_PORT'],
            ],
            [
                'name'=>'服务器版本',
                'value'=>php_uname(),
            ],
            [
                'name'=>'服务器操作系统',
                'value'=>php_uname('s').php_uname('r'),
            ],
            [
                'name'=>'PHP版本',
                'value'=>PHP_VERSION,
            ],
            [
                'name'=>'mysql版本',
                'value'=>1,//Yii::$app->db->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION)
            ],
        ];
        return $this->ajaxSuccess('获取成功',$info);
    }
}