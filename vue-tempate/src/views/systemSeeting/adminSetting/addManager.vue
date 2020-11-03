<template>
    <div>
            <Card :bordered="false" dis-hover  style="margin-bottom: 90px">
                    <!--站点配置开始-->
                        <Form ref="formValidate" :label-width="120"  :model="formInline" :rules="formRuleInline" label-position="left">
                            <FormItem prop="name" label="用户名">
                                <Input type="text" v-model="formInline.name" maxlength="10" show-word-limit style="width: 400px"></Input>
                            </FormItem>
                            <FormItem prop="password" label="密码">
                                <Input type="password" v-model="formInline.password" maxlength="20" show-word-limit style="width: 400px"></Input>
                            </FormItem>
                            <FormItem prop="configPassword" label="确认密码">
                                <Input type="password" v-model="formInline.configPassword" maxlength="20" show-word-limit  style="width: 400px"></Input>
                            </FormItem>
                            <FormItem prop="desc" label="备注">
                                <Input type="textarea" v-model="formInline.desc" maxlength="20" show-word-limit  style="width: 400px"></Input>
                            </FormItem>
                            <FormItem prop="role" label="所属角色">
                                <Select v-model="formInline.role" style="width:400px">
                                    <Option value="">作为一级菜单</Option>
                                    <Option value="1" label="一级菜单1"></Option>
                                    <Option value="2" label="一级子菜单1"></Option>
                                    <Option value="3" label="一级子菜单2"></Option>
                                </Select>
                            </FormItem>
                            <FormItem prop="status" label="状态">
                                <RadioGroup v-model="formInline.status">
                                    <Radio label="1">
                                        <span>启用</span>
                                    </Radio>
                                    <Radio label="2">
                                        <span>禁用</span>
                                    </Radio>
                                </RadioGroup>
                            </FormItem>
                            <Button type="primary" @click="addManager('formValidate')">添加管理员</Button>
                        </Form>
            </Card>
    </div>
</template>

<script>
    export default {
        data() {
            const validateNewPassAgain = (rule, value, callback) => {
                if (value.trim() === '') {
                    return callback(new Error('重复新密码不能为空'))
                } else if (value !== this.formInline.configPassword) {
                    return callback(new Error('密码和确认密码不一致'))
                } else {
                    callback()
                }
            };
            return {
                formInline:{
                    name:'',
                    password:'',
                    configPassword:'',
                    desc:'',
                    role:'',
                    status:'1',
                },
                formRuleInline:{
                    name: [
                        { required: true, message: '请输入用户名', trigger: 'blur' },
                        { type: 'string', max: 10, message: '用户名最多10个字符',trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' },
                        { type: 'string', max: 20, message: '密码最多20个字符',trigger: 'blur' }
                    ],
                    configPassword: [
                        { required: true, message: '请输入确认密码', trigger: 'blur' },
                        { type: 'string', max: 20, message: '确认密码最多20个字符',trigger: 'blur' },
                        {validator: validateNewPassAgain }
                    ],
                    desc: [
                        { type: 'string', max: 20, message: '备注最多20个字符',trigger: 'blur' }
                    ],
                    role: [
                        { required: true, message: '所属角色不能为空', trigger: 'blur' }
                    ],
                }
            }
        },
        methods: {
            addManager(name){
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
    @import "../../../assets/style/addFields.css";
</style>