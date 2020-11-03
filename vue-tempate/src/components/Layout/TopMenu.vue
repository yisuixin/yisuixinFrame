<template>
    <Header class="layout-header-bar">
        <div class="header-wapper">
            <div class="header-left">
                <Icon @click.native="collapsedSider" :class="rotateIcon" type="md-menu" size="28"></Icon>
                <div>
                    <Menu mode="horizontal" theme="dark" :active-name="topMenuActive" :style="{width:'100%'}">
                        <menuItem name="home" @click.native="selectTopMenu('home','')">
                            <Icon type="ios-home"></Icon>首页
                        </menuItem>
                        <menuItem :name="item.href"  v-for="(item,index) in allMenu"
                                  :key="item.id" @click.native="selectTopMenu(item.href,index)">
                            <Icon :type="item.icon"></Icon>{{item.title}}
                        </menuItem>
                    </Menu>
                </div>
            </div>
            <div class="header-right">
                <div>
                    <Menu mode="horizontal" theme="dark" :active-name="topMenuActive" :style="{width:'100%'}">
                        <span   class="topMenuRigtBtn" >
                            <Icon type="ios-expand" size="20" title="全屏" @click="handleFullScreen" v-if="!fullscreen"/>
                            <Icon type="ios-contract"  size="20" title="退出全屏" @click="closeFullScreen" v-else />
                        </span>
                        <span  class="topMenuRigtBtn" title="通知">
                            <Badge dot :offset="[20,0]">
                                <Icon type="ios-notifications-outline" size="22"></Icon>
                            </Badge>
                        </span>
                        <menuItem name="account">
                            <Dropdown transfer>
                                <p>
                                    <Avatar :src="userInfo.avatar" size="22" class="user-avatar"/> &nbsp;&nbsp;&nbsp;{{userInfo.username}}
                                </p>
                                <DropdownMenu slot="list">
                                    <DropdownItem>
                                        <Icon type="md-person"></Icon>
                                        <span @click="selectTopMenu('account','')">个人设置</span>
                                    </DropdownItem>
                                    <DropdownItem divided @click.native="loginOut"> <Icon type="ios-log-out"/> 退出登录</DropdownItem>
                                </DropdownMenu>
                            </Dropdown>
                        </menuItem>
                    </Menu>
                </div>
            </div>
        </div>
    </Header>
</template>
<style src="../../assets/style/layout.css" scoped></style>
<script>
    import event from "../../assets/js/event";
    export default {
        data(){
            return{
                isCollapsed: false,
                topMenuActive:'home',
                fullscreen: false
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
            userInfo() {
                let userInfo = sessionStorage.getItem('userInfo');
                return  JSON.parse(userInfo);
            },
            allMenu() {
                let allMenu = sessionStorage.getItem('allMenu');
                return  JSON.parse(allMenu);
            },
        },
        created(){
            //设置顶部菜单，一般在快捷操作中反应
            event.$on('setTopMenu',(href,index)=>{
                this.topMenuActive = href;
                sessionStorage.setItem('topMenuActive',href);
                event.$emit('getLeftMenu',href,index)//把选中的顶部菜单传递给LeftMenu兄弟组件
            })
        },
        mounted:function(){
            let that = this;
            that.$nextTick(() => {
                //顶部菜单选中
                let topMenuActive =  sessionStorage.getItem('topMenuActive');
                if(topMenuActive){
                    that.topMenuActive = topMenuActive;
                }
                //按esc键退出全屏
                document.addEventListener('keyup', function (e) {
                    if (e.keyCode == 27 && that.fullscreen) {
                        that.closeFullScreen();
                    }
                })
            })
        },
        methods: {
            //点击左侧收起或者展开
            collapsedSider() {
                this.isCollapsed = !this.isCollapsed
                this.$emit('changeSider');//把左侧菜单展开或者收缩状态传递给layout父组件
                event.$emit('collapsedSider',this.isCollapsed)//把左侧菜单展开或者收缩状态传递给LeftMenu兄弟组件
            },
            //点击一级菜单，更新左侧菜单
            selectTopMenu:function (href,index) {
                this.topMenuActive = href;
                sessionStorage.setItem('topMenuActive',href);
                event.$emit('getLeftMenu',href,index)//把选中的顶部菜单传递给LeftMenu兄弟组件
            },
            //全屏
            handleFullScreen(){
                    var docElm = document.documentElement;
                    if (docElm.requestFullscreen) {
                        docElm.requestFullscreen();
                    } else if (docElm.mozRequestFullScreen) {
                        docElm.mozRequestFullScreen();
                    } else if (docElm.webkitRequestFullScreen) {
                        docElm.webkitRequestFullScreen();
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    }
                this.fullscreen = true;
            },
            //退出全屏
            closeFullScreen(){
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                }else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                this.fullscreen = false;
            },
            //点击退出登录
            loginOut:function (name) {
                const that =this;
                that.$Modal.confirm({
                    title: '确认退出',
                    content: '确认退出？请确保您所做的更改已保存',
                    onOk: () => {
                        that.$Message.info({
                            content: '退出成功',
                            duration: that.COMMONJS.waritTime,
                            onClose:function(){
                                sessionStorage.clear();
                                that.$router.replace('/login')
                            }
                        });
                    },
                });
            },
        }
    }
</script>
