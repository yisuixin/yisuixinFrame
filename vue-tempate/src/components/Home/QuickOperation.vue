<style scoped>
  .list-box{
    margin-bottom: 35px;
  }
  .list-box .title{
    padding-top: 8px;
  }
  .list-box .title:hover{
    color: #0e64c3;
  }
  .list-box .item{
    margin-bottom: 30px;
  }
  .list-box .item div{
    cursor: pointer;
  }
</style>
<template>
  <div>
    <Card :bordered="false" style="height: 315px;">
      <Spin size="large" fix v-if="quickOperation.loading"></Spin>
      <p slot="title" class="card-title-slot">
        <Icon type="ios-heart-outline"  size="18" color="#2d8cf0"></Icon> 快捷操作
      </p>
      <p slot="extra" style="cursor: pointer;color: #808695;" title="设置快捷操作">
        <span @click="showUserMenuModel(1)"><Icon type="ios-settings-outline" /></span>
      </p>
      <div class="web-info-box" style="text-align: center">
        <Row class="list-box">
          <Col span="8"  class="item" v-for=" (item,index) in quickOperation.list" :key="index">
            <div @click="clickQulciItem(index)">
              <p class="icon"> <Icon :type="item.menuList.icon" size="24"/></p>
              <p class="title">{{item.menuList.title}}</p>
            </div>
          </Col>
        </Row>
      </div>
    </Card>
    <!--快捷菜单设置对话框开始-->
    <UserMenuList ref="UserMenuListModel"></UserMenuList>
    <!--快捷菜单设置对话框结束-->
  </div>


</template>


<script>
  import event from "../../assets/js/event";
  import UserMenuList from '../../components/Menu/UserMenuListModel'
  export default {
    components: {UserMenuList},
    data () {
      return {
        quickOperation:{
          loading:false,
          search:{
            type:2,
            searchKey:'',
            page:1,
            pageSize:9,
            date:'',
          },
          count:0,
          list:[]
        },
      }
    },
    mounted:function(){
      this.getQuickOperationList();
    },
    methods: {
      //获取待办事项
      getQuickOperationList:function () {
        const that =this;
        that.quickOperation.loading = true;
        let successCallback = function(res){
          that.quickOperation.loading = false;
          that.quickOperation.list = res.data.data.list;
          that.quickOperation.count = res.data.data.count;
        }
        let failCallback = function(res){
          that.quickOperation.loading = false;
          that.quickOperation.list = [];
        }
        let otherCallback = function(res){
          that.quickOperation.loading = false;
          that.quickOperation.list = [];
        }
        that.HTTPJS.get(that.HTTPURL.QUICK_OPERATION.GET_QUICK_OPERATION,that.quickOperation.search,successCallback,failCallback,otherCallback);
      },
      //点击快捷菜单设置菜单显示以及跳转
      clickQulciItem(index){
        const that = this;
        let menu_id = parseInt(this.quickOperation.list[index].menu_id);
        let allMenu = sessionStorage.getItem('allMenu');
        let menu = JSON.parse(allMenu);
        let allParent = this.arrayJs.getAllParent(menu,menu_id);
        if(allParent.length > 0){
          let toptMenu = allParent[0];
          menu.map((item1, index1, arr1) => {
            if(item1.id == toptMenu.id){
              event.$emit('setTopMenu',item1.href,index1)//设置顶部菜单选中状态
              event.$emit('setLeftMenuActive',allParent[allParent.length - 1].href)//设置左侧菜单选中状态
              that.$router.replace(allParent[allParent.length - 1].href)
            }
          })
        }
      },
      //显示整站权限设置对话框
      showUserMenuModel:function(type){//type == 1显示，2关闭
        this.$refs.UserMenuListModel.showUserMenuModel(type);
      },
    }
  }
</script>