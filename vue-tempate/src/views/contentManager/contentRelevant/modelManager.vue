<template>
    <div>
        <Card :bordered="false" dis-hover style="margin-bottom: 10px;">
            <div class="category-btn-list">
                <Form ref="search" :model="modelList.search" :label-width="100">
                    <Row>
                        <Col span="6">
                            <FormItem label="关键字："prop="searchKey">
                                <Input type="text" v-model="modelList.search.searchKey" placeholder="请输入标题"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="状态："prop="status">
                                <Select v-model="modelList.search.status" >
                                    <Option value="" >全部</Option>
                                    <Option value="1" >开启</Option>
                                    <Option value="2" >禁用</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="8">
                            <FormItem>
                                <Col span="4"><Button type="primary" @click="handleSubmit(1)">搜索</Button></Col>
                                <Col span="4"><Button type="default" @click="handleSubmit(2)">重置</Button></Col>
                            </FormItem>
                        </Col>
                    </Row>
                </Form>
            </div>
        </Card>
        <Card :bordered="false" dis-hover>
            <div class="category-btn-list">
                <Button type="primary" icon="md-add"  style="margin-right: 10px;"@click="addModeShow(1,'')">添加模型</Button>
            </div>
            <Table :border="false" :columns="modelList.columns" :data="modelList.list">
                <template slot-scope="{ row, index }" slot="action">
                    <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">编辑</Button>
                    <Button type="error" size="small" @click="remove(index)">删除</Button>
                </template>
                <template slot-scope="{ row }" slot="name">
                    <strong>{{ row.name }}</strong>
                </template>
                <template slot-scope="{ row, index }" slot="action">
                    <router-link to="/fieldsList">
                        <span class="span-but-list" >字段管理</span>&nbsp;
                    </router-link> | &nbsp;
                    <span class="span-but-list" @click="addModeShow(2,row.id)">编辑</span> |
                    <Poptip   v-auth="`del_role`"
                              transfer
                              confirm
                              title="确定删除此模型?"
                              @on-ok="deleteModel(row.id,index)">
                        <span class="span-but-list">删除</span>
                    </Poptip>
                </template>
            </Table>
            <div class="page-box">
                <Page :total="modelList.count"
                      show-elevator
                      show-total
                      :page-size ="modelList.search.pageSize"
                      @on-change="loginLogPageChange"
                      @on-page-size-change = "loginLogPageSizeChange"/>
            </div>

        </Card>
        <!--添加模型对话框-->
        <Modal v-model="modeAdd.show"
               :title="modeAdd.title"
               :closable="false"
               :mask-closable="false"
               @on-ok="addMode">
            <Form ref="formValidate" :model="modeAdd.formInline" :rules="modeAdd.ruleValidate" :label-width="95">
                <FormItem label="模型名称" prop="name">
                    <Input type="text" v-model="modeAdd.formInline.name" placeholder="最多10个中文字符">
                    </Input>
                </FormItem>
                <FormItem label="模型标识" prop="table_name">
                    <Input v-model="modeAdd.formInline.table_name" placeholder="最多20个英文字符"></Input>
                </FormItem>
                <FormItem label="模型描述" prop="desc">
                    <Input type="textarea" v-model="modeAdd.formInline.desc" placeholder="最多30个字符"></Input>
                </FormItem>
                <FormItem label="模型状态" prop="status">
                    <RadioGroup v-model="modeAdd.formInline.status">
                        <Radio label="1">启用</Radio>
                        <Radio label="2">禁用</Radio>
                    </RadioGroup>
                </FormItem>
            </Form>
            <div slot="footer">
                <Button  @click="addModeShow(3,'')">取消</Button>
                <Button type="primary" :loading="modeAdd.loading" @click="addMode('formValidate')">确定</Button>
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
                    return callback(new Error('请输入模型标识'))
                } else if (/[^\a-\z\A-\Z]/g.test(value)) {
                    return callback(new Error('模型标识称必须为英文'))
                } else {
                    callback()
                }
            };
            return {
                modelList:{
                    loading:true,
                    search:{
                        page:1,
                        pageSize:this.COMMONJS.pageSize,
                        searchKey:'',
                        status:'',
                    },
                    count: 0,
                    list: [],
                    columns: [
                        {
                            title: '模型ID',
                            key: 'id',
                            width:120,
                            align:'center'
                        },
                        {
                            title: '模型名称',
                            key: 'name',
                            width:200,
                            align:'left',
                        },
                        {
                            title: '模型表名称',
                            key: 'table_name',
                            width:150,
                            align:'center'
                        },
                        {
                            title: '模型描述',
                            key: 'desc',
                            width:600,
                            align:'center'
                        },
                        {
                            title: '模型状态',
                            key: 'status',
                            width:100,
                            align:'center',
                            render: (h, params) => {
                                const modeData = this.modelList.list;
                                if(modeData[params.index].status == 1){
                                    return h('span', {
                                        style: {
                                            fontSize:'14px',
                                            color:'#19be6b'
                                        },
                                    }, '已启用')
                                }else{
                                    return h('span', {
                                        style: {
                                            fontSize:'14px',
                                            color:'#ed4014'
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
                },
                modeAdd:{
                    type:1,//1添加，2编辑
                    title:'添加模型',
                    show:false,
                    loading: false,
                    formInline: {
                        name: '',
                        table_name: '',
                        desc: '',
                        status: '1'
                    },
                    ruleValidate: {
                        name: [
                            { required: true, message: '请输入模型名称', trigger: 'blur' },
                            { type: 'string', max: 10, message: '模型名称最多10个字符', trigger: 'blur' }
                        ],
                        table_name: [
                            { required: true, message: '请输入模型标识.', trigger: 'blur' },
                            { type: 'string', max: 20, message: '模型标识最多20个字符',trigger: 'blur' },
                            { required: true, trigger: 'blur', validator: validateNumber }
                        ],
                        desc: [
                            { type: 'string', max: 30, message: '模型描述最多20个字符', trigger: 'blur' }
                        ]
                    }
                },
            }
        },
        mounted() {
            this.getModelList();
        },
        methods: {
            //分页
            loginLogPageChange(page){
                this.modelList.loading = true;
                this.modelList.search.page = page;
                this.getModelList();
            },
            //切换条数
            loginLogPageSizeChange(pageSize){
                this.modelList.loading = true;
                this.modelList.search.pageSize = pageSize;
                this.getModelList();
            },
            //获取模型列表
            getModelList(){
                const that =this;
                let successCallback = function(res){
                    that.modelList.loading = false;
                    that.modelList.list = res.data.data.list;
                    that.modelList.count = res.data.data.count;
                }
                let failCallback = function(res){
                    that.modelList.loading = false;
                    that.modelList.list = [];
                }
                let otherCallback = function(res){
                    that.modelList.loading = false;
                    that.modelList.list = [];
                }
                that.HTTPJS.get(that.HTTPURL.CONTENT.MODEL.GET_MODEL_LIST,that.modelList.search,successCallback,failCallback,otherCallback);
            },
            //获取模型信息
            getModelInfo(id){
                const that =this;
                let successCallback = function(res){
                    that.modeAdd.formInline = res.data.data;
                }
                that.HTTPJS.get(that.HTTPURL.CONTENT.MODEL.GET_MODEL_INFO,{id:id},successCallback);
            },
            //点击显示添加模型框
            addModeShow:function(type,id){
                if(type == 1){//添加
                    this.modeAdd.type = 1;
                    this.modeAdd.show = true;
                    this.modeAdd.loading = false;
                }else if(type == 2){//编辑
                    this.modeAdd.type = 2;
                    this.modeAdd.show = true;
                    this.modeAdd.title = '编辑模型';
                    this.getModelInfo(id);
                }else if(type == 3){//关闭
                    this.modeAdd.type = 1;
                    this.modeAdd.show = false;
                    this.modeAdd.loading = false;
                    this.$refs["formValidate"].resetFields();//重置表单
                }
            },
            //添加模型
            addMode:function(name){
                const that = this;
                this.$refs[name].validate((valid,errors) => {
                    if (valid) {
                        that.modeAdd.loading = true;
                        let successCallback = function(res){
                            that.$Message.info({
                                content:res.data.message,
                                onClose:function () {
                                    that.getModelList();
                                    that.modeAdd.loading = false;
                                    that.addModeShow(3);
                                }
                            })
                        }
                        let failCallback = function(res){
                            that.$Message.error({
                                content:res.data.message,
                                onClose:function () {
                                    that.modeAdd.loading = false;
                                }
                            })
                        }
                        that.HTTPJS.post(that.modeAdd.type == 1 ? that.HTTPURL.CONTENT.MODEL.ADD_MODEL : that.HTTPURL.CONTENT.MODEL.EDIT_MODEL,that.modeAdd.formInline,successCallback,failCallback);
                    }
                })
            },
            //删除模型
            deleteModel:function(id,index){
                const that =this;
                let successCallback = function(res){
                    that.$Message.info({
                        content:'删除成功',
                        onClose:function () {
                            that.modelList.list.splice(index, 1);
                        }
                    })
                }
                let failCallback = function(res){
                    that.$Message.error(res.data.message);
                }
                that.HTTPJS.post(that.HTTPURL.CONTENT.MODEL.DEL_NOTICE,{id:id},successCallback,failCallback);
            },
            //点击搜索或者重置
            handleSubmit(type){
                if(type == 1){
                    this.getLoginLog();
                }else{
                    this.$refs['search'].resetFields();
                    this.getLoginLog();
                }
            }
        }
    }
</script>
<style scoped>
    @import "../../../assets/style/category.css";
</style>