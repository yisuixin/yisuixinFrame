<template>
    <Card :bordered="false" dis-hover>
        <p slot="title">
            <Icon type="md-options"></Icon>&nbsp;安全信息
        </p>
            <!--安全信息开始-->
                <Form ref="passwordInline" :model="passwordInline" :rules="passwordruleInline" label-position="top">
                    <FormItem prop="oldPass" label="旧密码">
                        <Input type="password" v-model="passwordInline.oldPass" placeholder="请输入旧密码" style="width:550px;"></Input>
                    </FormItem>
                    <FormItem prop="newPass" label="新密码">
                        <Input type="password" v-model="passwordInline.newPass" placeholder="请输入新密码" style="width:550px;"></Input>
                    </FormItem>
                    <FormItem prop="newPassAgain" label="重复新密码">
                        <Input type="password" v-model="passwordInline.newPassAgain" placeholder="请再次输入新密码" style="width:550px;"></Input>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" :loading="editPass.loading" @click="handleSubmit('passwordInline')">{{editPass.txt}}</Button>
                    </FormItem>
                </Form>
            <!--安全信息结束-->
    </Card>
</template>
<script>
  export default {
    data () {
        const validateNewPassAgain = (rule, value, callback) => {
            if (value.trim() === '') {
                return callback(new Error('重复新密码不能为空'))
            } else if (value !== this.passwordInline.newPass) {
                return callback(new Error('新密码和重复新密码不一致'))
            } else {
                callback()
            }
        };
        return {
            editPass:{
                loading:false,
                txt:'修改密码'
            },
            passwordInline: {
                oldPass:'',
                newPass: '',
                newPassAgain: '',
            },
            passwordruleInline: {
                oldPass: [
                    { required: true, message: '请输入旧密码', trigger: 'blur' },
                ],
                newPass: [
                    { required: true, message: '请输入新密码', trigger: 'blur' },
                    { type: 'string', min: 6, message: '新密码不能少于为6个字符', trigger: 'blur' },
                    { type: 'string', max: 15, message: '新密码最多为15个字符', trigger: 'blur' }
                ],
                newPassAgain: [
                    { required: true, message: '重复新密码不能为空.', trigger: 'blur' },
                    { type: 'string', max:15, message: '重复新密码最多为15个字符', trigger: 'blur' },
                    {validator: validateNewPassAgain }
                ]
            }
        }
    },
      methods: {
          //修改密码
          handleSubmit(name) {
              const that = this;
              that.$refs[name].validate((valid) => {
                  if (valid) {
                      that.editPass.txt = '正在修改密码...';
                      that.editPass.loading = true;
                      let successCallback = function(res){
                          that.$Message.info({
                              content:'修改成功,请重新登录',
                              onClose:function () {
                                  that.$refs[name].resetFields();
                                  that.editPass.loading = false;
                                  that.editPass.txt = '修改密码';
                                  that.$router.replace('/login')
                              }
                          })
                      }
                      let failCallback = function(res){
                          that.$Message.error({
                              content:res.data.message,
                              onClose:function () {
                                  that.editPass.loading = false;
                                  that.editPass.txt = '修改密码';
                              }
                          })
                      }
                      that.HTTPJS.post(that.HTTPURL.USER.EDIT_USER_PASS,that.passwordInline,successCallback,failCallback);
                  }
              })
          }
      }
  }
</script>
<style scoped>
  @import "../../assets/style/category.css";
</style>