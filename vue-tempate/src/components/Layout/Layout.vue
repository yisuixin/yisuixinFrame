<template>
    <section class="admin-layout-container" >
        <div class="layout">
            <Layout>
                <Sider
                        ref="sidebar"
                        class="sidebar"
                        hide-trigger collapsible width="230"
                        :collapsed-width="78"
                        v-model.trim="isCollapsed">
                    <LeftMenu></LeftMenu>
                </Sider>
                <Layout>
                    <TopMenu @changeSider ='collapsedSider'></TopMenu>
                    <Content class="main-content">
                        <Layout class="main-layout-con">
                            <Content class="content-wrapper">
                                <keep-alive>
                                    <router-view/>
                                </keep-alive>
                            </Content>
                        </Layout>
                    </Content>
                </Layout>
            </Layout>
        </div>
    </section>
</template>
<style src="../../assets/style/layout.css"></style>
<script>
    import TopMenu from '../../components/Layout/TopMenu'
    import LeftMenu from '../../components/Layout/LeftMenu'
    export default {
        components: {TopMenu,LeftMenu},
        data(){
            return{
                isCollapsed: false,
            }
        },
        computed: {
            rotateIcon () {
                return [
                    'menu-icon',
                    this.isCollapsed ? 'rotate-icon' : ''
                ];
            },
            menuitemClasses () {
                return [
                    'menu-item',
                    this.isCollapsed ? 'collapsed-menu' : ''
                ]
            },
        },
        mounted:function(){


        },
        methods: {
            //点击左侧收起或者展开
            collapsedSider(data) {
                this.$refs.sidebar.toggleCollapse();
            },
        }
    }
</script>
