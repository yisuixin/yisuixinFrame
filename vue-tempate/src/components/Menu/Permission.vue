<template>
        <div>
<!--            <Spin size="large" fix v-if="loading"></Spin>-->
            <Card :bordered="false" dis-hover>
                <p slot="title">
                    页面权限组
                </p>
                <Form ref="pagePermission" :model="pagePermission" :label-width="80">
                        <div v-for="(item, index) in pagePermission.items" :key="index">
                                <Row :gutter="16">
                                    <Col span="4">
                                        <FormItem
                                                :label="'权限 ' + (index+1)"
                                                :prop="'items.' + index + '.title'"
                                                :rules="{required: true, message: '请输入权限名称', trigger: 'blur'}">
                                            <Input type="text" v-model="item.title" placeholder="请输入权限名称" style="width:200px"></Input>
                                        </FormItem>
                                    </Col>
                                    <Col span="4" offset="1">
                                        <FormItem
                                                :prop="'items.' + index + '.url'"
                                                :rules="{required: true, message: '请输入权限URL', trigger: 'blur'}">
                                            <Input type="text" v-model="item.url" placeholder="请输入权限URL" style="width:200px"></Input>
                                        </FormItem>
                                    </Col>
                                    <Col span="4" offset="2">
                                        <Button @click="handleRemove(index)" icon="ios-trash-outline">删除</Button>
                                    </Col>
                                </Row>
                        </div>
                    <FormItem>
                        <Row>
                            <Col span="12">
                                <Button type="dashed" long @click="handleAdd" icon="md-add">增加权限</Button>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem>
                        <Row>
                            <Col span="12">
                                <Button type="primary" long :loading="pagePermission.saveBtnLoading" @click="handleSubmit('pagePermission')">保存权限</Button>
                            </Col>
                        </Row>
                    </FormItem>
                </Form>
            </Card>
        </div>
</template>
<script>
    import handleMenu from "../../assets/js/handleMenu";

    export default {
        data () {
            return {
                pagePermission:{
                    saveBtnLoading:false,
                    items: [],
                },
                treeData:{},
            }
        },
        methods: {
            handleSubmit (name) {
                const that = this;
                that.$refs[name].validate((valid) => {
                    if (valid) {
                        that.pagePermission.saveBtnLoading = true;
                        if(that.pagePermission.items.length < 1){
                            that.$Message.error({
                                content:'请先添加权限',
                                onClose:function () {
                                    that.pagePermission.saveBtnLoading = false;
                                }
                            })
                            return
                        }
                        let successCallback = function(res){
                            that.$Message.info({
                                content:'保存成功',
                                onClose:function () {
                                    that.pagePermission.saveBtnLoading = false;
                                }
                            })
                        }
                        let failCallback = function(res){
                            that.$Message.error({
                                content:res.data.message,
                                onClose:function () {
                                    that.pagePermission.saveBtnLoading = false;
                                }
                            })
                        }
                        let otherCallback = function(res){
                            that.pagePermission.saveBtnLoading = false;
                        }
                        that.HTTPJS.post(that.HTTPURL.SYSTEM_SRRTING.MENU.ADD_PAGE_PERMISSION,{menuId:that.treeData.id,data:that.pagePermission.items},successCallback,failCallback,otherCallback);
                    }
                })
            },
            handleAdd () {
                this.pagePermission.items.push({
                    title: '',
                    url: '',
                });
            },
            handleRemove (index) {
                this.pagePermission.items.splice(index,1);
            },
            //通过父组件访问此方法//用来保存tree菜单的数据
            setParent(parentList,parentData){
                this.treeData = parentData;
                if(parentData.pagePermissionList && parentData.pagePermissionList.length >= 1){
                    this.pagePermission.items = parentData.pagePermissionList;
                }else{
                    this.pagePermission.items = [];
                }
                //console.log(this.treeData)
            },
        }
    }
</script>
