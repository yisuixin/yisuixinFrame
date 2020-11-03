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
           width="950px"
           title='发布通知公告'
           :footer-hide="true">
      <Spin size="large" fix v-if="noticeModel.loading"></Spin>
      <div slot style="overflow-y:auto;height: 550px;">

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
          data:{},
        },
      }
    },
    mounted:function(){
      //this.getQuickOperationList();
    },
    methods: {
      //获取通知
      getNoticeInfo:function () {
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
          //this.getNoticeList();
        }else{
          this.noticeModel.show = false;
          this.noticeModel.okBtnLoading = false;
        }
      },

    }
  }
</script>


