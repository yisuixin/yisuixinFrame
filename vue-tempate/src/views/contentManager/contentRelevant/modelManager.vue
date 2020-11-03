<template>
    <div>
        <Card :bordered="false" dis-hover>
            <div class="category-btn-list">
                <Button type="primary" icon="md-add" @click="addModeShow(1)">添加模型</Button>
                <!--        <Button type="primary" icon="md-sync" @click="updateSort">更新排序</Button>-->
            </div>
            <Table :border="false" :columns="modeColumns" :data="modeData">
                <template slot-scope="{ row, index }" slot="action">
                    <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">编辑</Button>
                    <Button type="error" size="small" @click="remove(index)">删除</Button>
                </template>
                <template slot-scope="{ row }" slot="name">
                    <strong>{{ row.name }}</strong>
                </template>
                <template slot-scope="{ row, index }" slot="action">
                    <router-link to="/fieldsList">
                        <span class="span-but-list" >字段管理</span>&nbsp;| &nbsp;
                    </router-link>
                    <router-link to="/modeFields">
                        <span class="span-but-list" >编辑</span>&nbsp;| &nbsp;
                    </router-link>
                    <span class="span-but-list" @click="show(index)">禁用</span>&nbsp;| &nbsp;
                    <span class="span-but-list">删除</span>
                </template>
            </Table>
            <div class="page-box"><Page :total="100" show-elevator show-sizer /></div>

        </Card>
        <!--添加模型对话框-->
        <Modal v-model="modeAdd.show"
               :loading="modeAdd.loading"
               title="添加模型"
               :closable="false"
               :mask-closable="false"
               @on-ok="addMode">
            <Form ref="formValidate" :model="modeAdd.formInline" :rules="modeAdd.ruleValidate" :label-width="95">
                <FormItem label="模型名称" prop="mode_name">
                    <Input type="text" v-model="modeAdd.formInline.mode_name" placeholder="最多6个中文字符">
                    </Input>
                </FormItem>
                <FormItem label="模型表名称" prop="mode_table_name">
                    <Input v-model="modeAdd.formInline.mode_table_name" placeholder="最多10个英文字符"></Input>
                </FormItem>
                <FormItem label="模型描述" prop="mode_desc">
                    <Input type="textarea" v-model="modeAdd.formInline.mode_desc" placeholder="最多20个字符"></Input>
                </FormItem>
                <FormItem label="模型状态" prop="mode_status">
                    <RadioGroup v-model="modeAdd.formInline.mode_status">
                        <Radio label="1">启用</Radio>
                        <Radio label="2">禁用</Radio>
                    </RadioGroup>
                </FormItem>
            </Form>
            <div slot="footer">
                <Button  @click="addModeShow(2)">取消</Button>
                <Button type="primary" @click="addMode('formValidate')">确定</Button>
            </div>
        </Modal>
        <!--添加模型对话框-->
    </div>

</template>
<script>
    export default {
        data () {
            const validateNumber = (rule, value, callback) => {
                if (value.trim() === '') {
                    return callback(new Error('请输入模型表名称'))
                } else if (/[^\a-\z\A-\Z]/g.test(value)) {
                    return callback(new Error('模型表名称必须为英文'))
                } else {
                    callback()
                }
            };
            return {
                modeAdd:{
                    show:false,
                    loading: true,
                    formInline: {
                        mode_name: '',
                        mode_table_name: '',
                        mode_desc: '',
                        mode_status: '1'
                    },
                    ruleValidate: {
                        mode_name: [
                            { required: true, message: '请输入模型名称', trigger: 'blur' },
                            { type: 'string', max: 6, message: '模型名称最多6个字符', trigger: 'blur' }
                        ],
                        mode_table_name: [
                            { required: true, message: '请输入模型表名称.', trigger: 'blur' },
                            { type: 'string', max: 10, message: '模型表名称最多10个字符',trigger: 'blur' },
                            { required: true, trigger: 'blur', validator: validateNumber }
                        ],
                        mode_desc: [
                            { type: 'string', max: 20, message: '模型描述最多20个字符', trigger: 'blur' }
                        ]
                    }
                },
                modeColumns: [
                    {
                        title: '模型ID',
                        key: 'id',
                        width:120,
                        align:'center'
                    },
                    {
                        title: '模型名称',
                        key: 'mode_name',
                        width:200,
                        align:'left',
                    },
                    {
                        title: '模型表名称',
                        key: 'mode_table_name',
                        width:150,
                        align:'center'
                    },
                    {
                        title: '模型描述',
                        key: 'mode_desc',
                        width:600,
                        align:'center'
                    },
                    {
                        title: '模型状态',
                        key: 'mode_status',
                        width:100,
                        align:'center',
                        render: (h, params) => {
                            const modeData = this.modeData;
                            if(modeData[params.index].mode_status == 1){
                                return h('span', {
                                    style: {
                                        fontSize:'14px'
                                    },
                                }, '已启用')
                            }else{
                                return h('span', {
                                    style: {
                                        fontSize:'14px'
                                    },
                                }, '已禁用')
                            }
                        }
                    },
                    {
                        title: '管理操作',
                        slot: 'action',
                        align: 'center',
                        key: 'action'
                    }
                ],
                modeData: [{
                    id: 1,
                    mode_name: '栏目名称',
                    mode_table_name:'article',
                    mode_desc:'模型描述',
                    mode_status:1
                },
                    {
                        id: 2,
                        mode_name: '栏目名称2',
                        mode_table_name:'article2',
                        mode_desc:'模型描述2',
                        mode_status:2
                    }
                ],
            }
        },
        methods: {
            //点击添加模型
            addModeShow:function(type){
                if(type == 1){
                    this.modeAdd.show = true;
                }else{
                    this.modeAdd.show = false;
                    this.$refs["formValidate"].resetFields();//重置表单
                }
            },
            addMode:function(name){
                this.$refs[name].validate((valid,errors) => {
                    if (valid) {
                        this.addModeShow(2);
                        this.$Message.success('Success!');
                    }
                })
            },
        }
    }
</script>
<style scoped>
    @import "../../../assets/style/category.css";
</style>