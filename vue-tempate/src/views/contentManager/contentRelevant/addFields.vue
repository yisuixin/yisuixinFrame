<template>
    <div>
        <div id='basicInfo'></div>
        <Form ref="formValidate" :label-width="250"  :model="formInline" :rules="ruleInline" label-position="left" :hide-required-mark="true">
            <Card :bordered="false" dis-hover v-bind:style="currentRole=='' ? 'margin-bottom: 90px' : 'margin-bottom: 30px'">
                <p slot="title">
                    基本属性
                </p>
                <FormItem label="菜单" prop="field_type">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">字段类型</Col>
                            <Col span="24" class="label-info"></Col>
                        </Row>
                    </div>
                    <Select v-model="formInline.field_type" placeholder="请选择字段类型" @on-change="selectFieldType"  style="width: 319px">
                        <Option value="">请选择字段类型</Option>
                        <Option value="text">单行文本</Option>
                        <Option value="textarea">多行文本</Option>
                        <Option value="editor">编辑器</Option>
                        <Option value="box">选项</Option>
                        <Option value="image">图片</Option>
                        <Option value="number">数字</Option>
                        <Option value="datetime">日期和时间</Option>
                        <Option value="uploadfile">文件上传</Option>
<!--                        <Option value="omnipotent">万能字段</Option>-->
                    </Select>
                </FormItem>
                <FormItem label="作为主表字段" prop="mode_status">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">作为主表字段</Col>
                            <Col span="24" class="label-info"></Col>
                        </Row>
                    </div>
                    <RadioGroup v-model="formInline.field_system">
                        <Radio label="1">是</Radio>
                        <Radio label="2">否</Radio>
                    </RadioGroup>
                </FormItem>
                <FormItem label="字段名" prop="field_name">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">字段名</Col>
                            <Col span="24" class="label-info">只能由英文字母、数字和下划线组成，并且仅能字母开头，不以下划线结尾</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.field_name" style="width: 319px"></Input>
                </FormItem>
                <FormItem label="字段别名" prop="field_nick_name" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">字段别名</Col>
                            <Col span="24" class="label-info">例如：文章标题</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.field_nick_name" style="width: 319px"></Input>
                </FormItem>
                <FormItem label="字段提示" prop="field_tips">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">字段提示</Col>
                            <Col span="24" class="label-info">显示在字段别名下方作为表单输入提示</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.field_tips" style="width: 319px"></Input>
                </FormItem>
                <FormItem label="字段取值长度">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">字段取值长度</Col>
                            <Col span="24" class="label-info">系统将在表单提交时检测数据长度范围是否符合要求，如果不想限制长度请留空</Col>
                        </Row>
                    </div>
                    <Row>
                        <Col span="2">
                            <FormItem prop="min">
                                <Input type="text" v-model="formInline.min" ><span slot="prepend">最小值</span></Input>
                            </FormItem>
                        </Col>
                        <Col span="1" style="text-align: center;">-</Col>
                        <Col span="2">
                            <FormItem prop="max">
                                <Input type="text" v-model="formInline.max" ><span slot="prepend">最大值</span></Input>
                            </FormItem>
                        </Col>
                    </Row>
                </FormItem>
                <FormItem label="字段验证正则" prop="pattern">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">字段验证正则</Col>
                            <Col span="24" class="label-info">系统将通过此正则校验表单提交的数据合法性,如：验证数字/^[0-9.-]+$/.如果不想校验数据请留空</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.pattern" placeholder="提交时的正则验证。如：验证数字/^[0-9.-]+$/" style="width: 319px"></Input>
                </FormItem>
                <FormItem label="字段样式名称" prop="field_css">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">字段样式名称</Col>
                            <Col span="24" class="label-info">定义表单的CSS样式名</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.field_css" placeholder="最多20个英文字符" style="width: 319px"></Input>
                </FormItem>
            </Card>
            <Card :bordered="false" dis-hover  style="margin-bottom: 90px;" v-if="currentRole !==''" >
                <div id='attrInfo'></div>
                <p slot="title">
                    字段属性
                </p>
                <!--组件开始-->
                <keep-alive>
                    <component :is="currentRole" ref='formInfo'/></component>
                </keep-alive>
                <!--组件结束-->
            </Card>
            <div class="addBtn">
                <div>
                    <Button type="primary" @click="addBtn" size="large">添加</Button>
                </div>
            </div>
        </Form>
    </div>
</template>

<script>
    // 引入子组件
    import formText from '../../../components/fieldsForm/text'
    import formTextarea from '../../../components/fieldsForm/textarea'
    import formEditor from '../../../components/fieldsForm/editor'
    import formBox from '../../../components/fieldsForm/box'
    import formImage from '../../../components/fieldsForm/image'
    import formDatetime from '../../../components/fieldsForm/datetime'
    import formUploadfile from '../../../components/fieldsForm/uploadfile'

    export default {
        components: {
            formText,
            formTextarea,
            formEditor,
            formBox,
            formImage,
            formDatetime,
            formUploadfile
        },
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
                    field_type: '',
                    field_name:'',
                    field_nick_name:'',
                    field_system:'2',
                    field_tips:'',
                    min:'',
                    max:'',
                    pattern:'',
                    field_css:''
                },
                ruleInline:{
                    field_type: [
                        { required: true, message: '请选择字段类型', trigger: 'blur' }
                    ],
                    field_name: [
                        { required: true, message: '请输入字段名称.', trigger: 'blur' },
                        { type: 'string', max: 10, message: '字段名称最多10个字符',trigger: 'blur' },
                        { pattern: /^[A-Za-z]+$/, message: '字段名称必须为英文', trigger: 'blur' }
                    ],
                    field_nick_name: [
                        { required: true, message: '请输入字段别名.', trigger: 'blur' },
                        { type: 'string', max: 10, message: '字段别名最多10个字符',trigger: 'blur' }
                    ],
                    field_tips: [
                        { type: 'string', max: 10, message: '字段提示最多20个字符',trigger: 'blur' }
                    ],
                    min: [{type: 'number', message: '最小值必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                    max: [{type: 'number', message: '最大值必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                    field_css: [
                        { type: 'string', max: 10, message: '字段样式名称最多10个字符',trigger: 'blur' },
                        { pattern: /^\w+$/, message: '字段样式名称由数字、26个英文字母或者下划线组成', trigger: 'blur' }
                    ],
                },
                currentRole: ''//当前使用的组件
            }
        },
        methods: {
            //选择字段类型
            selectFieldType:function (fieldType) {
                let that = this;
                 // this.formInline.field_type = field_type;
                if(fieldType == 'text'){
                    this.currentRole = 'formText'
                }else if(fieldType == 'textarea') {
                    this.currentRole = 'formTextarea'
                }else if(fieldType == 'editor') {
                    this.currentRole = 'formEditor'
                }else if(fieldType == 'box') {
                    this.currentRole = 'formBox'
                }else if(fieldType == 'image') {
                    this.currentRole = 'formImage'
                }else if(fieldType == 'datetime') {
                    this.currentRole = 'formDatetime'
                }else if(fieldType == 'uploadfile') {
                    this.currentRole = 'formUploadfile'
                }
                else{
                    this.currentRole = ''
                }
            },
            //点击提交字段信息
            addBtn(){
                let that = this;
                that.$refs["formValidate"].validate((valid) => {
                    if (valid) {
                        that.$refs['formInfo'].$refs['formValidate'].validate((valid1)=>{
                            if (valid1) {
                               let  basicInfo = that.formInline;//字段基本信息
                               let  fieldInfo = that.$refs['formInfo'].formInline;//字段属性信息
                                console.log(fieldInfo);
                                that.$Message.success('提交成功!');
                                // that.submitData(that);
                            }else{
                                document.querySelector("#attrInfo").scrollIntoView(true);
                                that.$Message.error('字段属性表单验证失败');
                            }
                        })

                    }else{
                        document.querySelector("#basicInfo").scrollIntoView(true);
                        that.$Message.error('字段基本属性表单验证失败');
                    }
                })
            },
            //提交信息请求
            submitData(that){
                //子组件的字段属性数据
                let fieldAttribute = that.$refs['formInfo'].formInline;
                let fieldInfo      = that.formInline;
                that.$Message.success('提交成功!');
            },
        }
    }
</script>
<style scoped>
    @import "../../../assets/style/addFields.css";
</style>