<template>
    <div style="height:100%">
        <div class="logo" >
            <div class="xfind-line" v-if="!isCollapsed">
                <div class="line-h"></div>
            </div>
            <div v-if="!isCollapsed" class="logo-saiqu">
                <Avatar icon="ios-person" size="large"/>
                <span class="user-name">YsuixinCMS</span>
            </div>
            <Avatar icon="ios-person" size="large" v-else/>
        </div>
                <Menu
                        ref="side_menu"
                        :active-name="leftMenuActive"
                        :open-names="openMenuName"
                        theme="light"
                        width="230px"
                        v-if="!isCollapsed">
                    <template v-if="leftMenuIndex == 1">
                        <Submenu name="info">
                            <template slot="title">
                                <Icon :size="20" type="ios-paper"></Icon>
                                <span>后台首页</span>
                            </template>
                            <MenuItem
                                    to = "info"
                                    name="info"
                                    @click.native="clickLeftMenu('info')" >
                                <span>后台首页</span>
                            </MenuItem>
                        </Submenu>
<!--                        <Submenu name="adminData">-->
<!--                            <template slot="title">-->
<!--                                <Icon :size="20" type="md-pulse"></Icon>-->
<!--                                <span>统计数据</span>-->
<!--                            </template>-->
<!--                            <MenuItem-->
<!--                                    to = "adminData"-->
<!--                                    name="adminData"-->
<!--                                    @click.native="clickLeftMenu('adminData')" >-->
<!--                                <span>数据统计</span>-->
<!--                            </MenuItem>-->
<!--                        </Submenu>-->
                    </template>
                    <template v-if="leftMenuIndex == 2">
                        <Submenu name="basicInfo">
                            <template slot="title">
                                <Icon :size="20" type="ios-person-add"></Icon>
                                <span>个人设置</span>
                            </template>
                            <MenuItem
                                    to = "basicInfo"
                                    name="basicInfo"
                                    @click.native="clickLeftMenu('basicInfo')" >
                                <span>基本信息</span>
                            </MenuItem>
                            <MenuItem
                                    to = "safeInfo"
                                    name="safeInfo"
                                    @click.native="clickLeftMenu('safeInfo')" >
                                <span>安全信息</span>
                            </MenuItem>
                        </Submenu>
                    </template>
                    <template v-for="(menu,menu_index) in leftMenu"  v-if="leftMenuIndex == 3">
                        <Submenu :name="menu.href" v-if="menu.children" :key="menu_index">
                            <template slot="title">
                                <Icon :size="20" :type="menu.icon"></Icon>
                                <span>{{menu.title}}</span>
                            </template>
                            <!--如果菜单类型为1作为权限+菜单；为2时时只作为菜单 -->
                                <MenuItem
                                        :to = "child.type == 1 ? child.href : '#'"
                                        :name="child.href"
                                        v-for="(child ,child_index) in menu.children"
                                        :key="child_index"
                                        @click.native="clickLeftMenu(child.href)">
                                    <!--<Icon :size="20" :type="child.icon"></Icon>-->
                                    <span>{{child.title}}</span>
                                </MenuItem>
                        </Submenu>
                    </template>
                </Menu>
        <div class="dropdown-wrap"  v-if="isCollapsed">
            <div class="dw-content">
                <template  v-if="leftMenuIndex == 1">
                    <Dropdown transfer placement="right-start" >
                        <Button class="dd-btn" type="text">
                            <Icon :size="25" type="ios-paper"></Icon>
                        </Button>
                        <DropdownMenu class="dd-menu" slot="list">
                                <DropdownItem name="后台首页">
                                    <div class="ddi-wapper">
                                        <span class="ddi-text">
                                            <router-link to="info">
                                                后台首页
                                            </router-link>
                                        </span>
                                    </div>
                                </DropdownItem>
                        </DropdownMenu>
                    </Dropdown>
<!--                    <Dropdown transfer placement="right-start" >-->
<!--                        <Button class="dd-btn" type="text">-->
<!--                            <Icon :size="25" type="md-pulse"></Icon>-->
<!--                        </Button>-->
<!--                        <DropdownMenu class="dd-menu" slot="list">-->
<!--                            <DropdownItem name="统计数据">-->
<!--                                <div class="ddi-wapper">-->
<!--                                    <span class="ddi-text">-->
<!--                                            <router-link to="adminData">-->
<!--                                                数据统计-->
<!--                                            </router-link>-->
<!--                                        </span>-->
<!--                                </div>-->
<!--                            </DropdownItem>-->
<!--                        </DropdownMenu>-->
<!--                    </Dropdown>-->
                </template>

                <template  v-if="leftMenuIndex == 2">
                    <Dropdown transfer placement="right-start" >
                        <Button class="dd-btn" type="text">
                            <Icon :size="25" type="ios-person-add"></Icon>
                        </Button>
                        <DropdownMenu class="dd-menu" slot="list">
                            <DropdownItem name="基本信息">
                                <div class="ddi-wapper">
                                        <span class="ddi-text">
                                            <router-link to="basicInfo">
                                                基本信息
                                            </router-link>
                                        </span>
                                </div>
                            </DropdownItem>
                            <DropdownItem name="安全信息">
                                <div class="ddi-wapper">
                                        <span class="ddi-text">
                                            <router-link to="safeInfo">
                                                安全信息
                                            </router-link>
                                        </span>
                                </div>
                            </DropdownItem>
                        </DropdownMenu>
                    </Dropdown>
                </template>
                <template v-for="(menu,menu_index) in leftMenu"  v-if="leftMenuIndex == 3">
                    <Dropdown transfer placement="right-start" v-if="menu.children" :key="menu_index">
                        <Button class="dd-btn" type="text">
                            <Icon :size="25" :type="menu.icon"></Icon>
                        </Button>
                        <DropdownMenu class="dd-menu" slot="list">
                            <template v-for="(child, i) in menu.children">
                                <DropdownItem :name="child.name" :key="i" >
                                    <div class="ddi-wapper">
                                        <span class="ddi-text">
                                            <router-link :to="child.href">
                                                {{ child.title }}
                                            </router-link>
                                        </span>
                                    </div>
                                </DropdownItem>
                            </template>
                        </DropdownMenu>
                    </Dropdown>
                </template>
            </div>
        </div>
    </div>
</template>
<style src="../../assets/style/layout.css" scoped></style>

<script>
    import event from "../../assets/js/event";
    export default {
        data(){
            return{
                isCollapsed: false,
                openMenuName:['info','adminData'],
                leftMenuActive:'info',
                leftMenuIndex:1,
                leftMenu:[]
            }
        },
        watch: {
            openMenuName() {
                if(!this.isCollapsed){
                    this.$nextTick(() => {
                        this.$refs.side_menu.updateOpened();
                        this.$refs.side_menu.updateActiveName();
                    })
                }
            }
        },
        created(){
            event.$on('collapsedSider',(collapsedStatus)=>{
                this.isCollapsed = collapsedStatus;
            }),
            //根据顶部菜单获取左侧菜单
                event.$on('getLeftMenu',(href,topIndex)=>{
                if(href == 'home'){//如果是首页，左侧菜单的显示
                    this.leftMenuIndex = 1;
                    this.leftMenuActive = 'info';
                    // this.openMenuName = ['info','adminData'];
                    this.openMenuName = ['info'];
                    sessionStorage.setItem('leftMenuActive','info');
                    this.$router.push('/info')
                }else if(href == 'account'){//如果是个人设置，左侧菜单的显示
                    this.leftMenuIndex = 2;
                    this.leftMenuActive = 'basicInfo';
                    this.openMenuName = ['basicInfo'];
                    sessionStorage.setItem('leftMenuActive','basicInfo');
                    this.$router.push('/basicInfo')
                }else{
                    this.leftMenuIndex = 3;
                    this.leftMenu = this.allMenu[topIndex].children;
                    sessionStorage.setItem('leftMenu',JSON.stringify(this.leftMenu));
                    this.setLeftMenuOpen()
                }
            }),
                //设置左侧菜单
                event.$on('setLeftMenuActive',(href,topIndex)=>{
                    sessionStorage.setItem('leftMenuActive',href);
                    this.leftMenuActive = href;
                })
        },
        computed: {
            allMenu() {
                let allMenu = sessionStorage.getItem('allMenu');
                return  JSON.parse(allMenu);
            },
        },
        mounted:function(){
            // this.$nextTick(() => {
                let topMenuActive =  sessionStorage.getItem('topMenuActive');
                if(topMenuActive){
                    if(topMenuActive == 'home'){
                        this.leftMenuIndex = 1;
                        let leftMenuActive =  sessionStorage.getItem('leftMenuActive');
                        if(leftMenuActive){
                            this.leftMenuActive = leftMenuActive;
                        }
                    }else if(topMenuActive == 'account'){
                        this.leftMenuIndex = 2;
                        let leftMenuActive =  sessionStorage.getItem('leftMenuActive');
                        if(leftMenuActive){
                            this.leftMenuActive = leftMenuActive;
                        }
                    }else{
                        this.leftMenuIndex = 3;
                        let leftMenu =  sessionStorage.getItem('leftMenu');
                        if(leftMenu){
                            this.leftMenu = JSON.parse(leftMenu);
                            this.setLeftMenuOpen();
                        }
                        let leftMenuActive =  sessionStorage.getItem('leftMenuActive');
                        if(leftMenuActive){
                            this.leftMenuActive = leftMenuActive;
                        }
                    }
                }
            // })
        },
        methods: {
            //设置左侧菜单展开
            setLeftMenuOpen(){
                let children = this.leftMenu;
                let openMenuName = []
                children.map((item, index, arr) => {
                    openMenuName.push(item.href)
                })
                this.openMenuName = openMenuName;
            },
            //点击三级菜单跳转
            clickLeftMenu(href){
                this.leftMenuActive = href;
                sessionStorage.setItem('leftMenuActive',href);
            },
        }
    }
</script>
