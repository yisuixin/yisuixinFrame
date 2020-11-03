<template>
    <div style="height: 90vh;background: #fff;">
        <Row>
            <Col span="7" style="height:90vh;border-right: 1px solid #e8eaec;overflow-y: auto;">
                <Card :bordered="false" dis-hover>
                    <MenuTree @addMenuPage ='addMenuPage'></MenuTree>
                </Card>
            </Col>
            <Col span="17"style="height:90vh;border-right: 1px solid #e8eaec;overflow-y: auto;">
                <Card :bordered="false" dis-hover>
                    <div v-if="showCurrPage == ''">请点击左侧菜单进行操作</div>
                    <div v-else>
                        <div>
                            <component :is="showCurrPage" ref="menu"></component>
                        </div>

                    </div>
                </Card>
            </Col>
        </Row>
    </div>
</template>
<script>
    import MenuTree from '../../../components/Menu/MenuTree'
    import AddMenu from '../../../components/Menu/AddMenu'
    import Permission from '../../../components/Menu/Permission'
    import event from "../../../assets/js/event";
    export default {
        components: {MenuTree,AddMenu,Permission},
        data () {
            return {
                showCurrPage: '',
            }
        },
        methods: {
            //根据子组件返回的值进行显示右侧内容，showCurrPagetype(显示页面类型，1为添加一级菜单，2为编辑菜单，3显示页面的权限列表)
            addMenuPage:function (showCurrPagetype,TreeRoot,TreeData) {
                if(showCurrPagetype == 1){
                    this.showCurrPage = 'AddMenu';
                    this.$nextTick(() => {
                        this.$refs['menu'].setParent(TreeRoot,TreeData);
                    })
                }else if(showCurrPagetype == 2){
                    this.showCurrPage = 'AddMenu';
                    this.$nextTick(() => {
                        this.$refs['menu'].setParent(TreeRoot,TreeData);
                        this.$refs['menu'].getMenuInfo(TreeRoot,TreeData);
                    })
                }else{
                    this.showCurrPage = 'Permission';
                    this.$nextTick(() => {
                        this.$refs['menu'].setParent(TreeRoot,TreeData);
                        // console.log(TreeRoot)
                        // console.log(TreeData)
                    })
                }
            },
        }
    }
</script>
