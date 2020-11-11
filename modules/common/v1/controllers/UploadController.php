<?php
namespace app\modules\common\v1\controllers;
//文件上传相关类
use app\components\ApiController;
use yii\web\UploadedFile;
use app\models\UploadForm;
use yii;
use app\common\lib\File;

class UploadController extends ApiController{
    public function actionUploadOneImg(){
            $model = new UploadForm();
            if (Yii::$app->request->isPost) {
                $model->file = UploadedFile::getInstanceByName('file');
                $model->setScenario('upload_img_one');
                if ($model->file && $model->validate()) {
                    $path = 'uploads/'.date('Y-m-d',time()).'/';
                    $create_path = (new File())->create_dir($path);
                    if($create_path){
                        if ($model->file && $model->validate()) {
                            $newName = date('YmdHis',time()).rand(100,1000).'.'.$model->file->extension;//为保证安全，重新取名
                            $model->file->saveAs($path.'/' . $newName);
                            return $this->ajaxSuccess('上传成功',\Yii::$app->request->hostInfo.'/'.$path.$newName);
                        }
                    }else{
                        return $this->ajaxFail('上传失败,无法创建上传保存目录;请检查上传目录是否有权限。目录地址为：'.$path);
                    }
                }else{
                    return $this->ajaxFail('上传失败.'.current($model->getErrors())[0]);
                }
            }
    }
}