<template>
    <div class="page login-page">
        <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
                <div class="row">
                    <!-- Logo & Information Panel-->
                    <div class="col-lg-6">
                        <div class="info d-flex align-items-center">
                            <div class="content">
                                <div class="logo1">
                                    <h1>欢迎登录</h1>
                                </div>
                                <p>YsuixinCMS管理系统</p>
                            </div>
                        </div>
                    </div>
                    <!-- Form Panel    -->
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <Form ref="formInline"
                                      :model="formInline"
                                      :rules="ruleInline"
                                      class="form-validate"
                                      :show-message="false" @keydown.native.enter="handleSubmit('formInline')">
                                    <FormItem prop="username">
                                        <input type="text"  placeholder="请输入登录名称" class="input-material" v-model="formInline.username">
                                    </FormItem>
                                    <FormItem prop="password">
                                        <input type="password" placeholder="请输入登录密码" class="input-material" v-model="formInline.password">
                                    </FormItem>
                                    <Row>
                                        <Col span="24">
                                            <FormItem prop="captchaCode">
                                                <input type="text"
                                                       placeholder="请输入验证码"
                                                       class="input-material"
                                                       @focus="changeCaptcha"
                                                       v-model="formInline.captchaCode">
                                                <div class="captcha-box">
                                                    <Spin fix v-if="captchaLoading">
                                                        <Icon type="ios-loading" size=18 class="demo-spin-icon-load" title="验证码正在加载中"></Icon>
                                                    </Spin>
                                                    <img :src="captcha.url" class="captcha" @click="changeCaptcha" v-else/>
                                                </div>

                                            </FormItem>
                                        </Col>
<!--                                        <Col span="7">-->
<!--                                            <Spin fix v-if="captchaLoading">-->
<!--                                                <Icon type="ios-loading" size=18 class="demo-spin-icon-load"></Icon>-->
<!--                                                <div>Loading</div>-->
<!--                                            </Spin>-->
<!--                                            <img :src="captcha.url" class="captcha" @click="changeCaptcha" v-else/>-->
<!--                                        </Col>-->
                                    </Row>
                                    <FormItem>
                                        <Button type="primary"
                                                @click="handleSubmit('formInline')"
                                                :loading="loginLoading"
                                                long
                                                style="height: 50px;">
                                            {{loginText}}
                                        </Button>
                                    </FormItem>
                                </Form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    @import "../../assets/style/login.css";
</style>

<style src="bootstrap/dist/css/bootstrap.min.css" scoped></style>
<script>
    import 'bootstrap/dist/js/bootstrap.min.js'
    import handleMenu from "../../assets/js/handleMenu";

    export default {
        data () {
            return {
                loginLoading:false,
                captchaLoading:false,
                loginText:'登录',
                captcha:{
                    key:'',
                    url:''
                },
                formInline: {
                    username: '',
                    password: '',
                    captchaCode:'',
                    captchaKey:''
                },
                ruleInline: {
                    username: [
                        { required: true}
                    ],
                    password: [
                        { required: true}
                    ],
                    captchaCode: [
                        { required: true}
                    ]
                }
            }
        },
        activated() {
            this.getCaptcha();
        },
        methods: {
            handleSubmit(name) {
                const that =this;
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        that.loginText = '正在登录...';
                        that.loginLoading = true;
                        let successCallback = function(res){
                                that.$Message.info({
                                    content:'登录成功',
                                    onClose:function () {
                                        let routes = handleMenu.mergeRoutes(res.data.data.vueRoute);
                                        if (that.$router.options.routes.length <= 1) {
                                            that.$router.addRoutes(routes)
                                            that.$router.options.routes.push(routes)// this.$router不是响应式的，所以手动将路由元注入路由对象
                                        }
                                        that.loginLoading = false;
                                        that.loginText = '登录';
                                        that.$refs[name].resetFields();
                                        sessionStorage.setItem('token',res.data.data.token);
                                        sessionStorage.setItem('userInfo',JSON.stringify(res.data.data.userInfo));
                                        sessionStorage.setItem('allMenu',JSON.stringify(res.data.data.menuList));
                                        sessionStorage.setItem('routeList',JSON.stringify(res.data.data.vueRoute));
                                        that.$router.push('/info')
                                    }
                                })
                        }
                        let failCallback = function(res){
                            that.$Message.error({
                                content:res.data.message,
                                onClose:function () {
                                    that.loginLoading = false;
                                    that.loginText = '登录';
                                    that.getCaptcha();
                                }
                            })
                        }
                        let otherCallback = function(res){
                            that.loginLoading = false;
                            that.loginText = '登录';
                        }
                        that.HTTPJS.post(that.HTTPURL.COMMON.ACCOUNT.USER_LOGIN,that.formInline,successCallback,failCallback,otherCallback);
                    } else {
                        this.$Message.error('请输入账号或者密码');
                    }
                })
            },
            //更新验证码
            changeCaptcha(){
                console.log(1111)
                this.getCaptcha();
            },
           //获取验证码
            getCaptcha(){
                const that = this;
                that.captchaLoading = true;
                let successCallback = function(res){
                    that.captchaLoading = false;
                    that.captcha.key = res.data.data.captchaKey;
                    that.captcha.url = res.data.data.captchaUrl;
                    that.formInline.captchaKey = res.data.data.captchaKey;
                }
                let failCallback = function(res){
                    that.captcha = '';
                    that.captchaLoading = false;
                }
                that.HTTPJS.get(that.HTTPURL.COMMON.GET_CAPTCHA,'',successCallback,failCallback);
            }
        }
    }
</script>

