<?php
namespace app\models\log;

use Yii;
use yii\helpers\Url;
use app\models\BaseModel;
use app\models\log\SystemLog;


class AdminLog{
    // 日志表名称
    const DB_TABLE_LOG = 'system_log';
    /**
     * 修改操作.
     * @param obj $event
     * @return mixed
     */
    public static function write($event){
        // 排除日志表自身,没有主键的表不记录（没想到怎么记录。。每个表尽量都有主键吧，不一定非是自增id）
        if($event->sender instanceof \common\models\AdminLog || !$event->sender->primaryKey()) {
            return;
        }
        // 显示详情有待优化,不过基本功能完整齐全
        if ($event->name == ActiveRecord::EVENT_AFTER_INSERT) {
            $description = "%s新增了表%s %s:%s的%s";
        } elseif($event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
            $description = "%s修改了表%s %s:%s的%s";
        } else {
            $description = "%s删除了表%s %s:%s%s";
        }
        if (!emptyempty($event->changedAttributes)) {
            $desc = '';
            foreach($event->changedAttributes as $name => $value) {
                $desc .= $name . ' : ' . $value . '=>' . $event->sender->getAttribute($name) . ',';
            }
            $desc = substr($desc, 0, -1);
        } else {
            $desc = '';
        }
        $userName = Yii::$app->user->identity->username;
        $tableName = $event->sender->tableSchema->name;
        $description = sprintf($description, $userName, $tableName, $event->sender->primaryKey()[0], $event->sender->getPrimaryKey(), $desc);

        $route = Url::to();
        $userId = Yii::$app->user->id;
        $ip = ip2long(Yii::$app->request->userIP);
        $data = [
            'route' => $route,
            'description' => $description,
            'user_id' => $userId,
            'ip' => $ip
        ];
        $model = new common\models\AdminLog();
        $model->setAttributes($data);
        $model->save();
    }
}
