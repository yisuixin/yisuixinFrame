<template>
    <div>
        <Card :bordered="false" dis-hover style="margin-bottom: 10px;">
            <div class="category-btn-list">
                <Form ref="search" :model="loginLog.search" :label-width="100">
                    <Row>
                        <Col span="6">
                            <FormItem label="关键字："prop="searchKey">
                                <Input type="text" v-model="loginLog.search.searchKey" placeholder="请输入关键字"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="登录时间：" prop="loginTime">
                                <DatePicker type="daterange" placeholder="请选择登录时间" @on-change ="selectLogDate" v-model="loginLog.search.loginTime":editable="false" style="width: 100%;"></DatePicker>
                            </FormItem>
                        </Col>
<!--                        <Col span="6">-->
<!--                            <FormItem label="登录状态：" prop="loginStatus" >-->
<!--                                <Select v-model="loginLog.search.loginStatus" placeholder="请选择登录状态">-->
<!--                                    <Option value="" >全部</Option>-->
<!--                                    <Option value="1" >登录成功</Option>-->
<!--                                    <Option value="2" >登录失败</Option>-->
<!--                                </Select>-->
<!--                            </FormItem>-->
<!--                        </Col>-->
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
            <Table :border="false" :columns="loginLog.columns" :data="loginLog.list" :loading="loginLog.loading">
                <template slot-scope="{ row, index }" slot="action">
                    <!--                      <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">预览</Button>-->
                    <Button type="error" size="small" @click="remove(index)">删除</Button>
                </template>
            </Table>
            <div class="page-box">
                <Page :total="loginLog.count"
                      show-elevator
                      show-total
                      :page-size ="loginLog.search.pageSize"
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
                loginLog:{
                    loading:true,
                    search:{
                        type:1,
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
                            key: 'id'
                        },
                        {
                            title: '用户名',
                            key: 'username',
                            render: (h, params) => {
                                return h(
                                    "div",
                                    params.row.desc.username
                                );
                            }
                        },
                        {
                            title: '登录备注',
                            key: 'desc',
                            render: (h, params) => {
                                return h(
                                    "div",
                                    params.row.desc.content
                                );
                            }
                        },
                        {
                            title: '登录IP',
                            key: 'ip'
                        },
                        {
                            title: '登录时间',
                            key: 'cream_time',
                            render: (h, params) => {
                                return h(
                                    "div",
                                    this.dayjs.unix(params.row.created_at).format('YYYY-MM-DD HH:mm:ss')
                                );
                            }
                        },
                    ],
                },
            }
        },
        activated() {
            this.getLoginLog();
        },
        methods: {
            //选择登录日志筛选时间
            selectLogDate(date){
                this.loginLog.search.startTime = date[0];
                this.loginLog.search.endTime = date[1];
                // this.getLoginLog();
            },
            //分页
            loginLogPageChange(page){
                this.loginLog.loading = true;
                this.loginLog.search.page = page;
                this.getLoginLog();
            },
            //切换条数
            loginLogPageSizeChange(pageSize){
                this.loginLog.loading = true;
                this.loginLog.search.pageSize = pageSize;
                this.getLoginLog();
            },
            //获取登录日志列表
            getLoginLog() {
                const that =this;
                let successCallback = function(res){
                    that.loginLog.loading = false;
                    that.loginLog.list = res.data.data.list;
                    that.loginLog.count = res.data.data.count;
                }
                let failCallback = function(res){
                    that.loginLog.loading = false;
                    that.loginLog.list = [];
                }
                let otherCallback = function(res){
                    that.loginLog.loading = false;
                    that.loginLog.list = [];
                }
                that.HTTPJS.get(that.HTTPURL.SYSTEM_SEETING.LOG.LOGIN_LOG,that.loginLog.search,successCallback,failCallback,otherCallback);
            },
            //点击搜索或者重置
            handleSubmit(type){
                if(type == 1){
                    this.getLoginLog();
                }else{
                    this.$refs['search'].resetFields();
                }
            }
        }
    }
</script>
<style scoped>
    @import "../../../assets/style/content.css";
</style>