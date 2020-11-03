<template>
    <div>
    <Card :bordered="false" dis-hover>
      <div class="category-btn-list">
        <Button type="primary" icon="md-add" to="/addFields">添加字段</Button>
<!--        <Button type="primary" icon="md-sync" @click="updateSort">更新排序</Button>-->
      </div>
        <Table :border="false" :columns="modeColumns" :data="modeData">
            <template slot-scope="{ row, index }" slot="action">
                <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">编辑</Button>
                <Button type="error" size="small" @click="remove(index)">删除</Button>
            </template>
            <template slot-scope="{ row }" slot="name">
                <strong>{{ row.name }}</strong>
            </template>
            <template slot-scope="{ row, index }" slot="action">
                <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">编辑</Button>
                <Button type="warning" size="small" style="margin-right: 5px" @click="show(index)">禁用</Button>
                <Button type="error" size="small" style="margin-right: 5px" @click="remove(index)">删除</Button>
            </template>
        </Table>
        <div class="page-box"><Page :total="100" show-elevator show-sizer /></div>
    </Card>
  </div>

</template>
<script>
  export default {
    data () {
      return {
        modeColumns: [
          {
            title: '字段ID',
            key: 'id',
            width:100,
            align:'center'
          },
          {
            title: '字段名称',
            key: 'mode_name',
            width:150,
            align:'left',
          },
          {
            title: '字段别名',
            key: 'mode_table_name',
            width:150,
            align:'center'
          },
          {
            title: '字段描述',
            key: 'mode_desc',
            width:250,
            align:'center'
           },
           {
             title: '字段类型',
             key: 'mode_status',
             width:150,
             align:'center',
             render: (h, params) => {
                 const modeData = this.modeData;
                 if(modeData[params.index].mode_status == 1){
                     return h('Tag', {
                         props: {
                             color:'success'
                         },
                     }, '已启用')
                 }else{
                     return h('Tag', {
                         props: {
                             color:'error'
                         },
                     }, '已禁用')
                 }
             }
            },
            {
                title: '主表',
                key: 'mode_status',
                width:150,
                align:'center',
                render: (h, params) => {
                    const modeData = this.modeData;
                    if(modeData[params.index].mode_status == 1){
                        return h('Tag', {
                            props: {
                                color:'success'
                            },
                        }, '已启用')
                    }else{
                        return h('Tag', {
                            props: {
                                color:'error'
                            },
                        }, '已禁用')
                    }
                }
            },
            {
                title: '必填',
                key: 'mode_status',
                width:150,
                align:'center',
                render: (h, params) => {
                    const modeData = this.modeData;
                    if(modeData[params.index].mode_status == 1){
                        return h('Tag', {
                            props: {
                                color:'success'
                            },
                        }, '已启用')
                    }else{
                        return h('Tag', {
                            props: {
                                color:'error'
                            },
                        }, '已禁用')
                    }
                }
            },
           {
            title: '管理操作',
            slot: 'action',
            align: 'center',
            key: 'action'
           }
        ],
        modeData: [
         {
            id: 1,
            mode_name: '栏目名称',
            mode_table_name:'article',
            mode_desc:'模型描述',
            mode_status:1
          },
         {
              id: 2,
              mode_name: '栏目名称2',
              mode_table_name:'article2',
              mode_desc:'模型描述2',
              mode_status:2
          }
        ],
      }
    },
      methods: {
        //点击添加模型
          addModeShow:function(type){
              if(type == 1){
                  this.modeAdd.show = true;
              }else{
                  this.modeAdd.show = false;
                  this.$refs["formValidate"].resetFields();//重置表单
              }
          },
          addMode:function(name){
              this.$refs[name].validate((valid,errors) => {
                  if (valid) {
                      this.addModeShow(2);
                      this.$Message.success('Success!');
                  }
              })
          },
      }
  }
</script>
<style scoped>
  @import "../../../assets/style/category.css";
</style>