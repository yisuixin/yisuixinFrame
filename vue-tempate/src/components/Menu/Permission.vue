<template>
    <div>
        <Spin size="large" fix v-if="loading"></Spin>
        <Card :bordered="false" dis-hover>
            <p slot="title">
                页面权限组
            </p>
            <Alert type="warning" show-icon>
                注意
                <template slot="desc">
                    <p>1、保存权限组之后，角色需要重新分配此页面的权限</p>
                </template>
            </Alert>
            <Card :dis-hover="true" :bordered="true" style="margin-bottom: 10px;" v-for="(item, index) in tabs.items" :key="index" >
                <p slot="title">{{item.title}}</p>
                <p slot="extra">
                    <ButtonGroup size="small">
                        <Button icon="ios-create-outline" type="dashed"@click="showEditPermissionModel(1,index)" title="修改权限组标题">修改</Button>
                        <Poptip
                                :transfer="true"
                                confirm
                                title="确定删除此权限组?"
                                @on-ok="deleteTabs(index)">
                            <Button icon="ios-trash-outline" type="dashed" size="small" title="删除此权限组">删除</Button>
                        </Poptip>
                    </ButtonGroup>
                </p>
                <p style="display: inline-block;" >
                    <Input v-model="item1.url"
                           style="width: 250px;float: left;margin-right: 10px;margin-bottom: 10px;"
                           placeholder="model / controller / action"
                           v-for="(item1, index1) in item.pagePermissionItem" :key="index1">
                        <span slot="append"  @click="removeUrlItem(index,index1)" title="删除"><Icon type="md-close" /></span>
                    </Input>
                    <Button icon="ios-add" type="dashed" size="default" @click="addUrlItem(index)">添加</Button>
                </p>
            </Card>
            <Button type="dashed" icon="md-add" long class="add-content-btn" @click="addTasItem" style="margin-bottom: 10px;"size="large">添加权限组</Button>
            <Button type="primary" long class="add-content-btn" @click="saveData" :loading="tabs.loadning" style="margin-bottom: 10px;" size="large">保存权限组</Button>
        </Card>
        <!--修改权限组开始-->
        <Modal v-model="editPermissionModel.show"
               :closable="false"
               :mask-closable="false"
               title="编辑权限组">
            <Form ref="formValidate" :model="editPermissionModel.formInline" :rules="editPermissionModel.ruleInline" :label-width="95">
                <FormItem label="名称" prop="title">
                    <Input type="text" v-model="editPermissionModel.formInline.title" maxlength="10" placeholder="最多10个字符"></Input>
                </FormItem>
                <FormItem label="标识" prop="identification">
                    <Input type="text" v-model="editPermissionModel.formInline.identification" maxlength="20" placeholder="最多20个字符"></Input>
                </FormItem>
            </Form>
            <div slot="footer">
                <Button  @click="showEditPermissionModel(2,'')">取消</Button>
                <Button type="primary" :loading = 'editPermissionModel.loading'@click="editPermission('formValidate')">确定</Button>
            </div>
        </Modal>

        <!--修改权限组结束-->
    </div>
</template>
<script>
    import handleMenu from "../../assets/js/handleMenu";

    export default {
        data () {
            const validateEnglish = (rule, value, callback) => {
                if (value.trim() === '') {
                    return callback(new Error('请输入权限组标识'))
                } else if (/[^\a-\z\A-\Z_]/g.test(value)) {
                    return callback(new Error('权限组标识必须为英文或者下划线'))
                } else {
                    callback()
                }
            };
            return {
                tabs: {
                    loadning:false,
                    loadingText:'保存权限组',
                    items:[],
                },
                loading:false,
                treeData:{},
                editPermissionModel:{
                    show:false,
                    loading:false,
                    index:'',
                    formInline:{
                        identification:'',
                        title:'',
                    },
                    ruleInline:{
                        title: [
                            { required: true, message: '请输入权限组名称', trigger: 'blur' },
                            { type: 'string', max: 10, message: '权限组名称最多10个字符', trigger: 'blur' }
                        ],
                        identification: [
                            { required: true, message: '请输入权限组标识', trigger: 'blur' },
                            { type: 'string', max: 20, message: '权限组标识最多20个字符', trigger: 'blur' },
                            { required: true, trigger: 'blur', validator: validateEnglish }
                        ],
                    },

                }
            }
        },
        methods: {
            addUrlItem (index) {
                this.tabs.items[index].pagePermissionItem.push({url:''});
            },
            removeUrlItem (index, index1) {
                this.tabs.items[index].pagePermissionItem.splice(index1, 1);
            },
            deleteTabs (index) {
                this.tabs.items.splice(index, 1);
            },
            addTasItem(){
                this.tabs.items.push( {
                    id:'',
                    title:'新增',
                    pagePermissionItem:[]
                });
            },
            showEditPermissionModel(type,index){//type == 1显示，2关闭
                const that =this;
                if(type == 1){
                    that.editPermissionModel.show = true;
                    that.editPermissionModel.index = index;
                    that.editPermissionModel.formInline.title = that.tabs.items[index].title;
                    that.editPermissionModel.formInline.identification = that.tabs.items[index].identification;
                }else{
                    that.editPermissionModel.show = false;
                }
            },
            //修改权限组名称
            editPermission (name) {
                const that =this;
                that.$refs[name].validate((valid,errors) => {
                    if (valid) {
                        that.tabs.items[that.editPermissionModel.index].title = that.editPermissionModel.formInline.title;
                        that.tabs.items[that.editPermissionModel.index].identification = that.editPermissionModel.formInline.identification;
                        that.showEditPermissionModel(2,'');
                    }
                })
                // this.$Modal.confirm({
                //     render: (h) => {
                //         return h('Input', {
                //             props: {
                //                 value: this.tabs.items[index].title,
                //                 autofocus: true,
                //                 placeholder: '请输入权限组标题...'
                //             },
                //             on: {
                //                 input: (val) => {
                //                     if(val != ''){
                //                         this.tabs.items[index].title = val;
                //                     }
                //                 }
                //             }
                //         })
                //     }
                // })
            },
            //保存权限组数据
            saveData(){
                const parms = {
                    menuId:this.treeData.id,
                    data:this.tabs.items
                };
                //console.log(parms)
                const that =this;
                that.tabs.loadingText = '正在保存...';
                that.tabs.loadning = true;
                let successCallback = function(res){
                    that.$Message.info({
                        content:'保存成功，你需要去重新分配此页面的权限',
                        onClose:function () {
                            that.tabs.loadingText = '保存权限组';
                            that.tabs.loadning = false;
                        }
                    })
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:res.data.message,
                        onClose:function () {
                            that.tabs.loadingText = '保存权限组';
                            that.tabs.loadning = false;
                        }
                    })
                }
                let otherCallback = function(res){
                    that.tabs.loadingText = '保存权限组';
                    that.tabs.loadning = false;
                }
                that.HTTPJS.post(that.HTTPURL.SYSTEM_SRRTING.MENU.ADD_PAGE_PERMISSION,parms,successCallback,failCallback,otherCallback);

            },
            //获取权限列表数据
            getPagePermissionList(){
                const that =this;
                that.loading = true;
                let successCallback = function(res){
                    that.tabs.items = res.data.data;
                    that.loading = false;
                }
                let failCallback = function(res){
                    that.tabs.items = [];
                    that.loading = false;
                }
                let otherCallback = function(res){
                    that.tabs.items = [];
                    that.loading = false;
                }

                that.HTTPJS.get(that.HTTPURL.SYSTEM_SRRTING.MENU.GET_PAGE_PERMISSION_ITEM,{menuId:this.treeData.id},successCallback,failCallback,otherCallback);
            },
            //通过父组件访问此方法//用来保存tree菜单的数据
            setParent(parentList,parentData){
                this.treeData = parentData;
                this.getPagePermissionList();
                // if(parentData.pagePermission && parentData.pagePermission.list.length >= 1){
                //     this.formDynamic.items = parentData.pagePermission.list;
                // }else{
                //     this.formDynamic.items = [];
                // }
                //console.log(this.treeData)
            },
        }
    }
</script>
