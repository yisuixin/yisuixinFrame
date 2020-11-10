<?php
namespace app\modules\common\v1\controllers;

use Yii;
use app\components\ApiController;
use app\models\CodeImgGenerate;

class CaptchaController extends ApiController{
    /**
     * [ 验证码 ]
     * @return [type] [description]
     */
    public function actionGetCaptcha(){
        $CodeImgGenerate = new CodeImgGenerate();
        $CodeImgGenerate->fixedVerifyCode = YII_ENV_TEST ? 'testme' : null;
        // 更多api请访问yii\captcha\CaptchaAction类文档
        $CodeImgGenerate->maxLength = 4;                         // 最大显示个数
        $CodeImgGenerate->minLength = 4;                         // 最少显示个数
        $CodeImgGenerate->padding   = 0;                          // 间距
        $CodeImgGenerate->height    = 58;                           // 高度
        $CodeImgGenerate->width     = 156;                          // 宽度
        $CodeImgGenerate->backColor = CodeImgGenerate::captcha_color(1);    // 背景颜色
        $CodeImgGenerate->foreColor = CodeImgGenerate::captcha_color(2);    // 字体颜色
        $CodeImgGenerate->offset = 4;                            // 字符之间的偏移量
        $codeInfo = $CodeImgGenerate->inline();                  // 验证码二进制流
        $code = $CodeImgGenerate->getPhrase();                   // 验证码随机数
        //Cache::saveCaptchaCache(strtolower($code));              // 验证码加存储
        // 添加一个缓存
        $captchaKey = md5(time());
        Yii::$app->cache->add($captchaKey,strtolower($code)); // 验证码加存储

        $data['captchaKey'] = $captchaKey;
        $data['captchaUrl'] = 'data:image/' . ';base64,' . chunk_split(base64_encode($codeInfo));//合成图片的base64编码


        return $this->ajaxSuccess('获取成功', $data);
    }
}