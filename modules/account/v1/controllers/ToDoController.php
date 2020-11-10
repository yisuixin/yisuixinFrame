<?php
namespace app\modules\api\controllers;

use app\components\ApiController;
use Yii;
use app\models\ToDo;


class ToDoController extends ApiController{
    public $modelClass = 'app\models\ToDo';

    //获取待办事项列表
    public function actionGetToDoList(){
        $page      = $this->get('page', 0);
        $pageSize  = $this->get('pageSize', $this->getParams('default_page_size'));
        $offset    = ($page - 1) * $pageSize;
        $type      = $this->get('type', 2);//1获取今日待办，2获取全部待办，3获取已经完成的待办
        $date      = $this->get('date', '');

        $sql = (new ToDo())->find()->where(['user_id'=>$this->uId]);

        if($type == ToDo::TO_DO_TYPE_ONE){//获取今日待办
            $start = strtotime(date('Y-m-d')." 00:00:00");
            $end   = strtotime(date('Y-m-d')." 23:59:59");
            $sql->andWhere(['between','date',$start,$end]);
        }elseif ($type == ToDo::TO_DO_TYPE_THREE){//获取已完成的待办
            $sql->andWhere(['status'=>ToDo::TO_DO_STATUS_ONE]);
        }elseif ($type == ToDo::TO_DO_TYPE_FOUR){//获取指定日期待办
            $start = strtotime($date." 00:00:00");
            $end   = strtotime($date." 23:59:59");
            $sql->andWhere(['between','date',$start,$end]);
        }
        $d = $this->countToDoList();
        $d['count'] = (int)$sql->count();
        $d['list'] =  $sql->orderBy('date DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->all();
        //$this->printSql($sql);
        return $this->ajaxSuccess('获取成功',$d);
    }
    //统计待办事项
    public function countToDoList(){
        $type = [1,2,3];
        foreach ($type as $k => $v){
            if($v == 1){
                $start = strtotime(date('Y-m-d')." 00:00:00");
                $end   = strtotime(date('Y-m-d')." 23:59:59");
                $d['countTodayToDo'] = (int)(new ToDo())->find()
                    ->where(['user_id'=>$this->uId])
                    ->andWhere(['between','date',$start,$end])
                    ->count();//统计今日待办
            }elseif ($v == 2){
                $d['countAllToDo']   = (int)(new ToDo())->find()->where(['user_id'=>$this->uId])->count();//统计全部待办
            }else{
                $d['countFinshToDo']  = (int)(new ToDo())->find()->where(['user_id'=>$this->uId])->andWhere(['status'=>ToDo::TO_DO_STATUS_ONE])->count();//统计已完成待办
            }
        }
        //$this->printSql($sql);
        return $d;
    }
    /**
     * 获取指定月份的的待办事项
     */
    public function actionGetMonthToDoList(){
        $year      = $this->get('year', date('Y'));
        $month     = $this->get('month', date('m'));

        if( $year== '' || $month == ''){
            $year      = date('Y');
            $month     = date('m');
        }
        $beginDate = date($year.'-'.$month.'-01',strtotime(date('Y-m-d')));
        //p($beginDate);
        $endDate   = date('Y-m-d',strtotime("$beginDate + 1 month -1 day"));
        $list = (new ToDo())->find()
            ->select("date")
            ->where(['user_id'=>$this->uId])
            ->andWhere(['between','date',strtotime($beginDate),(strtotime($endDate))])
            ->groupBy(['date'])
            ->asArray()->all();
        $d = [];
        foreach ($list as $k => $v){
            $d[$k]['year'] =  date('Y',$v['date']);
            $d[$k]['month'] =  date('m',$v['date']);
            $d[$k]['day'] =  date('d',$v['date']);
        }
        return $this->ajaxSuccess('成功',$d);
    }
    //增加或者编辑待办事项列表
    public function actionAddOrEdit(){
        $post     = Yii::$app->request->post();
        $type     = $post['type'];

        if($type == 1){
            $model = new ToDo();
            $model->setScenario('add_todo');
            $info = '添加';
        }else{
            $id     = $post['id'];
            if($id == ''){
                return $this->ajaxFail('编辑失败,参数异常');
            }
            $model = (new ToDo())->findOne($id);
            if(is_null($model)){
                return $this->ajaxFail('编辑失败，未找到待办事项信息');
            }
            $model->setScenario('edit_todo');
            $info = '编辑';
        }
        $post['date'] = strtotime($post['date']);
        $post['user_id'] = $this->uId;
        $post['status'] = $post['completed'] == 100 ? ToDo::TO_DO_STATUS_ONE : ToDo::TO_DO_STATUS_TWO;
        if($model->load($post,'') && $model->validate()){
            if(!$model->save(false)){
                return $this->ajaxFail($info.'失败,未知错误',$model->attributes);
            }
            return $this->ajaxSuccess($info.'成功',$model->attributes);
        }else{
            return $this->ajaxFail($info.'失败.'.current($model->getErrors())[0]);
        }
    }
    //删除待办事项
    public function actionDeleteTodo(){
        $post     = Yii::$app->request->post();
        $id     = $post['id'];
        if($id == ''){
            return $this->ajaxFail('删除失败,参数异常');
        }
        $model = (new ToDo())->findOne($id);
        if(is_null($model)){
            return $this->ajaxFail('删除失败，未找到待办事项信息');
        }
        if($model->user_id != $this->uId){
            return $this->ajaxFail('删除失败，不能删除别人的待办事项');
        }
        if($model->delete()){
            return $this->ajaxSuccess('删除成功');
        }else{
            return $this->ajaxFail('删除失败.'.current($model->getErrors())[0]);
        }
    }
}