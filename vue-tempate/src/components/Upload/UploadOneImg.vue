<template>
    <div class="upload-pic">
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
                :format="['jpg','jpeg','png']"
                :max-size="1024 * 1024 * 2"
                :action="postUrl"
                :headers="requestHeader"
                :on-success="uploadSuccess"
                :on-format-error="formatError"
                :on-exceeded-size="exceededSizeError">
            <Button icon="md-camera">修改头像</Button>
        </Upload>

        <Modal title="查看头像" v-model="visible" :draggable="true" :footer-hide="true">
            <img :src="imgUrl" v-if="visible" style="width: 100%">
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
</style>
<script>
    export default {
        name: 'UploadOneImg',
        props: {
            // 图片地址
            img: {
                type: String,
                default:''
            },
        },
        data() {
            return {
                requestHeader: '',//附件上传请求头
                imgUrl:'',
                visible: false,
            }
        },
        watch: {
            img(){
                this.imgUrl = this.img;
            }
        },
        mounted: function() {},
        created() {
            // 设置文件按上传请求头
            this.postUrl = 'v1/'+this.HTTPURL.UPLOAD.UPLOAD_ONE_IMG;
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
                    content:'只能上传jpeg、png、jpg格式',
                })
            },
            exceededSizeError () {
                this.$Message.error({
                    content:'只能上传不大于2M的图片',
                })
            },


        }
    }
</script>