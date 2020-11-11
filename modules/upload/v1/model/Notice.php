<?php
namespace app\modules\api\model;


use app\common\lib\ModelHelper;
use app\models\User;
use app\modules\api\model\NoticeUser;
use Yii;
use app\models\BaseModel;

class Notice extends BaseModel{
    const NOTICE_TYPE_ONE = 1;const NOTICE_TYPE_TWO = 2;const NOTICE_TYPE_THREE = 3;//通知所属用户，1全部，2指定角色，3指定用户
    const NOTICE_TOPPING_ONE = 1;const NOTICE_NOTICE_TOPPING_ONE_TWO = 2;//是否置顶，1置顶，2未置顶
    //表名
    public static function tableName(){
        return "{{%notice}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['add_notice']  = ['author','title','desc','content','type','topping'];
        $s['edit_notice'] = ['id','author','title','desc','content','type','topping'];
        return $s;
    }
    //规则
    public function rules(){
        return [
            [['user_id'], 'required', 'message' => '待办事项用户参数异常','on'=>['add_todo','edit_todo']],
            [['desc'], 'required', 'message' => '待办事项描述不能为空','on'=>['add_todo','edit_todo']],
            [['date'], 'required', 'message' => '待办事项完成时间不能为空','on'=>['add_todo','edit_todo']],
            [['id'], 'required', 'message' => '待办事项ID不能为空','on'=>['edit_todo']],
            [['completed'], 'required', 'message' => '待办事项完成度不能为空','on'=>['add_todo','edit_todo']],
        ];
    }
    //更新通知状态
    public static function updateNoticeStatus($userId,$noticeData){
        if($noticeData['type'] == self::NOTICE_TYPE_ONE){//如果通知属于全部用户的话，是插入数据，否则是更新数据
            $model = new NoticeUser();
            $model->user_id = $userId;
            $model->notice_id = $noticeData['id'];
            $model->status = NoticeUser::NOTICE_STATUS_TWO;
            $model->created_at = time();
            $model->updated_at = time();
            $res = $model->save(false);
        }else{
            $model = (new NoticeUser())->findOne(['user_id'=>$userId,'notice_id'=>$noticeData['id']]);
            $model->status = NoticeUser::NOTICE_STATUS_TWO;
            $res = $model->save();
        }
        return true;
    }
    //发布全部用户通知,添加主表
    public static function addAllNotice($data,$model){
        if($model->load($data,'') && $model->validate()){
            if($model->save(false)){
               return $model->id;
            }
        }
        return false;
    }
    //发布指定角色用户通知
    public static function addRoleNotice($data,$model){
        $modelId = self::addAllNotice($data,$model);//添加主表
        if(!$modelId){
            return false;
        }
        $user = (new User())->find()->select('id')->where(['role'=>$data['userId']])->asArray()->all();
        $userIds = array_column($user,'id');
        $rows =  [];//处理所有的菜单id数组，然后批量插入数据库
        foreach ($userIds as $k=>$v){
            $rows[$k]['user_id'] = $v;
            $rows[$k]['notice_id'] = $modelId;
            $rows[$k]['created_at'] = time();
            $rows[$k]['updated_at'] = time();
        }
        if (ModelHelper::saveAll(NoticeUser::tableName(), $rows)) {
            return true;
        }
        return false;
    }
    //发布指定用户通知
    public static function addUserNotice($data,$model){
        $modelId = self::addAllNotice($data,$model);//添加主表
        if(!$modelId){
            return false;
        }
        $userIds = $data['userId'];
        $rows =  [];//处理所有的菜单id数组，然后批量插入数据库
        foreach ($userIds as $k=>$v){
            $rows[$k]['user_id'] = $v;
            $rows[$k]['notice_id'] = $modelId;
            $rows[$k]['created_at'] = time();
            $rows[$k]['updated_at'] = time();
        }
        if (ModelHelper::saveAll(NoticeUser::tableName(), $rows)) {
            return true;
        }
        return false;
    }



}