<template>
    <div>
        <Card :bordered="false" dis-hover style="margin-bottom: 10px;">
            <div class="category-btn-list">
                <Form ref="search" :model="roleData.search" :label-width="100">
                    <Row>
                        <Col span="6">
                            <FormItem label="关键字："prop="keys">
                                <Input type="text" v-model="roleData.search.keys" placeholder="请输入关键字"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="状态：" prop="status" >
                                <Select v-model="roleData.search.status" >
                                    <Option value="" >全部</Option>
                                    <Option value="1" >已启用</Option>
                                    <Option value="2" >已禁用</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="8">
                            <FormItem>
                                <Col span="4"><Button type="primary"  @click="searchClick('1')">搜索</Button></Col>
                                <Col span="4"><Button type="default"  @click="searchClick('2')">重置</Button></Col>
                            </FormItem>
                        </Col>
                    </Row>
                </Form>
            </div>
        </Card>
        <Card :bordered="false" dis-hover>
            <div class="category-btn-list">
                <Button type="primary" icon="md-add" style="margin-right: 10px;" @click="addModeShow(1,'')" v-auth="`add_role`">添加角色</Button>
            </div>
            <Table :border="false" :columns="roleData.columns" :data="roleData.list" :loading="roleData.loading">
                <template slot-scope="{ row, index }" slot="action">
                    <div v-if="row.type == 1">
                        <span style="color: #c5c8ce;">超级管理员无法操作</span>
                    </div>
                    <div v-else>
                        <span class="span-but-list" @click="addModeShow(2,row.id)"  v-auth="`add_role`">编辑 &nbsp;| &nbsp;</span>
                        <Poptip   v-auth="`del_role`"
                                transfer
                                confirm
                                title="确定删除此角色?"
                                @on-ok="deleteMenu(row.id,index)">
                            <span class="span-but-list">删除</span>
                        </Poptip>&nbsp;| &nbsp;
                        <span class="span-but-list" @click="showWebRoleModel(1,row.id);"   v-auth="`add_role_permis`">整站权限设置&nbsp;| &nbsp;</span>
                        <span class="span-but-list">栏目权限设置</span>
                    </div>
                </template>
            </Table>
            <div class="page-box">
                <Page :total='roleData.count'
                      show-elevator
                      show-sizer
                      show-total
                      @on-change="rolePageChange"
                      @on-page-size-change = "rolePageSizeChange"/>
            </div>
        </Card>
        <!--添加管理员对话框-->
        <Modal v-model="modeAdd.show"
               :loading="modeAdd.loading"
               :title=modeAdd.title
               :closable="false"
               :mask-closable="false"
               @on-cancel="event.model = false"
               @on-ok="addMode">
            <Form ref="formValidate" :model="modeAdd.formInline" :rules="modeAdd.ruleValidate" :label-width="95">
                <FormItem label="角色名称" prop="name">
                    <Input type="text" v-model="modeAdd.formInline.name" placeholder="角色名称最多8个字符">
                    </Input>
                </FormItem>
                <FormItem label="角色描述" prop="mark">
                    <Input v-model="modeAdd.formInline.mark" placeholder="角色描述最多30个字符"></Input>
                </FormItem>
                <FormItem label="状态" prop="status">
                    <RadioGroup v-model="modeAdd.formInline.status" :true-value="Number" :false-value="Number">
                        <Radio label="1">启用</Radio>
                        <Radio label="2">禁用</Radio>
                    </RadioGroup>
                </FormItem>
            </Form>
            <div slot="footer">
                <Button  @click="addModeShow(3,'')">取消</Button>
                <Button type="primary" :loading = "modeAdd.loading" @click="addMode('formValidate')">确定</Button>
            </div>
        </Modal>
        <!--添加管理员对话框-->
        <!--整站权限设置对话框开始-->
        <!--单图片上传组件-->
        <WebPermissionList ref="WebPermissionListModel"></WebPermissionList>
        <!--整站权限设置对话框结束-->
    </div>
</template>
<script>
    import WebPermissionList from '../../../components/Menu/WebPermissionListModel'
    export default {
        components: {WebPermissionList},
        data () {
            return {
                modeAdd:{
                    show:false,
                    loading: false,
                    title:'添加角色',
                    formInline: {
                        id:'',
                        is_add:1,//1新增2编辑
                        name: '',
                        mark:'',
                        status: '1'
                    },
                    ruleValidate: {
                        name: [
                            { required: true, message: '请输入角色名称', trigger: 'blur' },
                            { type: 'string', max: 6, message: '角色名称最多8个字符', trigger: 'blur' },
                        ],
                        mark: [
                            { type: 'string', max: 30, message: '角色描述最多30个字符', trigger: 'blur' }
                        ],

                    }
                },
                roleData:{
                    loading:true,
                    search:{
                        page:1,
                        keys:'',
                        status:'',
                        pageSize:this.COMMONJS.pageSize,
                    },
                    count: 0,
                    list: [],
                    columns: [
                        {
                            title: 'ID',
                            key: 'id',
                            width:100,
                            align:'center'
                        },
                        {
                            title: '角色名称',
                            key: 'name',
                            width:400,
                            align:'left'
                        },
                        {
                            title: '备注',
                            key: 'mark',
                            width:400,
                            align:'left'
                        },
                        {
                            title: '状态',
                            key: 'status',
                            width:200,
                            align:'center',
                            render: (h, params) => {
                                const roleData = this.roleData.list;
                                if(roleData[params.index].status == this.COMMONJS.roleStatus.oneStatus){
                                    return h('span', {
                                        style: {
                                            color:'#19be6b'
                                        },
                                    }, '已启用')
                                }else{
                                    return h('span', {
                                        style: {
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
                // roleModel:{
                //     // listLoading:false,
                //     // okBtnLoading:false,
                //     roleId:'',
                //     show:false,
                //     tree:[],
                // },
            }
        },
        activated() {
            this.getRoleList();
        },
        methods: {
            //分页
            rolePageChange(page){
                this.roleData.loading = true;
                this.roleData.search.page = page;
                this.getRoleList();
            },
            //切换条数
            rolePageSizeChange(pageSize){
                this.roleData.loading = true;
                this.roleData.search.pageSize = pageSize;
                this.getRoleList();
            },
            getRoleList:function(){
                const that = this;
                let successCallback = function(res){
                    that.roleData.loading = false;
                    that.roleData.count = res.data.data.count;
                    that.roleData.list = res.data.data.list;
                }
                let failCallback = function(res){
                    that.roleData.loading = false;
                }
                that.HTTPJS.get(that.HTTPURL.SYSTEM_SEETING.ROLE.GET_ROLE_LIST,that.roleData.search,successCallback,failCallback);
            },
            //点击添加角色
            addModeShow:function(type,id){
                if(type == 1){
                    this.modeAdd.show = true;
                    this.modeAdd.title = '添加角色';
                }else if(type == 2){
                    this.modeAdd.title = '编辑角色';
                    this.getRoleInfo(id);
                    this.modeAdd.formInline.id = id;
                    this.modeAdd.formInline.is_add = 2;
                    this.modeAdd.show = true;
                }else{
                    this.modeAdd.title = '添加角色';
                    this.modeAdd.show = false;
                    this.$refs["formValidate"].resetFields();//重置表单
                }
            },
            //获取数据编辑
            getRoleInfo(id){
                const that = this;
                let successCallback = function(res){
                    that.modeAdd.formInline = res.data.data;
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:'数据获取失败'
                    })
                }
                that.HTTPJS.get(that.HTTPURL.SYSTEM_SEETING.ROLE.GET_ROLE_INFO,{id:id},successCallback,failCallback);
            },
            //增加或者编辑角色
            addMode:function(name){
                const that = this;
                this.$refs[name].validate((valid,errors) => {
                    if (valid) {
                        that.modeAdd.loading = true;
                        let successCallback = function(res){
                            that.$Message.info({
                                content:res.data.message,
                                onClose:function () {
                                    that.modeAdd.loading = false;
                                    that.getRoleList();
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
                        that.HTTPJS.post(that.HTTPURL.SYSTEM_SEETING.ROLE.ADD_ROLE,that.modeAdd.formInline,successCallback,failCallback);
                    }
                })
            },
            //删除角色
            deleteMenu:function(id,index){
                const that =this;
                let successCallback = function(res){
                    that.$Message.info({
                        content:'删除成功',
                        onClose:function () {
                            that.roleData.list.splice(index, 1);
                        }
                    })
                }
                let failCallback = function(res){
                    that.$Message.error(res.data.message);
                }
                that.HTTPJS.post(that.HTTPURL.SYSTEM_SEETING.ROLE.DELETE_ROLE,{id:id},successCallback,failCallback);
            },
            //点击搜索 type == 1搜索，2重置
            searchClick:function (type) {
                if(type == 1){
                    this.roleData.search.page = 1;
                    this.roleData.list = [];
                    this.roleData.loading = true;
                    this.getRoleList();
                }else{
                    this.roleData.search.page = 1;
                    this.roleData.list = [];
                    this.roleData.loading = true;
                    this.$refs["search"].resetFields();//重置表单
                    this.getRoleList();
                }
            },
            //显示整站权限设置对话框
            showWebRoleModel:function(type,roleId){//type == 1显示，2关闭
                    this.$refs.WebPermissionListModel.showWebRoleModel(type,roleId)

             },

        }
    }
</script>
<style scoped>
    @import "../../../assets/style/category.css";
</style>