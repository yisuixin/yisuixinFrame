<template>
  <Card :bordered="false">
    <p slot="title" class="card-title-slot">
      <Icon type="ios-map-outline"  size="18" color="#2d8cf0"></Icon> 后台登录日志
    </p>
    <p slot="extra" style="cursor: pointer;" title="更多">
      <DatePicker type="daterange" placeholder="选择日期" @on-change ="selectLogDate"style="width: 200px"></DatePicker>
    </p>
    <Table :loading="loginLog.loading" :columns="loginLog.columns" :data="loginLog.list"></Table>
    <div class="page-box">
      <Page :total="loginLog.count"
            show-elevator
            show-total
            :page-size ="loginLog.search.pageSize"
            @on-change="loginLogPageChange"
            @on-page-size-change = "loginLogPageSizeChange"/>
    </div>
  </Card>
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
    mounted:function(){
      this.getLoginLog();
    },
    methods: {
      //选择登录日志筛选时间
      selectLogDate(date){
        this.loginLog.search.startTime = date[0];
        this.loginLog.search.endTime = date[1];
        this.getLoginLog();
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
        that.HTTPJS.get(that.HTTPURL.LOG.LIST,that.loginLog.search,successCallback,failCallback,otherCallback);
      }
    }
  }
</script>
