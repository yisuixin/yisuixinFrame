<template>
    <div>
        <Card :bordered="false" dis-hover style="margin-bottom: 10px;">
            <div class="category-btn-list">
                <Form ref="search" :model="operationLog.search" :label-width="100">
                    <Row>
                        <Col span="5">
                            <FormItem label="关键字："prop="searchKey">
                                <Input type="text" v-model="operationLog.search.searchKey" placeholder="请输入操作用户"></Input>
                            </FormItem>
                        </Col>
                        <Col span="5">
                            <FormItem label="操作时间：" prop="loginTime">
                                <DatePicker type="daterange" placeholder="请选择操作时间" @on-change ="selectLogDate" v-model="operationLog.search.loginTime":editable="false" style="width: 100%;"></DatePicker>
                            </FormItem>
                        </Col>
                        <Col span="5">
                            <FormItem label="操作状态：" prop="loginStatus" >
                                <Select v-model="operationLog.search.status" placeholder="请选择操作状态">
                                    <Option value="" >全部</Option>
                                    <Option value="1" >操作成功</Option>
                                    <Option value="0" >操作失败</Option>
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
            <Table :border="false" :columns="operationLog.columns" :data="operationLog.list"  :loading="operationLog.loading">
                <template slot-scope="{ row, index }" slot="action">
                    <Poptip   v-auth="`edit_manager`"
                              transfer
                              confirm
                              title="确定删除此管理员?"
                              @on-ok="deleteOperationLog(row.id,index,3)">
                        <Button type="error" size="small">删除</Button>
                    </Poptip>
                </template>
            </Table>
            <div class="page-box">
                <Page :total="operationLog.count"
                        show-elevator
                        show-total
                        :page-size ="operationLog.search.pageSize"
                        @on-change="loginLogPageChange"
                        @on-page-size-change = "loginLogPageSizeChange"/>
            </div>
        </Card>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                operationLog:{
                    loading:true,
                    search:{
                        status:'',
                        page:1,
                        searchKey:'',
                        pageSize:this.COMMONJS.pageSize,
                        startTime:'',
                        endTime:'',
                    },
                    count: 0,
                    list: [],
                    columns: [
                        {
                            title: 'ID',
                            key: 'id',
                            width:80,
                            align:'center',
                            sortable: true
                        },
                        {
                            title: '操作用户',
                            key: 'userName',
                            width:150,
                            align:'center',
                            render: (h, params) => {
                                const user = this.operationLog.list[params.index].user;
                                return h('span', user.username)
                            }
                        },
                        {
                            title: '操作URL',
                            key: 'url',
                            width:300,
                            align:'left',
                        },
                        {
                            title: '操作备注',
                            key: 'mark',
                            width:450,
                            align:'left',
                            render: (h, params) => {
                                const list = this.operationLog.list[params.index].desc;
                                return h('span', '请求方式：'+list.type+';模块：'+ list.model+';控制器：'+ list.controller+';方法：'+ list.action+';操作提示：'+list.message)
                            }
                        },
                        {
                            title: '操作IP',
                            key: 'ip',
                            width:120,
                            align:'left'
                        },
                        {
                            title: '操作时间',
                            key: 'loginTime',
                            width:250,
                            align:'center',
                            sortable: true,
                            render: (h, params) => {
                                const time = this.operationLog.list[params.index].created_at;
                                return h('span', this.$options.filters.formatTime10(time))
                            }
                        },
                        {
                            title: '操作状态',
                            key: 'status',
                            width:120,
                            align:'center',
                            render: (h, params) => {
                                const list = this.operationLog.list;
                                if(list[params.index].status == 1){
                                    return h('Tag', {
                                        props: {
                                            color:'success'
                                        },
                                    }, '操作成功')
                                }else{
                                    return h('Tag', {
                                        props: {
                                            color:'error'
                                        },
                                    }, '操作失败')
                                }
                            }
                        },
                        {
                            title: '管理操作',
                            slot: 'action',
                            align: 'center',
                            key: 'action',
                            directives:[
                                {
                                    name:'auth',
                                    value:'del_operation_log',
                                }
                            ]
                        }
                    ]
                },
            }
        },
        activated() {
            this.getOperationLog();
        },
        methods: {
            //选择登录日志筛选时间
            selectLogDate(date){
                this.operationLog.search.startTime = date[0];
                this.operationLog.search.endTime = date[1];
                // this.getLoginLog();
            },
            //分页
            loginLogPageChange(page){
                this.operationLog.loading = true;
                this.operationLog.search.page = page;
                this.getOperationLog();
            },
            //切换条数
            loginLogPageSizeChange(pageSize){
                this.operationLog.loading = true;
                this.operationLog.search.pageSize = pageSize;
                this.getOperationLog();
            },
            //获取登录日志列表
            getOperationLog() {
                const that =this;
                let successCallback = function(res){
                    that.operationLog.loading = false;
                    that.operationLog.list = res.data.data.list;
                    that.operationLog.count = res.data.data.count;
                }
                let failCallback = function(res){
                    that.operationLog.loading = false;
                    that.operationLog.list = [];
                }
                let otherCallback = function(res){
                    that.operationLog.loading = false;
                    that.operationLog.list = [];
                }
                that.HTTPJS.get(that.HTTPURL.SYSTEM_SEETING.LOG.OPERATION_LOG,that.operationLog.search,successCallback,failCallback,otherCallback);
            },
            //点击搜索或者重置
            handleSubmit(type){
                if(type == 1){
                    this.getOperationLog();
                }else{
                    this.$refs['search'].resetFields();
                }
            },
            //删除日志
            deleteOperationLog (id,index){
                const that = this;
                let successCallback = function(res){
                    that.$Message.info({
                        content:'删除成功',
                        onClose:function () {
                            that.getOperationLog();
                        }
                    })
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:res.data.message,
                    })
                }
                that.HTTPJS.post(that.HTTPURL.SYSTEM_SEETING.LOG.OPERATION_LOG_DEL,{id:id},successCallback,failCallback);
            },
        }
    }
</script>
<style scoped>
    @import "../../../assets/style/content.css";
</style>