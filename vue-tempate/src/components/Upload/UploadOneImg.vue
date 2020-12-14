<template>
    <div class="upload-pic">
        <!-- 头像形式-->
       <div v-if="form == 'avatar'">
            <div class="demo-upload-list"  v-if="imgUrl != ''">
                <template>
                    <img :src="imgUrl">
                    <div class="demo-upload-list-cover">
                        <Icon type="ios-eye-outline" @click.native="handleView()"></Icon>
                    </div>
                </template>
            </div>
            <template v-else>
                <Avatar shape="square"
                        icon="ios-person"
                        size="90"
                        :src="imgUrl"
                        style="margin-bottom: 20px;"/>
            </template>
            <Upload :show-upload-list="false"
                    :format="accept"
                    :max-size="maxSize"
                    :action="postUrl"
                    :headers="requestHeader"
                    :on-success="uploadSuccess"
                    :on-format-error="formatError"
                    :on-exceeded-size="exceededSizeError">
                <Button icon="md-camera">{{uploadBtnText}}</Button>
            </Upload>
<!--            <Modal title="查看头像" v-model="visible" :draggable="true" :footer-hide="true">-->
<!--                <img :src="imgUrl" v-if="visible" style="width: 100%">-->
<!--            </Modal>-->
        </div>
        <!--input形式-->
        <div v-else-if="form == 'input'" class="input-upload-box">
            <Row>
                <Col span="6">
                    <Input v-model="img" :disabled="true"  class="upload-input">
                        <span  slot="append">
                             <Upload :action="postUrl"
                                     :format="accept"
                                     :max-size="maxSize"
                                     :headers="requestHeader"
                                     :show-upload-list="false"
                                     :on-success="uploadSuccess"
                                     :on-format-error="formatError"
                                     :on-exceeded-size="exceededSizeError">
                                <Button type="primary" icon="ios-cloud-upload-outline" title="点击上传图片">{{uploadBtnText}}</Button>
                            </Upload>
                        </span>
                    </Input>
                </Col>
                <Col span="12">
                    <Button @click.native="handleView()">{{viewBtnText}}</Button>
                </Col>
            </Row>
        </div>
        <Modal title="查看图片" v-model="visible" :draggable="true" :footer-hide="true">
            <div class="view-pic-box">
                <img :src="img" v-if="visible" style="width: 100%">
            </div>
        </Modal>
    </div>

</template>
<style>
    .demo-upload-list{
        display: inline-block;
        width: 90px;
        height: 90px;
        text-align: center;
        line-height: 90px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
    .input-upload-box .ivu-upload-list{
        margin-top: 0 !important;
    }
    .upload-input{
        width: 300px;
    }
</style>
<script>
    export default {
        name: 'UploadOneImg',
        props: {
            //上传样式，avatar头像样式；input输入框样式
            form:{
                type:String,
                default:'avatar'
            },
            // 默认图片地址
            img: {
                type: String,
                default:''
            },
            //uploadBtnText，上传按钮名称
            uploadBtnText: {
                type: String,
                default:'上传图片'
            },
            //viewBtnText，预览按钮名称
            viewBtnText: {
                type: String,
                default:'预览'
            },
            //上传图片文件大小限制，单位 kb
            maxSize: {
                type: Number,
                default:1024
            },
            //上传图片文件格式限制
            accept: {
                type: Array,
                default: function () {
                    return ['png','jpg','jpeg']
                }
            },
        },
        data() {
            return {
                requestHeader: '',//附件上传请求头
                imgUrl:'',
                visible: false,
                postUrl: 'api'+this.HTTPURL.COMMON.UPLOAD.UPLOAD_ONE_IMG
            }
        },
        watch: {
            img: function() {
                console.log(this.imgUrl)
                this.imgUrl = this.img;
            }
            // img(){
            //     this.imgUrl = this.img;
            // }
        },
        mounted: function() {},
        created() {
            // 设置文件按上传请求头
            this.requestHeader = {
                'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
            }
        },
        methods: {
            //上传成功的钩子函数
            uploadSuccess(res, file, fileList){
                const that = this;
                if(res.code == 200){
                    if(res.data.status == 1){
                        that.$Message.success({
                            content:'上传成功',
                            onClose:function () {
                                that.imgUrl = res.data.data;
                                that.$emit('uploadImg',res.data.data)
                            }
                        })
                    }else{
                        that.$Message.error({
                            content:res.data.message,
                        })
                    }
                }
            },
            handleView () {
                this.visible = true;
            },
            formatError () {
                this.$Message.error({
                    content:'上传格式错误',
                })
            },
            exceededSizeError () {
                this.$Message.error({
                    content:'超过文件上传大小',
                })
            },


        }
    }
</script>