<template>
    <div>
        <Form ref="backendForm" :label-width="250"  :model="formInline" :rules="formRule" label-position="left" :hide-required-mark="true">
            <Card style="margin-bottom: 10px;">
                <p slot="title">基础配置</p>
                <FormItem prop="closeWeb">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">是否关闭站点</Col>
                            <Col span="24" class="label-info">最多15个字符</Col>
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
                            <Col span="24" class="label-info"></Col>
                        </Row>
                    </div>
                    <Input type="textarea" v-model="formInline.closeWebTip" :rows="2" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="webName">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">站点名称</Col>
                            <Col span="24" class="label-info">最多15个字符</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.webName" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="webKey" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">站点关键字</Col>
                            <Col span="24" class="label-info">多个请用,号隔开;最多50个字符</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.webKey" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="webDesc">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">站点简介</Col>
                            <Col span="24" class="label-info">最多50个字符</Col>
                        </Row>
                    </div>
                    <Input type="textarea" v-model="formInline.webDesc" :rows="6" style="width: 400px"></Input>
                </FormItem>
            </Card>
            <Card style="margin-bottom: 10px;">
                <p slot="title">附件配置</p>
                <FormItem prop="frontAllowType" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">允许上传附件类型</Col>
                            <Col span="24" class="label-info">多个请用,号隔开;最多50个字符</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.frontAllowType" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="frontAllowSize">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">允许上传附件大小</Col>
                            <Col span="24" class="label-info">多个用"|"隔开</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.frontAllowSize" style="width: 400px"><span slot="append">kb</span></Input>
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
                            <Col span="24" class="label-name">水印添加条件:</Col>
                            <Col span="24" class="label-info">当图片尺寸为条件范围时才添加水印</Col>
                        </Row>
                    </div>
                    <Row>
                        <Col span="2">
                            <FormItem prop="WatermarkMin">
                                <Input type="text" v-model="formInline.WatermarkMin" placeholder="图片长度">
                                    <span slot="prepend">长</span><span slot="append">px</span>
                                </Input>
                            </FormItem>
                        </Col>
                        <Col span="1" style="text-align: center;">-</Col>
                        <Col span="2">
                            <FormItem prop="WatermarkMax">
                                <Input type="text" v-model="formInline.WatermarkMax" placeholder="图片宽度">
                                    <span slot="prepend">宽</span><span slot="append">px</span>
                                </Input>
                            </FormItem>
                        </Col>
                    </Row>
                </FormItem>
                <FormItem prop="WatermarkPath" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">水印图片</Col>
                            <Col span="24" class="label-info">水印存放路径从网站根目录起</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.WatermarkPath" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="WatermarkTransparency" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">水印透明度</Col>
                            <Col span="24" class="label-info">请设置为0-100之间的数字，0代表完全透明，100代表不透明</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.WatermarkTransparency" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="WatermarkQuality" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">水印质量</Col>
                            <Col span="24" class="label-info">水印质量请设置为0-100之间的数字,决定图片的质量</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.WatermarkQuality" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="WatermarkLocation" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">水印位置</Col>
                            <Col span="24" class="label-info"></Col>
                        </Row>
                    </div>
                    <Select v-model="formInline.WatermarkLocation" placeholder="请选择水印位置" style="width: 400px">
                        <Option value="1">左上</Option>
                        <Option value="2">中上</Option>
                        <Option value="3">右上</Option>
                        <Option value="4">左中</Option>
                        <Option value="5">中心</Option>
                        <Option value="6">右中</Option>
                        <Option value="7">左下</Option>
                        <Option value="8">中下</Option>
                        <Option value="9">右下</Option>
                    </Select>
                </FormItem>
            </Card>
        </Form>
    </div>
</template>
<script>
    export default {
        data() {
            const validateNumber = (rule, value, callback) => {
                if (value.trim() === '') {
                    return callback(new Error('请输入字段名称'))
                } else if (/[^\a-\z\A-\Z]/g.test(value)) {
                    return callback(new Error('字段名称必须为英文'))
                } else {
                    callback()
                }
            };
            return {
                current: 0,
                formInline:{
                    closeWeb:'2',
                    closeWebTip:'',
                    webName:'',
                    webKey:'',
                    webDesc:'',
                    allowType:'jpg|jpeg|gif|bmp|png',
                    allowSize:'200',
                    openWatermark:'2',
                    WatermarkMin:'300',
                    WatermarkMax:'100',
                    WatermarkPath:'/statics/images/mark_bai.png',
                    WatermarkTransparency:'80',
                    WatermarkQuality:'85',
                    WatermarkLocation:'7'
                },
                formRule:{
                    webName: [
                        { type: 'string', max: 15, message: '站点名称最多15个字符',trigger: 'blur' },
                    ],
                    webKey: [
                        { type: 'string', max: 50, message: '站点关键词最多50个字符',trigger: 'blur' }
                    ],
                    webDesc: [
                        { type: 'string', max: 50, message: '站点简介最多50个字符',trigger: 'blur' }
                    ],
                    adminAllowSize: [{type: 'number', message: '后台允许上传大小必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                    frontAllowSize: [{type: 'number', message: '前台允许上传大小必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                    WatermarkMin: [{type: 'number', message: '水印条件范围长度必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                    WatermarkMax: [{type: 'number', message: '水印条件范围宽度必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                    WatermarkTransparency: [{type: 'number', message: '水印透明度必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                    WatermarkQuality: [{type: 'number', message: '水印质量必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                },
            }
        },
        methods: {
            //修改站点基本信息
            editConfigBasicInfo(that){
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Message.success('Success!');
                    }
                })
            },
        }
    }
</script>