<template>
    <div>
        <Card :bordered="false">
            <p slot="title">
                <Icon type="ios-color-palette"></Icon>
                <span class="serve-info" style="margin-right: 25px;">&nbsp;主题列表<span style="font-size: 12px;">(共2套模板)</span></span>
            </p>
            <Row :gutter="8">
                <Col span="4">
                    <div class="theme-list">
                        <Col span="24">
                            <img src="../../../assets/img/preview.jpg" alt="">
                        </Col>
                        <Col span="24">
                            <span class="theme-title">主题1</span>
                        </Col>
                    </div>
                </Col>
                <Col span="4">
                    <div class="theme-list">
                        <Col span="24">
                            <img src="../../../assets/img/preview.jpg" alt="" >
                        </Col>
                        <Col span="24">
                            <span class="theme-title">主题2</span>
                        </Col>
                    </div>
                </Col>

            </Row>
        </Card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                formInline:{
                    name:'',
                    desc:'',
                    status:'1',
                },
                formRuleInline:{
                    name: [
                        { required: true, message: '请输入角色名称', trigger: 'blur' },
                        { type: 'string', max: 10, message: '角色名称最多10个字符',trigger: 'blur' }
                    ],
                    desc: [
                        { type: 'string', max: 20, message: '角色备注最多20个字符',trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            addRole(name){
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Message.success('Success!');
                    }
                })
            },
        }
    }
</script>
<style scoped>
    @import "../../../assets/style/theme.css";
</style>