<template>
    <div>
        <!--整站权限设置对话框开始-->
        <Modal v-model="roleModel.show"
               width="800px"
               title='设置快捷操作菜单'
               :closable="false"
               :mask-closable="false">
            <div slot style="overflow-y:auto;height: 500px;">
                <CheckboxGroup v-model="menuIds">
                    <Card style="margin-bottom: 10px;"  v-for="(item,index) in roleModel.items" :key="index">
                            <span style="font-size: 14px;">
                                <Checkbox :label="item.id"> {{item.all_parent_title}}</Checkbox>
<!--                                <Checkbox v-model="item.checked" @click.native="checkItem()">{{item.all_parent_title}}</Checkbox>-->
                            </span>
                    </Card>
                </CheckboxGroup>
            </div>
            <div slot="footer">
                <Button  @click="showUserMenuModel(2)">取消</Button>
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
                menuIds:[]
            }
        },
        methods: {
            //获取整站权限设置菜单列表
            getRoleMenuList(RoleId){
                const that = this;
                let successCallback = function(res){
                    that.roleModel.listLoading = false;
                    that.roleModel.items   = res.data.data.list;
                    that.menuIds =  res.data.data.userQuickItem;
                }
                let failCallback = function(res){
                    that.roleModel.listLoading = false;
                    that.roleModel.items = [];
                    that.$Message.error({
                        content:'用户菜单列表数据获取失败'
                    })
                }
                that.HTTPJS.get(that.HTTPURL.QUICK_OPERATION.GET_USER_MENU_LIST,'',successCallback,failCallback);
            },
            //添加角色权限
            addRolePermission(){
                let that = this;
                const munuIds = that.getCheckMenuId();//获取勾选权限的id
                if(that.menuIds.length > 9){
                    that.$Message.error({
                        content:'只能选9个',
                    })
                    return
                }
                that.roleModel.okBtnLoading = true;
                let successCallback = function(res){
                    that.$Message.info({
                        content:res.data.message,
                        onClose:function () {
                            that.roleModel.okBtnLoading = false;
                            that.showUserMenuModel(2);
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
                that.HTTPJS.post(that.HTTPURL.QUICK_OPERATION.ADD_QUICK,{menuIds:that.menuIds},successCallback,failCallback);
            },
            //获取勾选权限的id
            getCheckMenuId(){
                let that = this;
                const data = that.roleModel.items;
                const newArray = [];
                data.map((item, index, arr) => {
                    if(item.checked != undefined && item.checked === true){
                        newArray.push(item.id);
                    }
                })
                return newArray;
            },
            showUserMenuModel:function(type){//type == 1显示，2关闭
                if(type == 1){
                    this.roleModel.show = true;
                    this.getRoleMenuList();
                }else{
                    this.roleModel.show = false;
                    this.roleModel.okBtnLoading = false;
                    this.$parent.getQuickOperationList();
                }
            },

        }
    }
</script>
