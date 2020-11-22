<?php
namespace app\modules\system\controllers;



use Yii;
use app\components\ApiController;
use app\models\log\Log;

class LoginLogController extends ApiController{
    public $modelClass = 'app\models\log';

    public function actionList(){
        $page = $this->get('page', 0);
        $type = $this->get('type', '');
        if ($type == '') {
            return $this->ajaxFail('获取日志失败,参数异常');
        }
        $pageSize = $this->get('pageSize', $this->getParams('default_page_size'));
        $searchKey = $this->get('searchKey', '');
        $startTime = $this->get('startTime', '');
        $endTime = $this->get('endTime', '');
        $offset = ($page - 1) * $pageSize;

        $sql = (new Log())->find();
        $sql->where(['type' => $type]);
        $sql->andFilterWhere(['or',
            ['like', 'title', $searchKey],
            ['like', 'desc', $searchKey]
        ]);
        $sql->andFilterWhere(['like', 'title', $searchKey]);
        if ($startTime != '' && $endTime != '') {
            $time = selectDate($startTime, $endTime);
            $sql->andWhere(['between', 'created_at', $time['start_time'], $time['end_time']]);
        }
//        p($sql->createCommand()->getSql());
        $d['count'] = (int)$sql->count();
        $list = $sql->orderBy('created_at DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->all();
        foreach ($list as $k => $v) {
            $list[$k]['desc'] = unserialize($v['desc']);
        }
        $d['list'] = $list;
        return $this->ajaxSuccess('获取成功', $d);
    }

}
