<style>
  .notice-list-box li{
    padding:6px 6px;
    cursor: pointer;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
  }
  .notice-list-box li:hover{
    color:#0d58ab;
  }
  .rowClassName{
    cursor: pointer;
  }
</style>
<template>
  <div>
    <!--整站权限设置对话框开始-->
    <Modal v-model="noticeModel.show"
           width="1000px"
           title='通知公告列表'
           :footer-hide="true">
      <Spin size="large" fix v-if="noticeModel.loading"></Spin>
      <div slot style="overflow-y:auto;height: 550px;">
          <Table :row-class-name="rowClassName" :columns="columns" :data="noticeModel.list" @on-row-click="showInfoModel($event.id,1)"></Table>
      </div>
      <div class="page-box">
        <Page :total="noticeModel.count"
              show-elevator
              show-total
              :page-size ="noticeModel.search.pageSize"
              @on-change="noticePageChange"
              @on-page-size-change = "noticePageSizeChange"/>
      </div>
    </Modal>
    <!--整站权限设置对话框结束-->
    <NoticeInfoModel ref="NoticeInfoModel"></NoticeInfoModel>
  </div>
</template>
<script>
  import UserMenuList from '../../components/Menu/UserMenuListModel'
  import NoticeInfoModel from '../../components/Home/NoticeInfoModel'
  export default {
    components: {UserMenuList,NoticeInfoModel},
    data () {
      return {
        noticeModel:{
          show:false,
          loading:false,
          search:{
            type:2,
            searchKey:'',
            page:1,
            pageSize:10,
            date:'',
          },
          count:0,
          list:[]
        },
        columns: [
              {
                  title: '标题',
                  key: 'title',
                  render: (h, params) => {
                    return h(
                            "div",
                            this.$options.filters.reBytesStr(params.row.title,40)
                    );
                  }
              },
              {
                  title: '发布人',
                  key: 'username',
                  width:'120'
              },
              {
                title: '是否置顶',
                key: 'topping',
                width:'120',
                render: (h, params) => {
                  let topping = params.row.topping;   //这里的params.row.id  是  key值
                  if (topping ==  1) {
                    topping = '【置顶】'
                  } else {
                    topping = ''
                  }
                  return h(
                          "div",
                          topping
                  )}
              },
              {
                title: '状态',
                key: 'status',
                width:'120',
                render: (h, params) => {
                  let status = params.row.status;   //这里的params.row.id  是  key值
                  if (status ==  1 || status == null || status == '') {
                    status = '未读'
                  } else {
                    status = '已读'
                  }
                  return h(
                          "div",
                          status
                  )}
              },
              {
                title: '发布时间',
                key: 'created_at',
                width:'200',
                render: (h, params) => {
                  return h(
                          "div",
                          this.dayjs.unix(params.row.created_at).format('YYYY-MM-DD HH:mm:ss')
                  );
                }
              },
          ],
      }
    },
    mounted:function(){
      //this.getQuickOperationList();
    },
    methods: {
      //分页
      noticePageChange(page){
        this.noticeModel.loading = true;
        this.noticeModel.search.page = page;
        this.getNoticeList();
      },
      //切换条数
      noticePageSizeChange(pageSize){
        this.noticeModel.loading = true;
        this.noticeModel.search.pageSize = pageSize;
        this.getNoticeList();
      },
      //获取通知列表
      getNoticeList:function () {
        const that =this;
        that.noticeModel.loading = true;
        let successCallback = function(res){
          that.noticeModel.loading = false;
          that.noticeModel.list = res.data.data.list;
          that.noticeModel.count = res.data.data.count;
        }
        let failCallback = function(res){
          that.noticeModel.loading = false;
          that.noticeModel.list = [];
        }
        let otherCallback = function(res){
          that.noticeModel.loading = false;
          that.noticeModel.list = [];
        }
        that.HTTPJS.get(that.HTTPURL.NOTICE.GET_USER_NOTICE_LIST,that.noticeModel.search,successCallback,failCallback,otherCallback);
      },
      //显示整站权限设置对话框
      showModel:function(type){//type == 1显示，2关闭
        if(type == 1){
          this.noticeModel.show = true;
          this.getNoticeList();
        }else{
          this.noticeModel.show = false;
          this.noticeModel.okBtnLoading = false;
        }
      },
      showInfoModel:function(id,type){//type == 1显示，2关闭
        this.$refs.NoticeInfoModel.showModel(type,id);
      },
      rowClassName (row, index) {
          return 'rowClassName';
      }
    }
  }
</script>


