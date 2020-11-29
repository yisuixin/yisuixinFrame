<template>
    <div>
        <Spin v-if="loading" class="spinClass">
            <span>菜单数据正在加载中，请稍后<span class="dot">...</span></span>
        </Spin>
       <Tree :data="data5" :render="renderContent" class="demo-tree-render" v-else></Tree>
    </div>
</template>
<script>
    import event from "../../assets/js/event";
    export default {
        data () {
            return {
                modal1: false,
                loading:false,
                sortList:[],
                data5: [
                    {
                        id:'0',
                        label:'作为一级菜单',
                        title: '全部菜单',
                        expand: true,
                        render: (h, { root, node, data }) => {
                            return h('span', {
                                style: {
                                    display: 'inline-block',
                                    width: '100%'
                                }
                            }, [
                                h('span', [
                                    h('Icon', {
                                        props: {
                                            type: 'ios-folder-outline',
                                        },
                                        style: {
                                            marginRight: '8px'
                                        }
                                    }),
                                    h('span', data.title)
                                ]),
                                //刷新菜单按钮
                                h('span', {
                                    domProps: {
                                        title: '刷新菜单'
                                    },
                                    style: {
                                        display: 'inline-block',
                                        float: 'right',
                                        marginRight: '40px'
                                    },
                                    directives:[
                                        {
                                            name:'auth',
                                            value:'view_menu',
                                        }
                                    ]
                                }, [
                                    h('Button', {
                                        props: Object.assign({}, this.buttonProps, {
                                            icon: 'ios-refresh',
                                            type: 'primary',
                                        }),
                                        style: {
                                            width: '100px'
                                        },
                                        on: {
                                            click: () => {
                                                this.getMenuList();
                                                //this.$emit('addMenuPage',1,root,data);//点击子组件的添加菜单按钮父组件显示右侧内容
                                            }
                                        }
                                    })
                                ]),
                                //添加一级菜单按钮
                                h('span', {
                                    domProps: {
                                        title: '添加一级菜单'
                                    },
                                    style: {
                                        display: 'inline-block',
                                        float: 'right',
                                        marginRight: '10px'
                                    }
                                }, [
                                    h('Button', {
                                        props: Object.assign({}, this.buttonProps, {
                                            icon: 'ios-add',
                                            type: 'primary',
                                        }),
                                        style: {
                                            width: '98px'
                                        },
                                        on: {
                                            click: () => {
                                                this.$emit('addMenuPage',1,root,data);//点击子组件的添加菜单按钮父组件显示右侧内容
                                            }
                                        },
                                        directives:[
                                            {
                                                name:'auth',
                                                value:'add_menu',
                                            }
                                        ]
                                    })
                                ])
                            ]);
                        },
                        children: []
                    }
                ],
                buttonProps: {
                    type: 'default',
                    size: 'small',
                }
            }
        },
        mounted() {
            this.getMenuList();
        },
        methods: {
            renderContent (h, { root, node, data }) {
                return h('span', {
                        style: {
                            display: 'inline-block',
                            width: '100%'
                        }
                    },
                    [
                        //这是名称前图标
                        h('span', [
                            h('Icon', {
                                props: {
                                    type: data.type == 2 ? 'ios-folder-outline' :'ios-paper-outline'
                                },
                                style: {
                                    marginRight: '8px'
                                }
                            }),
                            h('span', data.title)
                        ]),
                        h('span', {
                                style: {
                                    display: 'inline-block',
                                    float: 'right',
                                    marginRight: '32px'
                                }
                            },
                            //这是添加按钮和移除按钮
                            [
                                h('Button', {
                                    domProps: {
                                        title: '添加子菜单'
                                    },
                                    props: Object.assign({}, this.buttonProps, {
                                        icon: 'ios-add'
                                    }),
                                    style: {
                                        marginRight: '8px'
                                    },
                                    on: {
                                        click: () => {
                                            this.$emit('addMenuPage',1,root,data);//点击子组件的添加菜单按钮父组件显示右侧内容
                                        }
                                    },
                                    directives:[
                                        {
                                            name:'auth',
                                            value:'add_menu',
                                        }
                                    ]
                                }),
                                //添加权限
                                h('Button', {
                                    domProps: {
                                        title: '添加页面权限1',
                                    },
                                    props: Object.assign({}, this.buttonProps, {
                                        icon: 'ios-link-outline',
                                        disabled:data.type == 2 ?true:false
                                    }),
                                    style: {
                                        marginRight: '8px'
                                    },
                                    on: {
                                        click: () => {
                                            this.$emit('addMenuPage',3,root,data);//点击子组件的添加菜单按钮父组件显示右侧内容
                                        }
                                    },
                                    directives:[
                                        {
                                            name:'auth',
                                            value:'view_permission',
                                        }
                                    ],
                                }),
                                //编辑按钮
                                h('Button', {
                                    domProps: {
                                        title: '编辑菜单'
                                    },
                                    props: Object.assign({}, this.buttonProps, {
                                        icon: 'ios-create-outline'
                                    }),
                                    style: {
                                        marginRight: '8px'
                                    },
                                    on: {
                                        click: () => {
                                            this.$emit('addMenuPage',2,root,data);//点击子组件的添加菜单按钮父组件显示右侧内容
                                        }
                                    },
                                    directives:[
                                        {
                                            name:'auth',
                                            value:'edit_menu',
                                        }
                                    ]
                                }),
                                //删除按钮
                                h('Poptip', {
                                    props: {
                                        placement: 'right-start',
                                        confirm: true,
                                        transfer: true,
                                        title: '确定删除此菜单吗？',
                                    },
                                    on: {
                                        'on-ok': () => {
                                            this.remove(root, node, data)//调用删除方法
                                        },
                                        'on-cancel': () => {
                                        }
                                    }
                                }, [
                                    h('Button', {
                                        domProps: {
                                            title: '删除菜单'
                                        },
                                        props: Object.assign({}, this.buttonProps, {
                                            icon: 'ios-trash-outline'
                                        }),
                                        style: {
                                            marginRight: '8px'
                                        },
                                        directives:[
                                            {
                                                name:'auth',
                                                value:'del_menu',
                                            }
                                        ],
                                    })
                                ]),
                                //排序输入框
                                h('InputNumber', {
                                    domProps: {
                                        title: '菜单排序'
                                    },
                                    props: {
                                        size: 'small',
                                        value:parseInt(data.sort),
                                        min:1
                                    },
                                    style: {
                                        marginRight: '8px'
                                    },
                                    on: {
                                        'on-change': (sortVal) => {
                                            //data.sort = sortVal;
                                            this.updateMenuSort(data,sortVal);//输入框数字改变时的方法
                                        }
                                    },
                                    directives:[
                                        {
                                            name:'auth',
                                            value:'sort_menu',
                                        }
                                    ]
                                }),
                            ])
                    ]);
            },
            //删除菜单方法
            remove (root, node, data) {
                    const that =this;
                    const id = node.node.id;
                    let successCallback = function(res){
                        that.$Message.info({
                            content:'删除成功',
                            onClose:function () {
                                const parentKey = root.find(el => el === node).parent;
                                const parent = root.find(el => el.nodeKey === parentKey).node;
                                const index = parent.children.indexOf(data);
                                parent.children.splice(index, 1);
                            }
                        })
                    }
                    let failCallback = function(res){
                        that.$Message.error(res.data.message);
                    }
                    that.HTTPJS.post(that.HTTPURL.SYSTEM_SRRTING.MENU.DELETE_MENU,{id:id},successCallback,failCallback);
            },
            //获取菜单列表
            getMenuList(){
                const that =this;
                that.loading = true;
                    let successCallback = function(res){
                        that.data5[0].children = res.data.data;
                        that.loading = false;
                    }
                    let failCallback = function(res){
                        that.data5[0].children = [];
                        that.loading = false;
                    }
                    let otherCallback = function(res){
                        that.data5[0].children = [];
                        that.loading = false;
                    }
                    that.HTTPJS.get(that.HTTPURL.SYSTEM_SRRTING.MENU.LIST,'',successCallback,failCallback,otherCallback);
            },
            //点击排序按钮
            updateMenuSort(data,sortVal){
                const that = this;
                let successCallback = function(res){
                    that.$Message.info({
                        content:'排序成功',
                        onClose:function () {
                            data.sort = sortVal
                        }
                    })
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:'排序失败，未知错误',
                    })
                }
                that.HTTPJS.post(that.HTTPURL.SYSTEM_SRRTING.MENU.SORT_MENU,{id:data.id,sortVal:sortVal},successCallback,failCallback);
            }
        }
    }
</script>
<style>
    .demo-tree-render .ivu-tree-title{
        width: 100%;
    }
</style>