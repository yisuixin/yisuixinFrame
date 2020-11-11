<template>
  <Card :bordered="false" :padding="12" style="height: 315px;">
      <p slot="title" class="card-title-slot">
          <Icon type="ios-laptop"  size="18" color="#2d8cf0"></Icon> 服务器信息
      </p>
    <div class="web-info-box">
        <Spin size="large" fix v-if="info.loading"></Spin>
      <ul>
        <li v-for="(item,index) in info.list" :key="index">
          <span>{{item.name}}</span>
          <span class="info-name" :title="item.value">{{item.value}}</span>
        </li>
      </ul>
    </div>

  </Card>
</template>
<style scoped>
    @import "../../assets/style/home.css";
  .info-name{
    text-align:right;
    float: right;
    width:200px;
    white-space:nowrap;
    text-overflow:ellipsis;
    overflow:hidden;
  }
</style>
<script>
    export default {
        data () {
            return {
                info:{
                    loading:true,
                    list: [],
                },
            }
        },
        mounted:function(){
            let that = this;
            that.serverInfo();
        },
        methods: {
            serverInfo () {
                const that =this;
                let successCallback = function(res){
                    that.info.loading = false;
                    that.info.list = res.data.data;
                }
                let failCallback = function(res){
                    that.info.loading = false;
                    that.info.list = [];
                }
                let otherCallback = function(res){
                    that.info.loading = false;
                    that.info.list = [];
                }
                that.HTTPJS.get(that.HTTPURL.COMMON.SYSTEMINFO.SERVERINFO,{},successCallback,failCallback,otherCallback);
            },
        }
    }
</script>


