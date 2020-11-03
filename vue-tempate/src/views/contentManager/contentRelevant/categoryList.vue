<template>
    <div>
        <Card :bordered="false" dis-hover>
            <div class="category-btn-list">
                <Button type="primary" icon="md-add" class="button" to="/addCategory">添加栏目</Button>
                <Button type="primary" icon="md-sync" @click="updateSort">更新排序</Button>
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
                    <span class="span-but-list">编辑</span>&nbsp;| &nbsp;
                    <span class="span-but-list">删除</span>
                </template>
            </Table>
        </Card>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                categoryColumns: [
                    {
                        title: '排序',
                        key: 'sort',
                        width:100,
                        align:'center',
                        render: (h, params) => {
                            return h('div', [
                                h('Input', {
                                    style: {
                                        padding: '8px'
                                    },
                                    props: {
                                        value: this.categoryData[params.index].sort
                                    },
                                    on: {
                                        'on-change': (event) => {
                                            console.log(this.categoryData[params.index].name)
                                        }
                                    }
                                })
                            ])
                        }
                    },
                    {
                        title: '栏目ID',
                        key: 'id',
                        width:120,
                        align:'center'
                    },
                    {
                        title: '栏目名称',
                        key: 'name',
                        width:800,
                        align:'left',
                        render: (h, params) => {
                            return h('div', {style:{paddingLeft:this.categoryData[params.index].id+'px'}}, this.categoryData[params.index].name)
                        }
                    },
                    {
                        title: '栏目类型',
                        key: 'type',
                        width:200,
                        align:'center'
                    },
                    {
                        title: '所属模型',
                        key: 'mode',
                        width:200,
                        align:'center'
                    },
                    {
                        title: '管理操作',
                        slot: 'action',
                        align: 'center',
                        key: 'action'
                    }
                ],
                categoryData: [{
                    sort: 1,
                    id: 12,
                    name: '栏目名称',
                    type:'栏目类型',
                    mode:'所属模型',
                },
                    {
                        sort: 2,
                        id: 20,
                        name: '├─ 栏目名称',
                        type:'栏目类型',
                        mode:'所属模型'
                    },
                    {
                        sort: 3,
                        id: 20,
                        name: '└─ 栏目名称',
                        type:'栏目类型',
                        mode:'所属模型',
                    },
                    {
                        sort: 4,
                        id: 12,
                        name: '栏目名称',
                        type:'栏目类型',
                        mode:'所属模型',
                    },
                    {
                        sort: 1,
                        id: 12,
                        name: '栏目名称',
                        type:'栏目类型',
                        mode:'所属模型',
                    },
                    {
                        sort: 1,
                        id: 12,
                        name: '栏目名称',
                        type:'栏目类型',
                        mode:'所属模型',
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
    @import "../../../assets/style/category.css";
</style>