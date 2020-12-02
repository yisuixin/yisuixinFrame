<?php
namespace app\modules\system\controllers;



use app\models\User;
use Yii;
use app\components\ApiController;
use app\models\log\SystemLog;

class OperationLogController extends ApiController{
    public function actionList(){
        $page = $this->get('page', 0);
        $pageSize = $this->get('pageSize', $this->getParams('default_page_size'));
        $searchKey = $this->get('searchKey', '');

        $status = $this->get('status', '');
        $startTime = $this->get('startTime', '');
        $endTime = $this->get('endTime', '');
        $offset = ($page - 1) * $pageSize;

        $sql = (new SystemLog())->find();
        $sql->with('user');
        $sql->filterWhere([SystemLog::tableName().'.status' => $status]);
        $sql->andFilterWhere(['or',
            ['like', 'url', $searchKey],
            ['like', 'desc', $searchKey]
        ]);
        if ($startTime != '' && $endTime != '') {
            $time = selectDate($startTime, $endTime);
            $sql->andWhere(['between', 'created_at', $time['start_time'], $time['end_time']]);
        }

        $d['count'] = (int)$sql->count();
        $list = $sql->orderBy('created_at DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->asArray()
            ->all();
        foreach ($list as $k => $v) {
            $list[$k]['desc'] = unserialize($v['desc']);
        }
        $d['list'] = $list;
        return $this->ajaxSuccess('获取成功', $d);
    }
    //删除日志
    public function actionDel(){
        $post     = Yii::$app->request->post();
        $id     = $post['id'];
        if($id == ''){
            return $this->ajaxFail('删除失败,参数异常');
        }
        $model = (new SystemLog())->findOne($id);
        if(is_null($model)){
            return $this->ajaxFail('删除失败，未找到日志信息');
        }
        if($model->delete()){
            return $this->ajaxSuccess('删除成功');
        }else{
            return $this->ajaxFail('删除失败.'.current($model->getErrors())[0]);
        }
    }

}
