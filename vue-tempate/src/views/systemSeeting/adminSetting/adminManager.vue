<template>
    <div>
        <Card :bordered="false" dis-hover style="margin-bottom: 10px;">
            <div class="category-btn-list">
                <Form ref="search" :model="managerData.search" :label-width="100">
                    <Row>
                        <Col span="6">
                            <FormItem label="关键字："prop="keys">
                                <Input type="text" v-model="managerData.search.keys" clearable placeholder="请输入关键字"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="状态：" prop="status" >
                                <Select v-model="managerData.search.status" >
                                    <Option value="" >全部</Option>
                                    <Option value="10" >已启用</Option>
                                    <Option value="9" >已禁用</Option>
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
                <Button type="primary" icon="md-add" style="margin-right: 10px;" @click="addModeShow(1)" v-auth="`add_manager`">添加管理员</Button>
            </div>
            <Table :border="false" :columns="managerData.columns" :data="managerData.list" :loading="managerData.loading">
                <template slot-scope="{ row, index }" slot="role">
                    <div v-if="row.roleType == 1">
                        <span style="color: #c5c8ce;">超级管理员无法操作</span>
                    </div>
                    <div v-else>
                        <Select v-model="row.roleId" v-auth-select="`change_manager_role`" transfer>
                            <Option :value="item.id.toString()" :label="item.name" v-for="(item,index) in modeAdd.role.list" :key="index">
                                <span>{{item.name}}</span>
                            </Option>
                        </Select>
                    </div>
                </template>
                <template slot-scope="{ row, index }" slot="action">
                    <div v-if="row.roleType == 1">
                        <span style="color: #c5c8ce;">超级管理员无法操作</span>
                    </div>
                    <div v-else>
                        <Poptip   v-auth="`edit_manager`"
                                transfer
                                confirm
                                title="确定重置此管理员的密码?"
                                @on-ok="setDefaultPass(row.id,index,1)">
                            <span class="span-but-list">重置密码</span>
                        </Poptip> |

                        <Poptip transfer   v-auth="`edit_manager`">
                            <a>修改状态</a>
                            <div slot="content">
                                <RadioGroup v-model="modeAdd.formInline.status" @on-change="setStatus(row.id,index,2,$event)">
                                    <Radio label="10">启用</Radio>
                                    <Radio label="9">禁用</Radio>
                                </RadioGroup>
                            </div>
                        </Poptip>&nbsp;|
                        <Poptip   v-auth="`edit_manager`"
                                transfer
                                confirm
                                title="确定删除此管理员?"
                                @on-ok="deleteManager(row.id,index,3)">
                            <span class="span-but-list">删除</span>
                        </Poptip>
                    </div>
                </template>
            </Table>
            <div class="page-box">
                <Page :total='managerData.count'
                      show-elevator
                      show-sizer
                      show-total
                      @on-change="managerPageChange"
                      @on-page-size-change = "managerPageSizeChange"/>
            </div>
        </Card>
        <!--添加管理员对话框-->
        <Modal v-model="modeAdd.show"
               :loading="modeAdd.loading"
               title="添加管理员"
               :closable="false"
               :mask-closable="false"
               @on-ok="addMode">
            <Form ref="formValidate" :model="modeAdd.formInline" :rules="modeAdd.ruleValidate" :label-width="95">
                <FormItem label="登录名" prop="username">
                    <Input type="text" v-model="modeAdd.formInline.username" placeholder="最多15个英文字符">
                    </Input>
                </FormItem>
                <FormItem label="昵称" prop="nickname">
                    <Input v-model="modeAdd.formInline.nickname" placeholder="最多8个字符"></Input>
                </FormItem>
                <FormItem label="登录密码" prop="password">
                    <Input type="password" v-model="modeAdd.formInline.password" placeholder="最多10个英文字符"></Input>
                </FormItem>
                <FormItem label="邮箱" prop="email">
                    <Input type="email" v-model="modeAdd.formInline.email" placeholder="请输入邮箱地址"></Input>
                </FormItem>
                <FormItem label="备注" prop="mark">
                    <Input type="textarea" v-model="modeAdd.formInline.mark" placeholder="最多10个英文字符"></Input>
                </FormItem>
                <FormItem label="所属角色" prop="role">
                    <Select v-model="modeAdd.formInline.roleId">
                        <Option :value="item.id" :label="item.name" v-for="(item,index) in modeAdd.role.list" :key="index">
                            <span>{{item.name}}</span>
                        </Option>
                    </Select>
                </FormItem>
                <FormItem label="状态" prop="mode_status">
                    <RadioGroup v-model="modeAdd.formInline.status">
                        <Radio label="10">启用</Radio>
                        <Radio label="9">禁用</Radio>
                    </RadioGroup>
                </FormItem>
            </Form>
            <div slot="footer">
                <Button  @click="addModeShow(2)">取消</Button>
                <Button type="primary" :loading = "modeAdd.loading" @click="addMode('formValidate')">确定</Button>
            </div>
        </Modal>
        <!--添加管理员对话框-->
    </div>
</template>
<script>
    export default {
        data () {
            const validateEnglish = (rule, value, callback) => {
                if (value.trim() === '') {
                    return callback(new Error('请输入管理员登录名'))
                } else if (/[^\a-\z\A-\Z]/g.test(value)) {
                    return callback(new Error('管理员登录名必须为英文'))
                } else {
                    callback()
                }
            };
            return {
                modeAdd:{
                    show:false,
                    loading: false,
                    role:{
                        count:0,
                        list:[],
                        search:{
                            type:2,
                            page:1,
                            pageSize:this.COMMONJS.pageSize,
                        },
                    },
                    formInline: {
                        username: '',
                        nickname: '',
                        password: '',
                        email: '',
                        mark: '',
                        roleId:'',
                        status: '10'
                    },
                    ruleValidate: {
                        username: [
                            { required: true, message: '请输入管理员登录名', trigger: 'blur' },
                            { type: 'string', max: 10, message: '管理员登录名最多10个字符', trigger: 'blur' },
                            { min: 4, message: '管理员登录名最少4个字符', trigger: 'blur' },
                            { required: true, trigger: 'blur', validator: validateEnglish }
                        ],
                        nickname: [
                            { required: true, message: '请输入管理员昵称', trigger: 'blur' },
                            { type: 'string', max: 8, message: '管理员昵称昵称最多为8个字符', trigger: 'blur' }

                        ],
                        email: [
                            { type: 'email',  message: '请输入正确的邮箱地址', trigger: 'blur' }

                        ],
                        password: [
                            { required: true, message: '请输入管理员登录密码', trigger: 'blur' },
                            { type: 'string', min: 6, message: '管理员密码不能少于为6个字符', trigger: 'blur' },
                            { type: 'string', max: 15, message: '管理员密码最多为15个字符', trigger: 'blur' }
                        ],
                        mark: [
                            { type: 'string', max: 20, message: '管理员备注最多20个字符', trigger: 'blur' }
                        ],
                        roleId: [
                            { type: 'number',trigger: 'change' },
                            { required: true, message: '请选择所属角色组', trigger: 'blur',type: 'number' },
                        ],

                    }
                },
                managerData:{
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
                            title: '用户名(登录名)',
                            key: 'username',
                            width:200,
                            align:'left'
                        },
                        {
                            title: '所属角色',
                            slot: 'role',
                            key: 'roleId',
                            width:200,
                            align:'left',
                            // render: (h, params) => {
                            //     if(params.row.roleType == 1){
                            //         return h('span', {
                            //             style: {
                            //                 color:'#c5c8ce'
                            //             },
                            //         }, '超级管理员无法操作')
                            //     }else{
                            //         return h('Select', {
                            //             props: {
                            //                 value: params.row.roleId, // 获取选择的下拉框的值
                            //                 size: 'default',
                            //                 transfer:true
                            //             },
                            //             on: {
                            //                 'on-change': e => {
                            //                     this.changeMangerRole(params.row.id,e);
                            //                 }
                            //             },
                            //             directives:[
                            //                 {
                            //                     name:'auth',
                            //                     value:'change_role',
                            //                     text: {
                            //                         show:false,
                            //                         text:'foo'
                            //                     },
                            //                 }
                            //             ]
                            //         }, this.modeAdd.role.list.map((item) => { // this.productTypeList下拉框里的data
                            //             return h('Option', { // 下拉框的值
                            //                 props: {
                            //                     value: item.id.toString(),
                            //                     label: item.name
                            //                 }
                            //             })
                            //         }))
                            //     }
                            //
                            // }
                        },
                        {
                            title: '最后登录IP',
                            key: 'last_ip',
                            width:200,
                            align:'left',
                        },
                        {
                            title: '最后登录时间',
                            key: 'updated_at',
                            width:200,
                            align:'left',
                            render: (h, params) => {
                                return h(
                                    "div",
                                    this.dayjs.unix(params.row.updated_at).format('YYYY-MM-DD HH:mm:ss')
                                );
                            }
                        },
                        {
                            title: '备注',
                            key: 'mark',
                            width:200,
                            align:'center',
                        },
                        {
                            title: '状态',
                            key: 'status',
                            width:200,
                            align:'center',
                            render: (h, params) => {
                                const managerData = this.managerData.list;
                                if(managerData[params.index].status == this.COMMONJS.managerActiveStatus){
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
            }
        },
        activated() {
            this.getUserList();
            this.getRoleList();
        },
        methods: {
            //点击加载更多角色列表
            rolePageChange(page){
                this.roleData.loading = true;
                this.roleData.search.page = page;
                this.getRoleList();
            },
            //获取角色列表
            getRoleList:function(){
                const that = this;
                let successCallback = function(res){
                    that.modeAdd.role.list = res.data.data.list;
                    that.modeAdd.role.count = res.data.data.count;
                }
                let failCallback = function(res){
                    that.modeAdd.role.list = [];
                }
                that.HTTPJS.get(that.HTTPURL.SYSTEM_SEETING.ROLE.GET_ROLE_LIST,that.modeAdd.role.search,successCallback,failCallback);
            },
            //分页
            managerPageChange(page){
                this.managerData.loading = true;
                this.managerData.search.page = page;
                this.getUserList();
            },
            //切换条数
            managerPageSizeChange(pageSize){
                this.managerData.loading = true;
                this.managerData.search.pageSize = pageSize;
                this.getUserList();
            },
            getUserList:function(){
                const that = this;
                let successCallback = function(res){
                    that.managerData.loading = false;
                    that.managerData.count = res.data.data.count;
                    that.managerData.list = res.data.data.list;
                }
                let failCallback = function(res){
                    that.managerData.loading = false;
                }
                that.HTTPJS.get(that.HTTPURL.SYSTEM_SEETING.MANAGER.GET_USER_LIST,that.managerData.search,successCallback,failCallback);
            },
            //点击添加管理员
            addModeShow:function(type){
                if(type == 1){
                    this.modeAdd.show = true;
                    this.getRoleList();
                }else{
                    this.modeAdd.loading = false;
                    this.modeAdd.show = false;
                    this.$refs["formValidate"].resetFields();//重置表单
                }
            },
            addMode:function(name){
                const that = this;
                this.$refs[name].validate((valid,errors) => {
                    if (valid) {
                        that.modeAdd.loading = true;
                        let successCallback = function(res){
                            that.$Message.info({
                                content:'添加成功',
                                onClose:function () {
                                    that.getUserList();
                                    that.modeAdd.loading = false;
                                    that.addModeShow(2);
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
                        that.HTTPJS.post(that.HTTPURL.SYSTEM_SEETING.MANAGER.ADD_MANAGER,that.modeAdd.formInline,successCallback,failCallback);
                    }
                })
            },
            //修改状态
            setStatus:function (id,index,type,value) {//type == 1重置密码，2修改状态，3删除
                const that = this;
                let successCallback = function(res){
                    that.$Message.info({
                        content:res.data.message,
                        onClose:function () {
                            that.getUserList();
                        }
                    })
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:res.data.message,
                    })
                }
                that.HTTPJS.post(that.HTTPURL.SYSTEM_SEETING.MANAGER.EDIT_MANAGER,{editManagerId:id,editManagerType:type,editManagerValue:value},successCallback,failCallback);
            },
            //重置密码
            setDefaultPass (id,index,type){
                const that = this;
                let successCallback = function(res){
                    that.$Message.info({
                        content:res.data.message,
                    })
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:res.data.message,
                    })
                }
                that.HTTPJS.post(that.HTTPURL.SYSTEM_SEETING.MANAGER.EDIT_MANAGER,{editManagerId:id,editManagerType:type,editManagerValue:''},successCallback,failCallback);
            },
            //删除管理员
            deleteManager (id,index,type){
                const that = this;
                let successCallback = function(res){
                    that.$Message.info({
                        content:'删除成功',
                        onClose:function () {
                        that.getUserList();
                    }
                    })
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:res.data.message,
                    })
                }
                that.HTTPJS.post(that.HTTPURL.SYSTEM_SEETING.MANAGER.EDIT_MANAGER,{editManagerId:id,editManagerType:type,editManagerValue:''},successCallback,failCallback);
            },
            //点击搜索 type == 1搜索，2重置
            searchClick:function (type) {
                if(type == 1){
                    this.managerData.search.page = 1;
                    this.managerData.list = [];
                    this.managerData.loading = true;
                    this.getUserList();
                }else{
                    this.managerData.search.page = 1;
                    this.managerData.list = [];
                    this.managerData.loading = true;
                    this.$refs["search"].resetFields();//重置表单
                    this.getUserList();
                }
            },
            //修改管理员角色
            changeMangerRole:function(userId,roleId){
                const that = this;
                that.$Modal.confirm({
                    title: '更管理员所属角色',
                    content: '确定要更换此管理员所属角色吗？',
                    loading: true,
                    onOk: () => {
                        let successCallback = function(res){
                            that.$Message.info({
                                content:res.data.message,
                                onClose:function () {
                                    that.getUserList();
                                    that.$Modal.remove();
                                }
                            })
                        }
                        let failCallback = function(res){
                            that.$Message.error({
                                content:res.data.message,
                            })
                        }
                        that.HTTPJS.post(that.HTTPURL.SYSTEM_SEETING.MANAGER.CHANGE_MANAGER_ROLE,{userId:userId,roleId:roleId},successCallback,failCallback);
                    }
                });


             }

        }
    }
</script>
<style scoped>
    @import "../../../assets/style/category.css";
</style>