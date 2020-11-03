<?php
namespace app\models;
use Yii;
use yii\base\Model;
use app\models\User;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $_user;
    const GET_API_TOKEN = 'generate_api_token';
    public function init ()
    {
        parent::init();
        $this->on(self::GET_API_TOKEN, [$this, 'onGenerateApiToken']);
    }
    /**
     * @inheritdoc
     * 对客户端表单数据进行验证的rule
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required','message'=>'账号或者密码不能为空'],
            ['password', 'validatePassword','message'=>'账号或者密码错误'],
        ];
    }
    /**
     * 自定义的密码认证方法
     */
    public function validatePassword($attribute, $params){
        if (!$this->hasErrors()) {
            $this->_user = $this->getUser();
//            print_r($this->_user);exit;
            if (!$this->_user || !$this->_user->validatePassword($this->password,$this->_user->password_hash)) {
                $this->addError($attribute, '用户名或密码错误.');
            }
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }
    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login(){
        if ($this->validate()) {
            $this->trigger(self::GET_API_TOKEN);
            return $this->_user;
        } else {
            return null;
        }
    }
    /**
     * 根据用户名获取用户的认证信息
     *
     * @return User|null
     */
    protected function getUser(){
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
    /**
     * 登录校验成功后，为用户生成新的token
     * 如果token失效，则重新生成token
     */
    public function onGenerateApiToken (){
        $model = $this->_user;
        $model->api_token = Yii::$app->security->generateRandomString() . '_' . time();
        $model->save(false);
    }
}