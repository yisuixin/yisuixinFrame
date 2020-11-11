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
</style>
<template>
  <div>
      <Card :bordered="false" style="height: 315px;">
        <Spin size="large" fix v-if="noticeList.loading"></Spin>
        <p slot="title" class="card-title-slot">
          <Icon type="ios-notifications-outline"  size="18" color="#2d8cf0"></Icon> 通知公告
        </p>
        <p slot="extra" style="cursor: pointer;color: #808695;">
          <span @click="showNoticeListModel(1)" title="查看更多"><Icon type="ios-more-outline" /></span>
        </p>
        <div class="notice-list-box">
          <ul>
            <li v-for="(item,index) in noticeList.list">
              <span @click="showNoticeInfoModel(1,item.id)">
                {{index + 1}}、{{item.title | reBytesStr(40)}}
                <span style="color: #ed4014;" v-if="item.topping == 1">【置顶】</span>
              </span>
            </li>
          </ul>
        </div>
      </Card>
    <NoticeListModel ref="NoticeListModel"></NoticeListModel>
    <NoticeInfoModel ref="NoticeInfoModel"></NoticeInfoModel>
  </div>
</template>
<script>
  import NoticeListModel from '../../components/Home/NoticeListModel'
  import NoticeInfoModel from '../../components/Home/NoticeInfoModel'
  export default {
    components: {NoticeListModel,NoticeInfoModel},
    data () {
      return {
          noticeList:{
              loading:false,
              search:{
                  type:2,
                  searchKey:'',
                  page:1,
                  pageSize:7,
              },
              count:0,
              list:[]
          },
      }
    },
    mounted:function(){
        this.getNoticeList();
    },
    methods: {
      showNoticeListModel:function(type){//type == 1显示，2关闭
        this.$refs.NoticeListModel.showModel(type);
      },
      showNoticeInfoModel:function(type,id){//type == 1显示，2关闭
        this.$refs.NoticeInfoModel.showModel(type,id);
      },
      //获取通知列表
      getNoticeList:function () {
            const that =this;
            that.noticeList.loading = true;
            let successCallback = function(res){
                that.noticeList.loading = false;
                that.noticeList.list = res.data.data.list;
                that.noticeList.count = res.data.data.count;
            }
            let failCallback = function(res){
                that.noticeList.loading = false;
                that.noticeList.list = [];
            }
            let otherCallback = function(res){
                that.noticeList.loading = false;
                that.noticeList.list = [];
            }
            that.HTTPJS.get(that.HTTPURL.COMMON.NOTICE.GET_USER_NOTICE_LIST,that.noticeList.search,successCallback,failCallback,otherCallback);
      },
    }
  }
</script>


