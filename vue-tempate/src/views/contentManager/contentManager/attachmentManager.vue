<template>
    <div>
        <Card :bordered="false" dis-hover style="margin-bottom: 10px;">
            <div class="category-btn-list">
                <Form ref="search" :model="search" :label-width="100">
                    <Row>
                        <Col span="6">
                            <FormItem label="附件名称："prop="title">
                                <Input type="text" v-model="search.title" placeholder="请输入附件名称"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="上传时间：" prop="uploadTime">
                                <DatePicker type="daterange" placeholder="请选择上传时间" v-model="search.uploadTime":editable="false" style="width: 100%;"></DatePicker>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="附件类型：" prop="type" >
                                <Select v-model="search.type" placeholder="请选择附件类型" >
                                    <Option value="" >全部</Option>
                                    <Option value="doc" >doc</Option>
                                    <Option value="excel" >excel</Option>
                                    <Option value="img" >img</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="6">
                        </Col>
                    </Row>
                    <Row>
                        <Col span="6">
                            <FormItem label="引用状态：" prop="topping" >
                                <Select v-model="search.status" placeholder="请选择附件引用状态">
                                    <Option value="" >全部</Option>
                                    <Option value="1" >已被引用</Option>
                                    <Option value="2" >未被引用</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="8">
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
                    <span class="span-but-list">预览</span>&nbsp;| &nbsp;
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
                search: {
                    title: '',
                    author: '',
                    uploadTime: '',
                    type:'',
                    status:''
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
                        title: '上传作者',
                        key: 'author',
                        width:120,
                        align:'center'
                    },
                    {
                        title: '附件名称',
                        key: 'titleName',
                        width:150,
                        align:'center',
                        // render: (h, params) => {
                        //   return h('div', {style:{paddingLeft:this.categoryData[params.index].id+'px'}}, this.categoryData[params.index].name)
                        // }
                    },
                    {
                        title: '附件类型',
                        key: 'type',
                        width:120,
                        align:'center'
                    },
                    {
                        title: '附件大小',
                        key: 'size',
                        width:120,
                        align:'center',
                        sortable: true
                    },
                    {
                        title: '引用路径',
                        key: 'path',
                        width:400,
                        align:'left'
                    },
                    {
                        title: '上传时间',
                        key: 'uploadTime',
                        width:200,
                        align:'center',
                        sortable: true
                    },
                    {
                        title: '引用状态',
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
                                }, '已被引用')
                            }else{
                                return h('span', {
                                    style: {
                                        fontSize:'14px'
                                    },
                                }, '未被引用')
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
                        author:'张三',
                        titleName: '栏目名称',
                        type:'img',
                        size:'1024kb',
                        path:'6941baebgw1eloypk8b34j20hk070764.jpg',
                        uploadTime:'2020-8-15 11:23',
                        status:1
                    },
                    {
                        id: 2,
                        author:'张三',
                        titleName: '栏目名称',
                        type:'doc',
                        size:'2048kb',
                        path:'6941baebgw1eloypk8b34j20hk070764.jpg',
                        uploadTime:'2020-8-15 11:23',
                        status:1
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