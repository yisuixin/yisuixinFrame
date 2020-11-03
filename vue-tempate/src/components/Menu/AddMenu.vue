<template>
    <div>
        <Form ref="formInline" :label-width="250"  :model="formInline" :rules="ruleInline" label-position="left" :hide-required-mark="true">
            <Card :bordered="false" dis-hover>
                <p slot="title">
                    {{info}}菜单
                </p>
                <Alert type="warning" show-icon>
                    注意
                    <template slot="desc">
                        <p>1、如果是菜单类型是"页面"，你可以将“是否生成前端模板”设置为“是”。设置为“是”之后；将自动生成vue模板文件。文件目录为：网站根目录/vueTempate/src/views/父级菜单名称/.../当前菜单路由名称.vue</p>
                        <p>2、因为文件夹目录权限的原因未自动生成vue文件，你可以手动创建，创建时请遵循第一条的目录文件路径，否则有可能访问不到文件</p>
                    </template>
                </Alert>
                <FormItem label="菜单父级" prop="parent_id">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">菜单父级</Col>
                            <Col span="24" class="label-info">后台菜单最多3级;一级菜单为顶部菜单；二级菜单为左侧分组菜单名称；三级菜单为左侧路由菜单</Col>
                        </Row>
                    </div>
                    <treeselect v-model="formInline.parent_id"
                                placeholder="请选择菜单父级"
                                @select="selectParent"
                                @input="changeParentId"
                                :clearable="false"
                                :defaultExpandLevel = "Infinity"
                                :normalizer="parentList.normalizer"
                                noOptionsText="暂无数据"
                                :options="parentList.options" style="width:319px;"/>
                </FormItem>
                <FormItem label="菜单名称" prop="title">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">菜单名称</Col>
                            <Col span="24" class="label-info">菜单名称最多10个字符</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.title" placeholder="" style="width: 319px"></Input>
                </FormItem>
                <FormItem label="菜单图标" prop="icon">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">菜单图标</Col>
                            <Col span="24" class="label-info"></Col>
                        </Row>
                    </div>
                    <Input type="text"
                           v-model="formInline.icon"
                           :readonly="true"
                           search
                           @on-focus="showSelectIconModel"
                           enter-button="选择"
                           style="width: 319px"></Input>
                </FormItem>
                <FormItem label="菜单URL" prop="href">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">菜单路由名称</Col>
                            <Col span="24" class="label-info">必须为英文；最多20个字符</Col>
                        </Row>
                    </div>
                    <Input type="text" v-model="formInline.href" placeholder="" style="width: 319px"></Input>
                </FormItem>
                <FormItem label="菜单类型" prop="type">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">菜单类型</Col>
                            <Col span="24" class="label-info">“页面”表示是可以点击菜单后显示的页面，纯粹是显示菜单请选择菜单</Col>
                        </Row>
                    </div>
                    <RadioGroup v-model="formInline.type" @on-change="selectMenuType">
                        <Radio label="2">菜单</Radio>
                        <Radio label="1">页面</Radio>
                    </RadioGroup>
                </FormItem>
                <FormItem label="是否显示" prop="status">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">是否显示</Col>
                            <Col span="24" class="label-info"></Col>
                        </Row>
                    </div>
                    <RadioGroup v-model="formInline.status">
                        <Radio label="1">显示</Radio>
                        <Radio label="2">隐藏</Radio>
                    </RadioGroup>
                </FormItem>
                <FormItem label="是否生成前端模板" prop="create_template">
                    <div slot="label">
                        <Row>
                            <Col span="24" class="label-required-name">是否生成前端模板</Col>
                            <Col span="24" class="label-info">如果是添加"页面"，需要生成前端vue文件的，请选择是；如果只是显示菜单，可以选择否;
                                <span style="color: red;">只有是添加菜单时才会生成前端模板，编辑时不会生成</span></Col>
                        </Row>
                    </div>
                    <RadioGroup v-model="formInline.create_template">
                        <Radio label="1">是</Radio>
                        <Radio label="2">否</Radio>
                    </RadioGroup>
                </FormItem>
            </Card>
<!--            <div class="addBtn">-->
<!--                <div>-->
                    <Button type="primary" :loading="loading" @click="addMenu('formInline')" size="large">{{info}}</Button>
<!--                </div>-->
<!--            </div>-->
        </Form>
        <!--菜单图标选择列表-->
        <menu-icon ref="menuIcon" @getIcon="getIcon"></menu-icon>
    </div>
</template>

<script>
    import menuIcon from './Icon'
    import event from "../../assets/js/event"
    import Treeselect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'
    export default {
        components: {
            'menu-icon':menuIcon,
            'event':event,
            Treeselect
        },
        data() {
            return {
                treeData:{},
                parentList:{
                    options: [],
                    normalizer(node){
                        //去掉children=[]的children属性 respectively
                        if(node.children && !node.children.length){
                            delete node.children;
                        }
                    }
                },
                loading:false,
                info:'添加',
                formInline:{
                    id:'',
                    is_add:1,//1新增2编辑
                    parent_id:'0',
                    title:'',
                    icon:'',
                    href:'',
                    type:'2',
                    status:'1',
                    create_template:'2'
                },
                ruleInline:{
                    parent_id: [
                        { type: 'string', required: true, message: '请选择菜单父级', trigger: 'input' }
                    ],
                    title: [
                        { required: true, message: '请输入菜单名称', trigger: 'blur' },
                        { type: 'string', max: 10, message: '菜单名称最多10个字符', trigger: 'blur' }
                    ],
                    href: [
                        { required: true, message: '请输入菜单路由名称', trigger: 'blur' },
                        { type: 'string', max: 50, message: '菜单路由名称最多50个字符', trigger: 'blur' },
                    ],
                },
            }
        },
        methods: {
            selectMenuType(value){
                if(value == 1){
                    this.formInline.create_template = '1';
                }else{
                    this.formInline.create_template = '2';
                }
            },
            showSelectIconModel(){
                this.$refs.menuIcon.showMoel(true)
            },
            getIcon(icon){
                this.formInline.icon = icon
                this.$refs.menuIcon.showMoel(false)
            },
            //添加或者编辑菜单
            addMenu(name){
                const that =this;
                // console.log(123)
                // this.$emit('getMenuListOne','');//点击子组件的添加菜单按钮父组件显示右侧内容//点击子组件的添加菜单按钮父组件显示右侧内容
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        that.loading = true;
                        let successCallback = function(res){
                            that.$Message.info({
                                content:that.info+'成功',
                                onClose:function () {
                                    that.loading = false;
                                    that.$emit('getMenuList');//点击子组件的添加菜单按钮父组件显示右侧内容
                                    if(that.formInline.is_add == 1){//新增
                                        const children = that.treeData.children || [];
                                        children.push({
                                            id:parseInt(res.data.data.id),
                                            type: that.formInline.type,
                                            label: that.formInline.title,
                                            title: that.formInline.title,
                                            expand: true
                                        });
                                        that.$set(that.treeData, 'children', children);
                                        that.$refs['formInline'].resetFields();
                                    }else{//编辑
                                        that.treeData.type = that.formInline.type;
                                        that.treeData.label = that.formInline.title;
                                        that.treeData.title = that.formInline.title;
                                    }
                                }
                            })
                        }
                        let failCallback = function(res){
                            that.$Message.error({
                                content:res.data.message,
                                onClose:function () {
                                    that.loading = false;
                                }
                            })
                        }
                        let otherCallback = function(res){
                            that.loading = false;
                        }
                        that.HTTPJS.post(that.HTTPURL.MENU.ADD_OR_EDIT,that.formInline,successCallback,failCallback,otherCallback);
                    }
                })
            },
            //单独验证父级菜单下拉树
            changeParentId(){
                this.$nextTick(()=>{
                    this.$refs["formInline"].validateField('parent_id');
                })
            },
            //单独验证父级菜单下拉树
            selectParent(node, instanceId){
                this.$refs["formInline"].validateField('parent_id');
            },
            //通过父组件访问此方法，将父菜单下拉菜单赋值
            setParent(parentList,parentData){
                this.$refs['formInline'].resetFields();
                this.info='添加';
                this.formInline.id     = '';
                this.formInline.is_add = 1;
                this.treeData = parentData;//用来保存tree菜单的数据
                this.parentList.options = [];
                this.parentList.options.push(parentList[0].node);
                this.formInline.parent_id = parentData.id;
                this.changeParentId();
            },
            //编辑时获取菜单信息
            getMenuInfo(parentList,parentData){
                const that =this;
                const id = parentData.id;
                this.info='编辑';
                let successCallback = function(res){
                    that.formInline = res.data.data;
                    that.formInline.id     = id;
                    that.formInline.is_add = 2;
                }
                that.HTTPJS.get(that.HTTPURL.MENU.GET_ONLY_LMANU,{id:id},successCallback);
            },
        }
    }
</script>
