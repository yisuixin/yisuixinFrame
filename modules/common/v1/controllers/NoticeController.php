<?php
namespace app\modules\common\v1\controllers;

use app\components\ApiController;
use app\models\User;
use app\modules\rabc\model\Role;
use Yii;
use app\modules\common\v1\model\Notice;
use app\modules\common\v1\model\NoticeUser;
use yii\db\Query;

class NoticeController extends ApiController{
    //获取用户的通知列表
    public function actionGetUserNoticeList(){
        $page      = $this->get('page', 0);
        $pageSize  = $this->get('pageSize', $this->getParams('default_page_size'));
        $offset    = ($page - 1) * $pageSize;

        $sql = (new Query())->select([ 'a.*','u.username','b.status'])->from(Notice::tableName().' AS a')->distinct();
        $sql->where(['type'=>Notice::NOTICE_TYPE_ONE]);
        $sql->leftJoin(NoticeUser::tableName().' AS b', 'a.id = b.notice_id');
        $sql->leftJoin(User::tableName().' AS u','u.id = a.author');
        $sql->orWhere(['b.user_id'=>$this->uId]);

        $d['count'] = (int)$sql->count();
        $d['list'] =  $sql->orderBy('topping ASC,created_at DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->all();
        //$this->printSql($sql);
        //p($d['list']);
        return $this->ajaxSuccess('获取成功',$d);
    }
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
}