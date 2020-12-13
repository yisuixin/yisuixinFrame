<template>
    <div>
        <Form ref="frontedForm"
              :label-width="250"
              :model="formInline"
              :rules="formRule"
              label-position="left"
              :hide-required-mark="true">
            <Card style="margin-bottom: 10px;">
                <p slot="title">基础配置</p>
                <FormItem prop="closeWeb">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">是否关闭站点</Col>
                            <Col span="24" class="label-info">前台调用变量名</Col>
                        </Row>
                    </div>
                    <RadioGroup v-model="formInline.closeWeb">
                        <Radio label="1">
                            <span>是</span>
                        </Radio>
                        <Radio label="2">
                            <span>否</span>
                        </Radio>
                    </RadioGroup>
                </FormItem>
                <FormItem prop="closeWebTip" v-if="formInline.closeWeb == 1">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">关闭站点提示</Col>
                            <Col span="24" class="label-info">最多1000个字符</Col>
                        </Row>
                    </div>
                    <Input type="textarea" v-model="formInline.closeWebTip" :rows="6" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="webName">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">站点名称</Col>
                            <Col span="24" class="label-info">最多20个字符</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.webName" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="webKey" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">站点关键字</Col>
                            <Col span="24" class="label-info">多个请用,号隔开;最多80个字符</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.webKey" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="webDesc">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">站点简介</Col>
                            <Col span="24" class="label-info">最多200个字符</Col>
                        </Row>
                    </div>
                    <Input type="textarea" v-model="formInline.webDesc" :rows="4" style="width: 400px"></Input>
                </FormItem>
            </Card>
            <Card style="margin-bottom: 10px;">
                <p slot="title">附件配置</p>
                <FormItem prop="allowType" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">允许上传附件类型</Col>
                            <Col span="24" class="label-info">多个请用,号隔开;最多50个字符</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.allowType" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="allowSize">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">允许上传附件大小</Col>
                            <Col span="24" class="label-info">只能输入正整数</Col>
                        </Row>
                    </div>
                    <Input type="number" v-model="formInline.allowSize" style="width: 400px"><span slot="append">kb</span></Input>
                </FormItem>
                <FormItem prop="openWatermark">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">是否开启图片水印</Col>
                            <Col span="24" class="label-info"></Col>
                        </Row>
                    </div>
                    <RadioGroup v-model="formInline.openWatermark">
                        <Radio label="1">
                            <span>是</span>
                        </Radio>
                        <Radio label="2">
                            <span>否</span>
                        </Radio>
                    </RadioGroup>
                </FormItem>
                <FormItem label="字段取值长度">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">水印添加条件</Col>
                            <Col span="24" class="label-info">当图片尺寸为条件范围时才添加水印;只能输入正整数</Col>
                        </Row>
                    </div>
                    <Row>
                        <Col span="3">
                            <FormItem prop="watermarkMin">
                                <Input type="number" v-model="formInline.watermarkMin" placeholder="图片长度">
                                    <span slot="prepend">长</span><span slot="append">px</span>
                                </Input>
                            </FormItem>
                        </Col>
                        <Col span="1" style="text-align: center;">x</Col>
                        <Col span="3">
                            <FormItem prop="watermarkMax">
                                <Input type="number" v-model="formInline.watermarkMax" placeholder="图片宽度">
                                    <span slot="prepend">宽</span><span slot="append">px</span>
                                </Input>
                            </FormItem>
                        </Col>
                    </Row>
                </FormItem>
                <FormItem prop="watermarkPath" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">水印图片</Col>
                            <Col span="24" class="label-info">只能上传png格式；</Col>
                        </Row>
                    </div>
                    <!--单图片上传组件-->
                    <UploadOneImg :img="formInline.watermarkPath"
                                  form="input"
                                  uploadBtnText ="上传水印图"
                                  :accept="['png']"
                                  @uploadImg="uploadImg" >
                    </UploadOneImg>
                </FormItem>
                <FormItem prop="watermarkTransparency" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">水印透明度</Col>
                            <Col span="24" class="label-info">请设置为0-100之间的数字，0代表完全透明，100代表不透明;只能输入正整数</Col>
                        </Row>
                    </div>
                    <Input type="number" v-model="formInline.watermarkTransparency" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="watermarkQuality" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">水印质量</Col>
                            <Col span="24" class="label-info">水印质量请设置为0-100之间的数字,决定图片的质量;只能输入正整数</Col>
                        </Row>
                    </div>
                    <Input type="number" v-model="formInline.watermarkQuality" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="WatermarkLocation" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">水印位置</Col>
                            <Col span="24" class="label-info"></Col>
                        </Row>
                    </div>
                        <div>
                            <ul class="grid">
                                <li :class="formInline.watermarkLocation == 1 ? 'selected':'' " @click="selectWatermarkLocation(1);">左上</li>
                                <li :class="formInline.watermarkLocation == 2 ? 'selected':'' " @click="selectWatermarkLocation(2);">中上</li>
                                <li :class="formInline.watermarkLocation == 3 ? 'selected':'' " @click="selectWatermarkLocation(3);">右上</li>
                                <li :class="formInline.watermarkLocation == 4 ? 'selected':'' " @click="selectWatermarkLocation(4);">左中</li>
                                <li :class="formInline.watermarkLocation == 5 ? 'selected':'' " @click="selectWatermarkLocation(5);">中心</li>
                                <li :class="formInline.watermarkLocation == 6 ? 'selected':'' " @click="selectWatermarkLocation(6);">右中</li>
                                <li :class="formInline.watermarkLocation == 7 ? 'selected':'' " @click="selectWatermarkLocation(7);">左下</li>
                                <li :class="formInline.watermarkLocation == 8 ? 'selected':'' " @click="selectWatermarkLocation(8);">中下</li>
                                <li :class="formInline.watermarkLocation == 9 ? 'selected':'' " @click="selectWatermarkLocation(9);">右下</li>
                            </ul>
                        </div>
                </FormItem>
            </Card>
        </Form>
    </div>
</template>
<style>
    .grid > li:hover{
        border-color: #2d8cf0 !important;
        background: #2d8cf0 !important;
        color: #ffffff !important;
    }
</style>
<script>
    import UploadOneImg from '../../components/Upload/UploadOneImg';
    import WatermarkPath from '@/assets/img/watermark.jpg';

    export default {
        components: {UploadOneImg},
        data() {
            //验证正整数
            const  validateNumber = (rule, value, callback) => {
                if (/^[0-9]+$/.test(value)) {
                    callback();
                } else {
                    return callback(new Error("请填写整数"));
                }
            };
            return {
                type:1,//1前台，2后台
                formInline:{
                    closeWeb:'2',
                    closeWebTip:'对不起，该站点已暂停访问~',
                    webName:'',
                    webKey:'',
                    webDesc:'',
                    allowType:'jpg|jpeg|gif|bmp|png',
                    allowSize:2048,
                    openWatermark:'2',
                    watermarkMin:'500',
                    watermarkMax:'150',
                    watermarkPath:'',//require('../../assets/img/watermark.jpg')
                    watermarkTransparency:'80',
                    watermarkQuality:'85',
                    watermarkLocation:9
                },
                formRule:{
                    webName: [
                        { type: 'string', max: 20, message: '站点名称最多20个字符',trigger: 'blur' },
                    ],
                    webKey: [
                        { type: 'string', max: 80, message: '站点关键词最多80个字符',trigger: 'blur' }
                    ],
                    webDesc: [
                        { type: 'string', max: 200, message: '站点简介最多200个字符',trigger: 'blur' }
                    ],
                    allowSize: [
                        {validator: validateNumber, message: '允许上传大小必须为正整数', trigger: "blur" }
                    ],
                    watermarkMin: [
                        {validator: validateNumber, message: '水印条件范围长度必须为正整数', trigger: "blur" }
                    ],
                    watermarkMax: [
                        {validator: validateNumber, message: '水印条件范围长度必须为正整数', trigger: "blur" }
                    ],
                    watermarkTransparency: [
                        {validator: validateNumber, message: '水印透明度必须为正整数', trigger: "blur" }
                    ],
                    watermarkQuality: [
                        {validator: validateNumber, message: '水印质量必须为正整数', trigger: "blur" }
                    ],
                },
            }
        },
        methods: {
            //通过子组件传过来的地址修改
            uploadImg(data){
                this.formInline.watermarkPath = data;
            },
            //选择水印位置
            selectWatermarkLocation(value){
               this.formInline.watermarkLocation = value;
            },
            //提交配置数据
            submit(){
                const that = this;
                that.$emit('fun','正在修改配置...',true,true);
                let successCallback = function(res){
                    that.$Message.info({
                        content:'修改成功',
                        onClose:function () {
                            that.$emit('fun','修改配置',false,false);
                        }
                    })
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:'修改失败，服务器错误',
                        onClose:function () {
                            that.$emit('fun','修改配置',false,false);
                        }
                    })
                }
                that.HTTPJS.post(that.HTTPURL.SYSTEM_SEETING.CONFIG.EDIT_CONFIG,{type:that.type,data:that.formInline},successCallback,failCallback);
            }

        }
    }
</script>