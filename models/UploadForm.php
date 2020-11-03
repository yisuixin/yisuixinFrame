<?php

namespace app\models;

use app\models\BaseModel;



class UploadForm extends BaseModel{

    public $file;
    public function scenarios(){
        $s = parent::scenarios();
        $s['upload_img_one']  = ['file'];//上传单图片规则
        return $s;
    }
    public function rules(){
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpeg,png,jpg','message' => '只能上传jpeg、png、jpg格式','on'=>['upload_img_one']],
            [['file'], 'file', 'skipOnEmpty' => false, 'maxSize' => 1024 * 1024 * 2,'message' => '只能上传不大于2M的图片','on'=>['upload_img_one']],
        ];
    }
}