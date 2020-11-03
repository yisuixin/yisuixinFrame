<template>
    <div>
        <!--整站权限设置对话框开始-->
        <Modal v-model="roleModel.show"
               width="800px"
               title='站点页面权限列表'
               :closable="false"
               :mask-closable="false">
            <div slot style="overflow-y:auto;height: 500px;">
<!--                <CheckboxGroup @on-change="checkPermission">-->
                    <Card :dis-hover="true" :bordered="true" style="margin-bottom: 10px;" v-for="(item,index) in roleModel.items" :key="index">
                        <p slot="title">
                           <span style="font-size: 14px;">{{item.all_parent_title}}</span>
                        </p>
                        <p>
                            <Row>
                                <Col span="6" v-for="(item1,index1) in item.pagePermissionList" :key="index1" style="margin-bottom: 10px;">
<!--                                    @on-change="checkPermission($event,item.all_parent_id,item1.url)"-->
                                    <Checkbox v-model="item1.checked">
                                        <span style="font-size: 14px;margin-bottom: 10px;">{{item1.title}}</span>
                                    </Checkbox>
                                </Col>
                            </Row>
                        </p>
                    </Card>
<!--                </CheckboxGroup>-->
            </div>
            <div slot="footer">
                <Button  @click="showWebRoleModel(2,'')">取消</Button>
                <Button type="primary" :loading="roleModel.okBtnLoading" @click="addRolePermission('formValidate')">确定</Button>
            </div>
        </Modal>
        <!--整站权限设置对话框结束-->
    </div>
</template>
<script>
    export default {
        data () {
            return {
                roleId:'',
                roleModel:{
                    listLoading:true,
                    okBtnLoading:false,
                    show:false,
                    items:[],
                },
                permissionsData:{
                    urlItems:[],
                    menuIdItems:[]
                }
            }
        },
        methods: {
            //获取整站权限设置菜单列表
            getRoleMenuList(RoleId){
                const that = this;
                let successCallback = function(res){
                    that.roleModel.listLoading = false;
                    that.roleModel.items = res.data.data;
                }
                let failCallback = function(res){
                    that.roleModel.listLoading = false;
                    that.roleModel.items = [];
                    that.$Message.error({
                        content:'权限列表菜单数据获取失败'
                    })
                }
                that.HTTPJS.get(that.HTTPURL.MENU.GET_ROLE_PAGE_PERMISSION_ITEM,{roleId:RoleId},successCallback,failCallback);
            },
            //添加角色权限
            addRolePermission(){
                let that = this;
                that.getCheckMenuId();//获取勾选权限的id
                that.roleModel.okBtnLoading = true;
                let successCallback = function(res){
                    that.$Message.info({
                        content:res.data.message,
                        onClose:function () {
                            that.roleModel.okBtnLoading = false;
                            that.showWebRoleModel(2);
                        }
                    })
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:res.data.message,
                        onClose:function () {
                            that.roleModel.okBtnLoading = false;
                        }
                    })
                }
                that.HTTPJS.post(that.HTTPURL.ROLE.ADD_ROLE_PERMISSION,{roleId:that.roleId,permissionsData:that.permissionsData},successCallback,failCallback);
            },
            //获取勾选权限的id
            getCheckMenuId(){
                let that = this;
                that.permissionsData.urlItems = [];
                that.permissionsData.menuIdItems = [];
                const data = that.roleModel.items;
                data.map((item, index, arr) => {
                    item.pagePermissionList.map((item1, index1, arr1) => {
                        if(item1.checked != undefined && item1.checked === true){
                            that.permissionsData.menuIdItems.push(item.all_parent_id);
                            that.permissionsData.urlItems.push(item1.url);
                        }
                    })
                })
                //console.log(newArray)
            },
            showWebRoleModel:function(type,roleId){//type == 1显示，2关闭
                if(type == 1){
                    this.roleModel.show = true;
                    this.roleId = roleId;
                    this.getRoleMenuList(roleId);
                }else{
                    this.roleModel.show = false;
                    this.roleModel.okBtnLoading = false;
                }
            }

        }
    }
</script>
