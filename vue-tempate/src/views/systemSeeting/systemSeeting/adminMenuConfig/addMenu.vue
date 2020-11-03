<!--<template>-->
<!--    <div>-->
<!--        <Form ref="formInline" :label-width="250"  :model="formInline" :rules="ruleInline" label-position="left" :hide-required-mark="true">-->
<!--            <Card :bordered="false" dis-hover>-->
<!--                <p slot="title">-->
<!--                    {{info}}菜单-->
<!--                </p>-->
<!--                <Alert type="warning" show-icon>-->
<!--                    注意-->
<!--                    <template slot="desc">-->
<!--                        <p>1、如果是添加"权限认证+菜单"，你可以将“是否生成前端模板”设置为“是”。设置为“是”之后；将自动生成vue模板文件。文件目录为：网站根目录/vueTempate/src/views/父级菜单名称/.../当前菜单路由名称.vue</p>-->
<!--                        <p>2、因为文件夹目录权限的原因未自动生成vue文件，你可以手动创建，创建时请遵循第一条的目录文件路径，否则有可能访问不到文件</p>-->
<!--                    </template>-->
<!--                </Alert>-->
<!--                <FormItem label="菜单父级" prop="parent_id">-->
<!--                    <div slot="label">-->
<!--                        <Row>-->
<!--                            <Col span="24" class="label-required-name">菜单父级</Col>-->
<!--                            <Col span="24" class="label-info">后台菜单最多3级;一级菜单为顶部菜单；二级菜单为左侧分组菜单名称；三级菜单为左侧路由菜单</Col>-->
<!--                        </Row>-->
<!--                    </div>-->
<!--                    <Select v-model="formInline.parent_id" style="width:319px" placeholder="请选择菜单父级">-->
<!--                        <Option value="0" label="作为一级菜单"> </Option>-->
<!--                        <Option :value="item.id" :label="item.title" :key="index"-->
<!--                                v-for="(item,index) in parentList">-->
<!--                            <span v-html="item.html_name">{{item.name}}</span>-->
<!--                        </Option>-->
<!--                    </Select>-->
<!--                </FormItem>-->
<!--                <FormItem label="菜单名称" prop="title">-->
<!--                    <div slot="label">-->
<!--                        <Row>-->
<!--                            <Col span="24" class="label-required-name">菜单名称</Col>-->
<!--                            <Col span="24" class="label-info">菜单名称最多10个字符</Col>-->
<!--                        </Row>-->
<!--                    </div>-->
<!--                    <Input type="text" v-model="formInline.title" placeholder="" style="width: 319px"></Input>-->
<!--                </FormItem>-->
<!--                <FormItem label="菜单图标" prop="icon">-->
<!--                    <div slot="label">-->
<!--                        <Row>-->
<!--                            <Col span="24" class="label-required-name">菜单图标</Col>-->
<!--                            <Col span="24" class="label-info"></Col>-->
<!--                        </Row>-->
<!--                    </div>-->
<!--                    <Input type="text"-->
<!--                           v-model="formInline.icon"-->
<!--                           :readonly="true"-->
<!--                           search-->
<!--                           @on-focus="showSelectIconModel"-->
<!--                           enter-button="选择"-->
<!--                           style="width: 319px"></Input>-->
<!--                </FormItem>-->
<!--                <FormItem label="菜单URL" prop="href">-->
<!--                    <div slot="label">-->
<!--                        <Row>-->
<!--                            <Col span="24" class="label-required-name">菜单路由名称</Col>-->
<!--                            <Col span="24" class="label-info">必须为英文；最多20个字符</Col>-->
<!--                        </Row>-->
<!--                    </div>-->
<!--                    <Input type="text" v-model="formInline.href" placeholder="" style="width: 319px"></Input>-->
<!--                </FormItem>-->
<!--                <FormItem label="菜单类型" prop="type">-->
<!--                    <div slot="label">-->
<!--                        <Row>-->
<!--                            <Col span="24" class="label-required-name">菜单类型</Col>-->
<!--                            <Col span="24" class="label-info">“权限认证+菜单”表示加入后台权限管理，纯粹是菜单项请选择只作为菜单</Col>-->
<!--                        </Row>-->
<!--                    </div>-->
<!--                    <RadioGroup v-model="formInline.type">-->
<!--                        <Radio label="1">权限认证+菜单</Radio>-->
<!--                        <Radio label="2">只作为菜单</Radio>-->
<!--                    </RadioGroup>-->
<!--                </FormItem>-->
<!--                <FormItem label="是否显示" prop="status">-->
<!--                    <div slot="label">-->
<!--                        <Row>-->
<!--                            <Col span="24" class="label-required-name">是否显示</Col>-->
<!--                            <Col span="24" class="label-info"></Col>-->
<!--                        </Row>-->
<!--                    </div>-->
<!--                    <RadioGroup v-model="formInline.status">-->
<!--                        <Radio label="1">显示</Radio>-->
<!--                        <Radio label="2">隐藏</Radio>-->
<!--                    </RadioGroup>-->
<!--                </FormItem>-->
<!--                <FormItem label="是否生成前端模板" prop="create_template">-->
<!--                    <div slot="label">-->
<!--                        <Row>-->
<!--                            <Col span="24" class="label-required-name">是否生成前端模板</Col>-->
<!--                            <Col span="24" class="label-info">如果是添加"权限认证+菜单"，需要生成前端vue文件的，请选择是；如果是显示菜单，可以选择否;-->
<!--                                <span style="color: red;">只有是添加菜单时才会生成模板，编辑时不会生成</span></Col>-->
<!--                        </Row>-->
<!--                    </div>-->
<!--                    <RadioGroup v-model="formInline.create_template">-->
<!--                        <Radio label="1">是</Radio>-->
<!--                        <Radio label="2">否</Radio>-->
<!--                    </RadioGroup>-->
<!--                </FormItem>-->
<!--            </Card>-->
<!--            <div class="addBtn">-->
<!--                <div>-->
<!--                    <Button type="primary" :loading="loading" @click="addMenu('formInline')" size="large">{{info}}</Button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </Form>-->
<!--        &lt;!&ndash;菜单图标选择列表&ndash;&gt;-->
<!--        <menu-icon ref="menuIcon" @getIcon="getIcon"></menu-icon>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--    import menuIcon from '../../../../components/Menu/icon'-->
<!--    export default {-->
<!--        components: {-->
<!--            'menu-icon':menuIcon-->
<!--        },-->
<!--        data() {-->
<!--            return {-->
<!--                parentList:[],-->
<!--                loading:false,-->
<!--                info:'添加',-->
<!--                formInline:{-->
<!--                    id:'',-->
<!--                    is_add:1,//1新增2编辑-->
<!--                    parent_id:'0',-->
<!--                    title:'',-->
<!--                    icon:'',-->
<!--                    href:'',-->
<!--                    type:'1',-->
<!--                    status:'1',-->
<!--                    create_template:'2'-->
<!--                },-->
<!--                ruleInline:{-->
<!--                    parent_id: [-->
<!--                        { required: true, message: '请选择菜单父级', trigger: 'blur' }-->
<!--                    ],-->
<!--                    title: [-->
<!--                        { required: true, message: '请输入菜单名称', trigger: 'blur' },-->
<!--                        { type: 'string', max: 10, message: '菜单名称最多10个字符', trigger: 'blur' }-->
<!--                    ],-->
<!--                    href: [-->
<!--                        { required: true, message: '请输入菜单路由名称', trigger: 'blur' },-->
<!--                        { type: 'string', max: 50, message: '菜单路由名称最多50个字符', trigger: 'blur' },-->
<!--                    ],-->
<!--                },-->
<!--            }-->
<!--        },-->
<!--        activated() {-->
<!--            this.getMenuList();//获取全部菜单列表-->
<!--            let id = this.$route.query.id;//通过id是否存在判断是新增还是编辑，如果是编辑的话，先查找编辑的信息-->
<!--            if(id != undefined){-->
<!--                this.getMenuInfo(id)-->
<!--            }else{-->
<!--                this.info='添加';-->
<!--                this.formInline.id     = '';-->
<!--                this.formInline.is_add = 1;-->
<!--            }-->
<!--            //新增子菜单-->
<!--            let parent_id = this.$route.query.parent_id;-->
<!--            if(parent_id != undefined){-->
<!--                this.setParentId(parent_id);-->
<!--            }else{-->
<!--                this.info='添加';-->
<!--                this.formInline.id     = '';-->
<!--                this.formInline.is_add = 1;-->
<!--            }-->
<!--            if(id == undefined || parent_id == undefined){-->
<!--                this.$refs['formInline'].resetFields();-->
<!--            }-->
<!--        },-->
<!--        mounted() {-->
<!--        },-->
<!--        methods: {-->
<!--            showSelectIconModel(){-->
<!--                this.$refs.menuIcon.showMoel(true)-->
<!--            },-->
<!--            getIcon(icon){-->
<!--                this.formInline.icon = icon-->
<!--                this.$refs.menuIcon.showMoel(false)-->
<!--            },-->
<!--            setParentId(parent_id){-->
<!--                let that =this;-->
<!--                setTimeout(function(){ that.formInline.parent_id  = String(parent_id); }, 1000);-->
<!--                // this.$nextTick(() => {-->
<!--                //     console.log(3)-->
<!--                //     this.formInline.parent_id  = String(parent_id);-->
<!--                //     console.log(this.formInline)-->
<!--                // })-->
<!--            },-->
<!--            //获取所有的菜单列表-->
<!--            getMenuList(){-->
<!--                let that =this;-->
<!--                let successCallback = function(res){-->
<!--                    that.parentList = res.data.data;-->
<!--                }-->
<!--                let failCallback = function(res){-->
<!--                    that.parentList = [];-->
<!--                }-->
<!--                let otherCallback = function(res){-->
<!--                    that.parentList = [];-->
<!--                }-->
<!--                that.HTTPJS.get(that.HTTPURL.MENU.LIST,{level:2},successCallback,failCallback,otherCallback);-->
<!--            },-->
<!--            //编辑时获取菜单信息-->
<!--            getMenuInfo(id){-->
<!--                const that =this;-->
<!--                that.$nextTick(() => {-->
<!--                    this.formInline.id     = id;-->
<!--                    this.formInline.is_add = 2;-->
<!--                    this.info='编辑';-->
<!--                    let successCallback = function(res){-->
<!--                        that.formInline = res.data.data;-->
<!--                    }-->
<!--                    let failCallback = function(res){-->
<!--                        // that.parentList = [];-->
<!--                    }-->
<!--                    let otherCallback = function(res){-->
<!--                        // that.parentList = [];-->
<!--                    }-->
<!--                    that.HTTPJS.get(that.HTTPURL.MENU.GET_ONLY_LMANU,{id:id},successCallback,failCallback,otherCallback);-->
<!--                })-->

<!--            },-->
<!--            //选择父级菜单时，生成菜单等级-->
<!--            selectParent(level){-->
<!--                if(level == 0){-->
<!--                    this.formInline.level = 1;-->
<!--                }else if(level == 1){-->
<!--                    this.formInline.level = 2;-->
<!--                }else if(level == 2){-->
<!--                    this.formInline.level = 3;-->
<!--                }-->

<!--            },-->
<!--            //添加或者编辑菜单-->
<!--            addMenu(name){-->
<!--                const that =this;-->
<!--                this.$refs[name].validate((valid) => {-->
<!--                    if (valid) {-->
<!--                        that.loading = true;-->
<!--                        let successCallback = function(res){-->
<!--                            that.$Message.info({-->
<!--                                content:that.info+'成功',-->
<!--                                onClose:function () {-->
<!--                                    that.loading = false;-->
<!--                                    that.$refs['formInline'].resetFields();-->
<!--                                    that.$router.push('adminMenuConfig')-->
<!--                                }-->
<!--                            })-->
<!--                        }-->
<!--                        let failCallback = function(res){-->
<!--                            that.$Message.error({-->
<!--                                content:res.data.message,-->
<!--                                onClose:function () {-->
<!--                                    that.loading = false;-->
<!--                                }-->
<!--                            })-->
<!--                        }-->
<!--                        let otherCallback = function(res){-->
<!--                            that.loading = false;-->
<!--                        }-->
<!--                        that.HTTPJS.post(that.HTTPURL.MENU.ADD_OR_EDIT,that.formInline,successCallback,failCallback,otherCallback);-->
<!--                    }-->
<!--                })-->
<!--            },-->

<!--        }-->
<!--    }-->
<!--</script>-->
<!--<style scoped>-->
<!--    /*@import "../../assets/style/addFields.css";*/-->
<!--</style>-->