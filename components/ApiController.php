<?php
/**
 * Api接口基类
 */
namespace app\components;


use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use app\models\rbac\Rbac;
use app\models\rbac\Role;
use app\models\log\SystemLog;


class ApiController extends ActiveController{
    public $modelClass = '';
    const STATUS_CODE_SUCC = 1;
    const STATUS_CODE_FAIL = 0;
    public $uId;
    public $user;

    // 自定义api操作方法
    public function actions() {
        $actions = parent::actions();
        unset($actions['index'],$actions['delete'], $actions['create']);
        return $actions;
    }
    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'optional' => [
                'login',  //认证排除登录接口
                'reg', //认证排除测试注册用户
                'get-captcha'
//                '*'
            ]
        ];
        return $behaviors;
    }
    public function beforeAction($action){
        $beforeAction = parent::beforeAction($action);
        $this->uId = Yii::$app->user->identity->id;
        $this->user = Yii::$app->user->identity;
        $modelId      = Yii::$app->controller->module->id;
        $controllerId = Yii::$app->controller->id;
        $actionId     = Yii::$app->controller->action->id;
        $url = $modelId.'/'. $controllerId.'/'.$actionId;
        if($this->user->role == Role::TYPE_ONE || in_array($modelId,$this->getParams('notValidationPermissionModules'))){//超级管理员或者是属于不需要验证的模块的直接返回true
            return true;
        }else{
            $validationPermission =  Rbac::validationRolePermission($this->user,$url);
            if($validationPermission){
                return true;
            }else{
                throw new ForbiddenHttpException('你没有权限，请联系管理员');
            }
        }
        return $beforeAction;
    }
    /**
     * [formatResponse 返回格式组装]
     * @author:xiaoming
     * @date:2018-01-18T16:37:13+0800
     * @param                         [type] $status  [description]
     * @param                         string $message [description]
     * @param                         string $url     [description]
     * @param                         [type] $data    [description]
     * @return                        [type]          [description]
     */
    protected function formatResponse($status, $message = '', $data = [], $url = ''){
        $requestType = getRequestType();
        if($requestType != 'GET'){//如果操作不是获取列表的话，就添加操作日志
            $log['model']      = Yii::$app->controller->module->id;
            $log['controller'] = Yii::$app->controller->id;
            $log['action']     = Yii::$app->controller->action->id;
            $log['message']    = $message;
            $log['url']        = Yii::$app->request->getHostInfo().Yii::$app->request->url;
            $log['status']     = $status;
            $log['type']       = getRequestType();
            (new SystemLog())->addLog($log);
        }
        return ['status' => $status, 'message' => $message, 'url' => $url, 'data' => $data];
    }
    /**
     * [setAjaxResponse 设置返回格式为json]
     * @author:xiaoming
     * @date:2018-01-18T16:37:32+0800
     */
    protected function setAjaxResponse(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }
    /**
     * [ajaxSuccess 成功后的返回]
     * @author:xiaoming
     * @date:2018-01-18T16:37:50+0800
     * @param                         string $message [description]
     * @param                         string $url     [description]
     * @param                         [type] $data    [description]
     * @return                        [type]          [description]
     */
    protected function ajaxSuccess($message = '', $data = [], $url = ''){
        $this->setAjaxResponse();

        return $this->formatResponse(self::STATUS_CODE_SUCC, $message, $data, $url);
    }
    /**
     * [ajaxFail 失败后的返回]
     * @author:xiaoming
     * @date:2018-01-18T16:38:01+0800
     * @param                         string $message [description]
     * @param                         string $url     [description]
     * @param                         [type] $data    [description]
     * @return                        [type]          [description]
     */
    protected function ajaxFail($message = '', $data = [], $url = ''){
        $this->setAjaxResponse();
        return $this->formatResponse(self::STATUS_CODE_FAIL, $message, $data, $url);
    }
    /**
     * [isAjax 判断是否是ajax提交]
     * @author:xiaoming
     * @date:2018-01-18T16:38:14+0800
     * @return                        boolean [description]
     */
    protected function isAjax(){
        return Yii::$app->request->getIsAjax();
    }
    /** [isPost 判断是否是post提交]
     * @author:xiaoming
     * @date:2018-01-18T16:38:14+0800
     * @return                        boolean [description]
     */
    protected function isPost(){
        return Yii::$app->request->getIsPost();
    }
    /**
     * [post 获取post参数]
     * @author:xiaoming
     * @date:2018-01-18T16:39:15+0800
     * @param                         [type] $key     [description]
     * @param                         string $default [description]
     * @return                        [type]          [description]
     */
    protected function post($key, $default = "") {
        return Yii::$app->request->post($key, $default);
    }
    /**
     * [get 获取get参数]
     * @author:xiaoming
     * @date:2018-01-18T16:39:32+0800
     * @param                         [type] $key     [description]
     * @param                         string $default [description]
     * @return                        [type]          [description]
     */
    protected function get($key, $default = "") {
        return Yii::$app->request->get($key, $default);
    }
    /**
     * [getParams 获取配置参数]
     * @author:xiaoming
     * @date:2018-01-18T16:39:43+0800
     * @param                         string $params_name [description]
     * @return                        [type]              [description]
     */
    protected function getParams($params_name = ''){
        return $params_name == '' ? '' : Yii::$app->params[$params_name];
    }
    /**
     * [printSql 打印sql]
     * @author:xiaoming
     * @date:2018-01-18T16:39:54+0800
     * @param                         string $sql [description]
     * @return                        [type]      [description]
     */
    protected function printSql($sql = ''){
        p($sql == '' ? '' : $sql->createCommand()->getRawSql());
    }
    /**
     * [selectDate 格式化搜索时间参数]
     * @author:xiaoming
     * @date:2018-01-09T17:18:05+0800
     * @param                         string $start_time [description]
     * @param                         string $end_time   [description]
     * @return                        [type]             [description]
     */
    public static function selectDate($start_time='',$end_time=''){
        if($start_time != '' && $end_time != ''){
            $d['start_time'] = strtotime(date('Y-m-d',strtotime($start_time) - 86400).' 23:59:59');
            $d['end_time']   = strtotime(date('Y-m-d',strtotime($end_time) + 86400).' 00:00:00');
        }else{
            $d['start_time'] = '';
            $d['end_time']   = '';
        }
        return $d;
    }
}
