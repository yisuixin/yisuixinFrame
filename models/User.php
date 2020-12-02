<?php
namespace app\models;



use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use OAuth2\Storage\UserCredentialsInterface;
use app\models\log\LoginLog;
use app\models\BaseModel;
use app\models\rbac\Role;
class User extends BaseModel implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;//已启用

    const REQUEST_TYPE_ONE = 1;//重置密码
    const REQUEST_TYPE_TWO = 2;//修改状态
    const REQUEST_TYPE_THREE = 3;//删除



    public $authKey;
    public $accessToken;

    public $oldPass;
    public $newPass;
    public $newPassAgain;
    public $password;


    public $editManagerId;
    public $editManagerType;
    public $editManagerValue;


    //表名
    public static function tableName(){
        return "{{%admin}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['edit_user']  = ['nickname','avatar','email','mark'];//编辑信息规则
        $s['edit_pass']  = ['oldPass','newPass','newPassAgain'];//修改密码规则
        $s['add_manager']  = ['username','roleId','nickname','password','email','mark','status'];//增加管理员规则
        $s['edit_manager']  = ['id','type','value'];//修改管理员规则
        return $s;
    }
    //规则
    public function rules(){
        return [
            //修改个人信息规则
            ['nickname', 'required', 'message' => '用户昵称不能为空','on'=>['edit_user']],
            ['email', 'required', 'message' => '用户邮箱不能为空','on'=>['edit_user']],
            ['nickname', 'string', 'max'=>8, 'message' => '用户昵称最多8个字符','on'=>['edit_user']],
            ['mark', 'string', 'max'=>30, 'message' => '个人描述最多30个字符','on'=>['edit_user']],
            ['email', 'email', 'message' => '邮箱格式不正确','on'=>['edit_user','add_manager']],
            //修改密码规则
            ['oldPass', 'required', 'message' => '旧密码不能为空','on'=>['edit_pass']],
            ['newPass', 'required', 'message' => '新密码不能为空','on'=>['edit_pass']],
            ['newPass', 'string', 'min'=>6, 'message' => '新密码不能少于为6个字符','on'=>['edit_user']],
            ['newPass', 'string', 'max'=>15, 'message' => '新密码最多为15个字符','on'=>['edit_user']],
            ['newPassAgain', 'required', 'message' => '新密码和重复新密码不一致','on'=>['edit_pass']],
            [['oldPass'], 'validationOldPass','on'=>['edit_pass']],
            [['newPass','newPassAgain'], 'validationnewPassAgain','on'=>['edit_pass']],
            //增加管理员规则
            ['roleId', 'required', 'message' => '请选择管理员所属角色','on'=>['add_manager']],
            ['username', 'validationOnlyName','on'=>['add_manager']],
            ['username', 'required', 'message' => '请输入管理员登录名','on'=>['add_manager']],
            ['username','match','pattern'=>'/^[a-zA-Z\s]+$/','message'=>'管理员登录名必须为英文'],
            ['nickname', 'required', 'message' => '请输入管理员昵称','on'=>['add_manager']],
            ['nickname', 'string', 'max'=>8, 'message' => '管理员昵称昵称最多为8个字符','on'=>['add_manager']],
            ['password', 'required', 'message' => '请输入管理员登录密码','on'=>['add_manager']],
            ['password', 'string', 'min'=>6, 'message' => '管理员密码不能少于为6个字符','on'=>['add_manager']],
            ['password', 'string', 'max'=>15, 'message' => '管理员密码最多为15个字符','on'=>['add_manager']],
            ['username', 'string', 'min'=>4, 'message' => '管理员登录名不能少于为4个字符','on'=>['add_manager']],
            ['username', 'string', 'max'=>10, 'message' => '管理员登录名最多10个字符','on'=>['add_manager']],
            ['mark', 'string', 'max'=>20, 'message' => '管理员备注最多20个字符','on'=>['add_manager']],
        ];
    }
    //验证旧密码
    public function validationOldPass($attribute, $params){
        $user_id = Yii::$app->user->identity->id;
        $model = (new User())->findIdentity($user_id);
        if(!$model){
            return $this->addError($attribute, "数据验证错误");
        }else{
             $data = $this->validatePassword($this->oldPass, $model->password_hash);
            if(!$data){
                return $this->addError($attribute, "旧密码不正确");
            }
            return true;
        }
    }
    //验证新密码和重复密码
    public function validationnewPassAgain($attribute, $params){
        if($this->newPass != $this->newPassAgain){
            return $this->addError($attribute, "新密码和重复新密码不一致");
        }
        return true;
    }
    //验证用户名唯一
    public function validationOnlyName($attribute, $params){
        $user = self::findByUsername($this->username);
        if(!is_null($user)){
            return $this->addError($attribute, "用户登录名已存在");
        }
        return true;
    }


    /**
     * 生成 "remember me" 认证key
     */
    public function generateAuthKey(){
        return $this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * 生成 api_token
     */
    public function generateApiToken(){
        $this->api_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * 校验api_token是否有效
     */
    public static function apiTokenIsValid($token){
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.apiTokenExpire'];
        return $timestamp + $expire >= time();
    }
    /**
     * 根据api token 获取用户
     * @param $token
     * @return array|null|ActiveRecord
     */
    public static function findByApiToken($token){
        return static::find()->where('api_token = :api_token', [':api_token' => $token])->one();
    }
    /**
     * 根据用户名查询用户
     * @param $username
     * @return array|null|ActiveRecord
     */
    public static function findByUsername($username){
        return static::find()->where('username = :username', [':username' => $username])->joinWith('role')->one();
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id){
        return static::findOne(['id' => $id]);
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null){
        // 如果token无效的话
        if(!static::apiTokenIsValid($token)) {
            throw new \yii\web\UnauthorizedHttpException("token is invalid.");
        }
        return static::findOne(['api_token' => $token]);
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * 为model的password_hash字段生成密码的hash值
     *
     * @param string $password
     */
    public function setPassword($password)
    {
       return $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password, $password_hash){
        return Yii::$app->security->validatePassword($password, $password_hash);
    }
    /** 对当前用户信息进行过滤
     * @param string $userInfo
     */
    public function getUserInfo($userInfo = ''){
        $d['id'] = $userInfo['id'];
        $d['username'] = $userInfo['username'];
        $d['nickname'] = $userInfo['nickname'];
        $d['avatar'] = $userInfo['avatar'];
        $d['email'] = $userInfo['email'];
        $d['mark'] = $userInfo['mark'];
        $d['role'] = $userInfo['roleId'] ==  Role::TYPE_ONE ? '' : 1;//返回空则是超级管理员，否则是角色
        return $d;
    }
    /** 添加登录日志
     * @param $status
     * @param $post
     */
    public static function addLoginLog($status,$post){
      if($status == 1){
          (new LoginLog())->addLog('add_login_log',LoginLog::LOGIN_LOG,'登录失败.账号被禁用或者删除',
              ['username'=>$post['username'], 'password'=>'密码保密','content'=>'登录失败.账号被禁用或者删除']
          );
      }elseif ($status == 2){
          (new LoginLog())->addLog('add_login_log',LoginLog::LOGIN_LOG,'登录成功',
              ['username'=>$post['username'], 'password'=>'密码保密','content'=>'登录成功']
          );
      }elseif ($status == 3){
          (new LoginLog())->addLog('add_login_log',LoginLog::LOGIN_LOG,'登录失败.账号所属角色被禁用',
              ['username'=>$post['username'], 'password'=>'密码保密','content'=>'登录成功']
          );
      }else{
          (new LoginLog())->addLog('add_login_log',LoginLog::LOGIN_LOG,'登录失败,账号或者密码错误',
              ['username'=>$post['username'], 'password'=>'密码保密','content'=>'登录失败,账号或者密码错误']
          );
      }
    }
    public function getRole(){
        return $this->hasOne(Role::className(),['id'=>'roleId'])->select('id,name,status');
    }
}