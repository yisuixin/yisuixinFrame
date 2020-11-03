<template>
    <div>
        <Card :bordered="false" dis-hover style="margin-bottom: 10px;">
            <div class="category-btn-list">
                <Form ref="search" :model="search" :label-width="100">
                    <Row>
                        <Col span="6">
                            <FormItem label="操作用户："prop="userName">
                                <Input type="text" v-model="search.userName" placeholder="请输入操作用户"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="操作时间：" prop="loginTime">
                                <DatePicker type="daterange" placeholder="请选择操作时间" v-model="search.loginTime":editable="false" style="width: 100%;"></DatePicker>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="操作状态：" prop="loginStatus" >
                                <Select v-model="search.loginStatus" placeholder="请选择操作状态">
                                    <Option value="" >全部</Option>
                                    <Option value="1" >操作成功</Option>
                                    <Option value="2" >操作失败</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem>
                                <Button type="primary" @click="handleSubmit('search')">搜索</Button>
                                <Button type="default" @click="handleSubmit('search')">重置</Button>
                            </FormItem>
                        </Col>
                    </Row>
                </Form>
            </div>
        </Card>
        <Card :bordered="false" dis-hover>
            <Table :border="false" :columns="categoryColumns" :data="categoryData" >
                <template slot-scope="{ row, index }" slot="action">
                    <!--                      <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">预览</Button>-->
                    <Button type="error" size="small" @click="remove(index)">删除</Button>
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
                search: {
                    userName: '',
                    loginTime: '',
                    loginStatus:'',
                },

                categoryColumns: [
                    {
                        title: 'ID',
                        key: 'id',
                        width:100,
                        align:'center',
                        sortable: true
                    },
                    {
                        title: '操作用户',
                        key: 'userName',
                        width:120,
                        align:'center'
                    },
                    {
                        title: '操作URL',
                        key: 'url',
                        width:300,
                        align:'left',
                        // render: (h, params) => {
                        //   return h('div', {style:{paddingLeft:this.categoryData[params.index].id+'px'}}, this.categoryData[params.index].name)
                        // }
                    },
                    {
                        title: '操作备注',
                        key: 'mark',
                        width:550,
                        align:'left'
                    },
                    {
                        title: '操作IP',
                        key: 'IP',
                        width:120,
                        align:'left'
                    },
                    {
                        title: '操作时间',
                        key: 'loginTime',
                        width:150,
                        align:'center',
                        sortable: true
                    },
                    {
                        title: '操作状态',
                        key: 'loginStatus',
                        width:120,
                        align:'center',
                        render: (h, params) => {
                            const categoryData = this.categoryData;
                            if(categoryData[params.index].status == 1){
                                return h('Tag', {
                                    props: {
                                        color:'success'
                                    },
                                }, '操作成功')
                            }else{
                                return h('Tag', {
                                    props: {
                                        color:'error'
                                    },
                                }, '操作失败')
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
                categoryData: [
                    {
                        id: 1,
                        userName:'张三',
                        url:'http://ysuixin.cn/admin.php?m=Logs&a=loginlog&menuid=32',
                        mark:'提示语：删除登陆日志成功！' +
                            '模块：Admin,控制器：Logs,方法：deleteloginlog' +
                            '请求方式：GET',
                        IP:'127.0.0.1',
                        loginTime:'2020-8-15 11:23',
                        loginStatus:'1',
                    },
                    {
                        id: 2,
                        userName:'李四',
                        url:'http://ysuixin.cn/admin.php?m=Management&a=adminadd&menuid=22',
                        mark:'提示语：用户名不能为空！\n' +
                            '模块：Admin,控制器：Management,方法：adminadd\n' +
                            '请求方式：Ajax',
                        IP:'127.0.0.1',
                        loginTime:'2020-8-15 11:23',
                        loginStatus:'2',
                    },
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
    @import "../../../assets/style/content.css";
</style>