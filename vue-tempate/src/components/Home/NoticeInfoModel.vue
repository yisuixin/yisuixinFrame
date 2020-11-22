<style>
  .notice-info-box{
    text-align: center;
    font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
  }
  .notice-info-box .title-box .title{
    font-size: 24px;
    color: #464c5b;
    font-weight: bold;
  }
  .notice-info-box .title-box .info{
    font-size: 12px;
    padding-top: 10px;
  }

</style>
<template>
  <div>
    <!--整站权限设置对话框开始-->
    <Modal v-model="noticeModel.show"
           width="950px"
           title='通知公告详情'
           :footer-hide="true" fullscreen>
      <Spin size="large" fix v-if="noticeModel.loading"></Spin>
        <div slot class="notice-info-box">
          <div class="title-box">
            <p class="title">{{noticeModel.data.title}}</p>
            <p  class="info">
              <span>发布者：{{noticeModel.data.username}}</span>
              <span>发布时间：{{noticeModel.data.created_at | formatTime10}}</span>
            </p>
          </div>
          <Divider />
          <div class="content">
            <span v-html="noticeModel.data.content"></span>
          </div>
        </div>
    </Modal>
    <!--整站权限设置对话框结束-->
  </div>
</template>
<script>
  export default {
    data () {
      return {
        noticeModel:{
          show:false,
          loading:false,
          data:{}
        },
      }
    },
    mounted:function(){

    },
    methods: {
      //获取通知详情
      getNoticeInfo:function (id,userType) {
        const that =this;
        that.noticeModel.loading = true;
        let successCallback = function(res){
          that.noticeModel.loading = false;
          that.noticeModel.data = res.data.data;
        }
        let failCallback = function(res){
          that.noticeModel.loading = false;
          that.noticeModel.data = {};
        }
        let otherCallback = function(res){
          that.noticeModel.loading = false;
          that.noticeModel.data = {};
        }
        that.HTTPJS.get(that.HTTPURL.CONTENT.NOTICE.GET_NOTICE_INFO,{id:id,userType:userType},successCallback,failCallback,otherCallback);
      },
      showModel:function(type,id,userType){//type == 1显示，2关闭
        if(type == 1){
          this.noticeModel.show = true;
          this.getNoticeInfo(id,userType);
        }else{
          this.noticeModel.show = false;
        }
      },
    }
  }
</script>


