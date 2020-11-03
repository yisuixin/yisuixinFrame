<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\captcha\CaptchaAction;

class CodeImgGenerate extends CaptchaAction{
    private $verifycode;

    public function __construct()
    {
        $this->init();
        // 更多api请访问yii\captcha\CaptchaAction类文档
        // 这里可以初始化默认样式
        $this->maxLength = 4;            // 最大显示个数
        $this->minLength = 4;            // 最少显示个数
        $this->backColor = 0x000000;     // 背景颜色
        $this->foreColor = 0x00ff00;     // 字体颜色
        $this->width = 120;               // 宽度
        $this->height = 52;              // 高度
        $this->offset = 2;
    }

    /**
     * [返回图片二进制]
     * @return [type] [description]
     */
    public function inline()
    {
        return $this->renderImage($this->getPhrase());
    }

    /**
     * [返回图片验证码]
     * @return [type] [description]
     */
    public function getPhrase(){
        if($this->verifycode){
            return $this->verifycode;
        }else{
            return $this->verifycode = $this->generateVerifyCode();
        }
    }
    /**
     * [ 返回随机颜色 ]
     * @param  integer $type [description]
     * @return [type]        [description]
     */
    public static function captcha_color($type=1){
        if(!in_array($type, array(1,2))) $type=1;
        if($type==1) {
            // 背景颜色
            $bg_color_arr=array('15595519','16316664');
            $bg=$bg_color_arr[array_rand($bg_color_arr)];
            return (int) '0x'.$bg;
        } else {
            // 字体颜色
            $text_color_arr=array('12326852','2185586');
            $tc=$text_color_arr[array_rand($text_color_arr)];
            return (int) '0x'.$tc;
        }
    }
    /**
     * [ 验证验证码 ]
     * @param  integer $type [description]
     * @return [type]        [description]
     */
    public static function validCaptcha($key,$code){
        if($code == Yii::$app->cache->get($key)){
            Yii::$app->cache->delete($key);// 删除验证码缓存
            return true;
        }
        return false;
    }
}

