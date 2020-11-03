<template>
    <div>
            <Card :bordered="false" dis-hover  style="margin-bottom: 90px">
                    <!--站点配置开始-->
                        <Form ref="formValidate" :label-width="120"  :model="formInline" :rules="formRuleInline" label-position="left">
                            <FormItem prop="name" label="角色名称">
                                <Input type="text" v-model="formInline.name" maxlength="10" show-word-limit style="width: 400px"></Input>
                            </FormItem>
                            <FormItem prop="desc" label="角色备注">
                                <Input type="textarea" v-model="formInline.desc" maxlength="20" show-word-limit  style="width: 400px"></Input>
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
                            <Button type="primary" @click="addRole('formValidate')">添加角色</Button>
                        </Form>
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
    @import "../../../assets/style/addFields.css";
</style>