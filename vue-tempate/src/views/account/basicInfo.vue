<template>

    <Card :bordered="false" dis-hover>
        <p slot="title">
            <Icon type="md-options"></Icon>&nbsp;基本信息
        </p>
            <!--基本信息开始-->
                <Form ref="formInline" :model="formInline" :rules="ruleInline" label-position="top">
                <Row :gutter="10">
                    <Col span="9">
                            <FormItem prop="username" label="用户名(登录名)">
                                <Input type="text" v-model="formInline.username"  disabled style="width:550px;"></Input>
                            </FormItem>
                            <FormItem prop="nickname" label="昵称">
                                <Input type="text" v-model="formInline.nickname" placeholder="请输入昵称" style="width:550px;"></Input>
                            </FormItem>
                            <FormItem prop="email" label="邮箱">
                                <Input type="text" v-model="formInline.email" placeholder="请输入邮箱" style="width:550px;"></Input>
                            </FormItem>
                            <FormItem prop="mark" label="个人介绍">
                                <Input type="textarea" v-model="formInline.mark" placeholder="请输入个人介绍" style="width:550px;"></Input>
                            </FormItem>
                            <FormItem>
                                <Button type="primary" :loading="editBasic.loading" @click="handleSubmit('formInline')">{{editBasic.txt}}</Button>
                            </FormItem>
                    </Col>
                    <Col span="15">
                        <FormItem prop="avatar" label="头像">
                            <div slot="label">
                                <Poptip trigger="hover" word-wrap width="200" content="只能上传jpg、jpeg、png格式;大小不能超过2M" :transfer="true">
                                    <Icon type="ios-alert-outline" />
                                </Poptip>
                                <span> 头像</span>
                            </div>
                            <!--单图片上传组件-->
                            <UploadOneImg :img="formInline.avatar" form="avatar"  uploadBtnText ="上传头像" @uploadImg="uploadImg"></UploadOneImg>
                        </FormItem>
                    </Col>
                </Row>
                </Form>
            <!--基本信息结束-->
    </Card>

</template>
<script>
  import UploadOneImg from '../../components/Upload/UploadOneImg'
  export default {
      components: {UploadOneImg},
    data () {
        return {
            editBasic:{
                loading:false,
                txt:'更新信息'
            },
            formInline: {
                username:'',
                nickname: '',
                email: '',
                mark:'',
                avatar:''
            },
            ruleInline: {
                nickname: [
                    { required: true, message: '请输入昵称', trigger: 'blur' },
                    { type: 'string', max: 8, message: '昵称最多为8个字符', trigger: 'blur' }
                ],
                email: [
                    { required: true, message: '请输入邮箱地址', trigger: 'blur' },
                    { type: 'email', message: '邮箱地址格式错误', trigger: 'blur' }
                ],
                mark: [
                    { type: 'string', max:30, message: '个人描述最多30个字符', trigger: 'blur' }
                ]
            },
        }
    },
      activated() {
        this.getUserInfo();
      },
      methods: {
          //通过子组件传过来的地址修改
          uploadImg(data){
              this.formInline.avatar = data;
          },
        //获取个人信息
        getUserInfo(){
            const that =this;
            let successCallback = function(res){
                that.formInline = res.data.data;
            }
            that.HTTPJS.get(that.HTTPURL.COMMON.ACCOUNT.GET_USER_INFO,{},successCallback);
        },
        //修改基本信息
          handleSubmit(name) {
              const that =this;
              this.$refs[name].validate((valid) => {
                  if (valid) {
                      that.editBasic.txt = '正在修改信息...';
                      that.editBasic.loading = true;
                      let successCallback = function(res){
                          that.$Message.info({
                              content:'修改成功',
                              onClose:function () {
                                  that.editBasic.loading = false;
                                  that.editBasic.txt = '更新信息';
                                  sessionStorage.setItem('userInfo',JSON.stringify(res.data.data));
                              }
                          })
                      }
                      let failCallback = function(res){
                          that.$Message.error({
                              content:res.data.message,
                              onClose:function () {
                                  that.editBasic.loading = false;
                                  that.editBasic.txt = '更新信息';
                              }
                          })
                      }
                      that.HTTPJS.post(that.HTTPURL.COMMON.ACCOUNT.EDIT_USER_INFO,that.formInline,successCallback,failCallback);
                  }
              })
          },
      }
  }
</script>
<style scoped>
  @import "../../assets/style/category.css";
</style>