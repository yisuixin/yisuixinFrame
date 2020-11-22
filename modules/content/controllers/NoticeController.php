<?php
namespace app\modules\content\controllers;

use app\components\ApiController;
use app\models\User;
use app\models\rbac\Role;
use Yii;
use app\modules\common\v1\model\Notice;
use app\modules\common\v1\model\NoticeUser;
use yii\db\Query;

class NoticeController extends ApiController{
    //获取通知详情
    public function actionGetNoticeInfo(){
        $id      = $this->get('id', '');
        $type    = $this->get('userType', 'user');//从用户列表进入的话要去更新状态，从admin后台列表进入的话不需要更新状态
        $sql = (new Query())->select([ 'a.*','u.username'])->from(Notice::tableName().' AS a');
        $sql->where(['a.id'=>$id]);
        $sql->leftJoin(User::tableName().' AS u','u.id = a.author');

        $data =  $sql->one();
        if($type == 'user'){
          Notice::updateNoticeStatus($this->uId,$data);
        }
        //$this->printSql($sql);
       //p($data);
        return $this->ajaxSuccess('获取成功',$data);
    }
    //获取后台的通知列表
    public function actionGetAdminNoticeList(){
        $page      = $this->get('page', 0);
        $pageSize  = $this->get('pageSize', $this->getParams('default_page_size'));
        $offset    = ($page - 1) * $pageSize;

        $searchKey  = $this->get('searchKey', '');
        $time       = $this->get('time', '');
        $topping    = $this->get('topping', '');
        $author     = $this->get('author', '');


        $sql = (new Query())->select([ 'a.*','u.username','u.avatar'])->from(Notice::tableName().' AS a')->distinct();
        $sql->leftJoin(User::tableName().' AS u','u.id = a.author');
        $sql->andFilterWhere([
            'or',
            ['like','title',$searchKey],
            ['like','desc',$searchKey],
        ]);
        $sql->andFilterWhere(['like','u.username',$author]);
        $sql->andFilterWhere(['a.topping'=>$topping]);

        if($time[0] != '' && $time[1] != ''){
            $newTime = selectDate($time[0],$time[1]);
            $sql->andWhere(['between', 'a.created_at', $newTime['start_time'], $newTime['end_time']]);
        }

        $d['count'] = (int)$sql->count();
        $d['list'] =  $sql->orderBy('topping ASC,created_at DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->all();
        //$this->printSql($sql);
        //p($d['list']);
        return $this->ajaxSuccess('获取成功',$d);
    }
    //发布公告
    public function actionAddNotice(){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $post     = Yii::$app->request->post();
            $is_add     = $post['is_add'];
            if($is_add == 1){
                $model = new Notice();
                $model->setScenario('add_notice');
                $info = '添加';
            }else{
                $id     = $post['id'];
                if($id == ''){
                    return $this->ajaxFail('编辑失败,参数异常');
                }
                $model = (new Notice())->findOne($id);
                if(is_null($model)){
                    return $this->ajaxFail('编辑失败，未找到公告信息');
                }
                $model->setScenario('edit_notice');
                $info = '编辑';
            }
            $post['author'] = $this->uId;//发布者
            if($post['type'] == Notice::NOTICE_TYPE_ONE){//发布全部用户公告,只需要插入到一张表里面
                $res = Notice::addAllNotice($post,$model);
            }elseif($post['type'] == Notice::NOTICE_TYPE_TWO){//发布指定角色公告,需要先根据角色ID查找用户ID,然后插入到notice_user表里面
                $res = Notice::addRoleNotice($post,$model);
            }elseif ($post['type'] == Notice::NOTICE_TYPE_THREE){//发布指定用户公告,需要先根据角色ID查找用户ID,然后插入到notice_user表里面
                $res = Notice::addUserNotice($post,$model);
            }
            if($res){
                $transaction->commit();
                return $this->ajaxSuccess($info.'成功');
            }
            $transaction->rollBack();
            return $this->ajaxFail($info.'失败,未知错误');
        }catch (Exception $e) {
            $transaction->rollBack();
            return $this->ajaxFail('操作失败,服务器异常');
        }
    }
    //删除通知公告
    public function actionDeleteNotice(){
        $post     = Yii::$app->request->post();
        $id     = $post['id'];
        if($id == ''){
            return $this->ajaxFail('删除失败,参数异常');
        }
        $model = (new Notice())->findOne($id);
        if(is_null($model)){
            return $this->ajaxFail('删除失败，未找到通知公告信息');
        }
        if($this->user->role != Role::TYPE_ONE && $model->author != $this->uId){
            return $this->ajaxFail('删除失败，不能删除别人的通知公告');
        }
        if($model->delete()){
            return $this->ajaxSuccess('删除成功');
        }else{
            return $this->ajaxFail('删除失败.'.current($model->getErrors())[0]);
        }
    }
    //通知公告置顶或者取消置顶
    public function actionToppingNotice(){
        $post     = Yii::$app->request->post();
        $id       = $post['id'];
        $type     = $post['type'];
        $info = $type == 1 ? '取消置顶': '置顶';
        if($id == ''){
            return $this->ajaxFail($info.'失败,参数异常');
        }
        $model = (new Notice())->findOne($id);
        if(is_null($model)){
            return $this->ajaxFail($info.'失败，未找到通知公告信息');
        }
        if($this->user->role != Role::TYPE_ONE && $model->author != $this->uId){
            return $this->ajaxFail($info.'失败，不能操作别人的通知公告');
        }
        $model->topping = $type;
        if($model->save(false)){
            return $this->ajaxSuccess($info.'成功');
        }else{
            return $this->ajaxFail($info.'失败.'.current($model->getErrors())[0]);
        }
    }
}