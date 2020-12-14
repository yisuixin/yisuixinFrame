<?php
namespace app\modules\system\controllers;

use Yii;
use app\components\ApiController;
use app\models\WebConfig;
use app\common\lib\ModelHelper;


class WebConfigController extends ApiController{
    /**
     * 获取后台配置
     * @return int[]
     */
    public function actionGetConfig(){
            $get     = Yii::$app->request->get();
            $type = $get['type'];

            $configList = (new WebConfig())->find()->where(['type'=>$type])->asArray()->all();
            if(!empty($configList)){
                foreach ($configList as $k => $v){
                    $data[$v['name']] = $v['value'];
                }
            }else{
                $data = [];
            }
            return $this->ajaxSuccess('获取成功',$data);
    }
    /**
     * 编辑后台配置
     * @return int[]
     */
    public function actionEditConfig(){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $post     = Yii::$app->request->post();
            if(!is_array($post['data'])){
                return $this->ajaxFail('修改失败,参数异常');
            }
            $rows = [];
            $index = 0;
            foreach ($post['data'] as $key => $value) {
                $rows[$index]['type']  = $post['type'];
                $rows[$index]['name']  = $key;
                $rows[$index]['value'] = $value;
                $index++;
            }
            //修改之前删除数据库数据
            $deleteConfig = WebConfig::deleteAll('type = :type', [':type' => $post['type']]);
            if (!ModelHelper::saveAll(WebConfig::tableName(), $rows)) {
                $transaction->rollBack();
                return $this->ajaxFail('修改失败,未知错误');
            }
            $transaction->commit();
            return $this->ajaxSuccess('修改成功');
        }catch (Exception $e) {
            $transaction->rollBack();
            return $this->ajaxFail('修改失败,未知错误');
        }
    }
}
