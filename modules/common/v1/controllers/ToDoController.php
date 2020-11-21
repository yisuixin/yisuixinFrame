<?php
namespace app\modules\common\v1\controllers;

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
        $type      = $this->get('type', 2);//1获取今日待办，2获取全部待办，3获取已经完成的待办；（暂时未用到）
        $date      = $this->get('date', '');
        $startDate  = $this->get('startDate', '');
        $endtDate   = $this->get('endtDate', '');
        $data = selectDate($startDate,$endtDate);
        //p($data);
       //p(strtotime($startDate));
//        p(strtotime($date));

        $sql = (new ToDo())->find()->where(['user_id'=>$this->uId]);
        $sql->andWhere(['>=','start',$data['start_time']]);
        $sql->andWhere(['<=','end',$data['end_time']]);
        $d['count'] = (int)$sql->count();
        $list =  $sql->orderBy('end DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->all();
        //$this->printSql($sql);
        foreach ($list as $k => $v){
            $list[$k]['start'] = date('Y-m-d H:i:s',$v['start']);
            $list[$k]['end'] =  date('Y-m-d H:i:s',$v['end']);
        }
        $d['list'] =  $list;
        return $this->ajaxSuccess('获取成功',$d);
    }
    //增加或者编辑待办事项列表
    public function actionAddOrEdit(){
        $post     = Yii::$app->request->post();
        $type     = $post['type'];
        $post['start'] = strtotime($post['start']);
        $post['end']   = strtotime($post['end']);
        $post['user_id'] = $this->uId;

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

        if($model->load($post,'') && $model->validate()){
            if(!$model->save(false)){
                return $this->ajaxFail($info.'失败,未知错误',$model->attributes);
            }
            return $this->ajaxSuccess($info.'成功',$model->attributes);
        }else{
            return $this->ajaxFail($info.'失败.'.current($model->getErrors())[0]);
        }
    }
    //查看待办事项
    public function actionViewTodo(){
        $id     = $this->get('id');
        if($id == ''){
            return $this->ajaxFail('获取失败,参数异常');
        }
        $model = (new ToDo())->findOne($id);
        if(is_null($model)){
            return $this->ajaxFail('获取失败，未找到待办事项信息');
        }
        if($model->user_id != $this->uId){
            return $this->ajaxFail('获取失败，不能删除别人的待办事项');
        }
        return $this->ajaxSuccess('获取成功',$model->attributes);
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