<?php
namespace app\modules\content\controllers;

use app\components\ApiController;
use Yii;
use yii\db\Query;
use app\models\model\Model;

use yii\db\Command;

class ModelController extends ApiController{
    //获取后台的通知列表
    public function actionGetModelList(){
        $page      = $this->get('page', 0);
        $pageSize  = $this->get('pageSize', $this->getParams('default_page_size'));
        $offset    = ($page - 1) * $pageSize;

        $searchKey  = $this->get('searchKey', '');
        $status     = $this->get('status', '');

        $sql = (new Model())->find();
        $sql->andFilterWhere(['or',
            ['like', 'name', $searchKey],
            ['like', 'table_name', $searchKey],
            ['like', 'desc', $searchKey]
        ]);
        $sql->andFilterWhere(['=','status',$status]);

        $list =  $sql->orderBy('created_at DESC')
            ->limit($pageSize)
            ->offset($offset)
            ->all();
        //$this->printSql($sql);
        $d['list'] =  $list;
        $d['count'] = (int)$sql->count();
        return $this->ajaxSuccess('获取成功',$d);
    }
    //新增模型
    public function actionAddModel(){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $post     = Yii::$app->request->post();
            $model = new Model();
            $model->setScenario('add_model');
            if($model->load($post,'') && $model->validate()){
                if($model->save()){
                    $transaction->commit();
                    return $this->ajaxSuccess('添加成功');
                }
            }
            $transaction->rollBack();
            return $this->ajaxFail('添加失败.'.current($model->getErrors())[0]);
        }catch (Exception $e) {
            $transaction->rollBack();
            return $this->ajaxFail('添加失败,服务器异常');
        }
    }
    //编辑模型
    public function actionEditModel(){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $post     = Yii::$app->request->post();
            $id     = $post['id'];
            if($id == ''){
                return $this->ajaxFail('编辑失败,参数异常');
            }
            $model = (new Model())->findOne($id);
            if(is_null($model)){
                return $this->ajaxFail('编辑失败，未找到模型信息');
            }
            $model->setScenario('edit_model');
            if($model->load($post,'') && $model->validate()){
                if($model->save()){
                    $transaction->commit();
                    return $this->ajaxSuccess('编辑成功');
                }
            }
            $transaction->rollBack();
            return $this->ajaxFail('编辑失败.'.current($model->getErrors())[0]);
        }catch (Exception $e) {
            $transaction->rollBack();
            return $this->ajaxFail('编辑失败,服务器异常');
        }
    }
    /**
     *获取模型信息
     */
    public function actionGetModelInfo(){
        $id  = $this->get('id', '');
        if($id == ''){
            return $this->ajaxFail('获取失败，参数异常');
        }
        $modelInfo = (new Model())->find()->where(['id'=>$id])->asArray()->one();
        if(is_null($modelInfo)){
            return $this->ajaxFail('获取失败，未找到模型信息');
        }
        return $this->ajaxSuccess('获取成功',$modelInfo);
    }
    //删除模型
    public function actionDeleteModel(){
        $post     = Yii::$app->request->post();
        $id     = $post['id'];
        if($id == ''){
            return $this->ajaxFail('删除失败,参数异常');
        }
        $model = (new Model())->findOne($id);
        if(is_null($model)){
            return $this->ajaxFail('删除失败，未找到相关模型');
        }
        if($model->delete()){
            return $this->ajaxSuccess('删除成功');
        }else{
            return $this->ajaxFail('删除失败.'.current($model->getErrors())[0]);
        }
    }
}