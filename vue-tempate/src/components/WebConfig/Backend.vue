<template>
    <div>
        <Form ref="backendForm"
              :label-width="250"
              :model="formInline"
              :rules="formRule"
              label-position="left"
              :hide-required-mark="true">
            <Card style="margin-bottom: 10px;">
                <p slot="title">基础配置</p>
                <FormItem prop="webName">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">站点名称</Col>
                            <Col span="24" class="label-info">最多20个字符</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.webName" style="width: 400px"></Input>
                </FormItem>
                <FormItem prop="webLogo" >
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-name">站点logo</Col>
                            <Col span="24" class="label-info">建议图片大小 230 * 60；</Col>
                        </Row>
                    </div>
                    <!--单图片上传组件-->
                    <UploadOneImg :img="formInline.webLogo"
                                  form="input"
                                  uploadBtnText ="上传logo"
                                  :accept="['png']"
                                  @uploadImg="uploadImg" >
                    </UploadOneImg>
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
            return {
                type:2,//1前台，2后台
                formInline:{
                    webName:'',
                    webLogo:'',
                },
                formRule:{
                    webName: [
                        { type: 'string', max: 20, message: '站点名称最多20个字符',trigger: 'blur' },
                    ],
                },
            }
        },
        methods: {
            //通过子组件传过来的地址修改
            uploadImg(data){
                this.formInline.webLogo = data;
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