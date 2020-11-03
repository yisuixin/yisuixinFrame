<template>
    <div>
    <Card :bordered="false" dis-hover>
      <div class="category-btn-list">
        <Button type="primary" icon="md-add" to="/addRole" style="margin-right: 10px;">添加角色</Button>
<!--        <Button type="primary" icon="md-sync" @click="updateSort">更新排序</Button>-->
      </div>
        <Table :border="false" :columns="categoryColumns" :data="categoryData">
            <template slot-scope="{ row, index }" slot="action">
                <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">编辑</Button>
                <Button type="error" size="small" @click="remove(index)">删除</Button>
            </template>
            <template slot-scope="{ row }" slot="name">
                <strong>{{ row.name }}</strong>
            </template>
            <template slot-scope="{ row, index }" slot="action">
                <span class="span-but-list">整站权限设置</span>&nbsp;| &nbsp;
                <span class="span-but-list">栏目权限设置</span>&nbsp;| &nbsp;
                <span class="span-but-list" @click="show(index)">编辑</span>&nbsp;| &nbsp;
                <span class="span-but-list">删除</span>
            </template>
        </Table>
        <div class="page-box"><Page :total="100" show-elevator show-sizer :transfer="true"/></div>
    </Card>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        categoryColumns: [
          {
            title: 'ID',
            key: 'id',
            width:100,
            align:'center'
          },
          {
            title: '角色名称',
            key: 'name',
            width:200,
            align:'left'
          },
         {
            title: '角色备注',
            key: 'mark',
            width:400,
            align:'center',
         },
          {
            title: '状态',
            key: 'status',
            width:150,
            align:'center',
              render: (h, params) => {
                  const categoryData = this.categoryData;
                  if(categoryData[params.index].status == 1){
                      return h('span', {
                          style: {
                              fontSize:'14px'
                          },
                      }, '已启用')
                  }else{
                      return h('span', {
                          style: {
                              fontSize:'14px'
                          },
                      }, '已禁用')
                  }
              }
           },
           {
            title: '管理操作',
            slot: 'action',
            align: 'center',
            key: 'action',

           }
        ],
          categoryData: [{
              id:'1',
              name:'admin',
              mark:'备注信息',
              status:'1',
          }
        ],
      }
    },
      methods: {
        //点击排序
          updateSort:function(){
              console.log(3333)
          }
          // show (index) {
          //     this.$Modal.info({
          //         title: 'User Info',
          //         content: `Name：${this.data6[index].name}<br>Age：${this.data6[index].age}<br>Address：${this.data6[index].address}`
          //     })
          // },
          // remove (index) {
          //     this.data6.splice(index, 1);
          // }
      }
  }
</script>
<style scoped>
  @import "../../../assets/style/category.css";
</style>