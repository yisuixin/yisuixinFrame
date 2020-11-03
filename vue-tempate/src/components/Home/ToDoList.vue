<style scoped>
    .countToList{
        height: 130px;
        padding-bottom: 10px;
    }
    .countToList:hover{
        background: #f8f8f9;
        cursor: pointer;
    }
    .countToList-box{
        display:table;
        height: 120px;
        margin:0 auto;
    }
    .countToList-item{
        display:table-cell;
        vertical-align:middle;
        text-align: center;
    }
    .countToList-item-number{
        font-size: 40px;
        display: block;
    }
    .add-to-do-box{
        width: 100px;
        height: 100px;
        display:table;
        border: 1px dashed #dcdee2;
        cursor: pointer;
    }
    .add-to-do-box:hover{
        border: 1px dashed #2d8cf0;
    }
    .add-to-do-content:hover{
        color:#2d8cf0;
    }
    .add-to-do-content{
        display:table-cell;
        vertical-align:middle;
        text-align: center;
    }
    .to-do-list-box{
        padding: 10px 10px;
    }
    .to-do-list{
        padding:6px 5px;
    }
    .to-do-list:hover{
        color:#0d58ab;
    }
    .to-do-list-title{
        cursor: pointer;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
        padding-right: 20px;
    }
    .to-do-list-btn{
        cursor: pointer;
    }
    .to-do-list-btn span{
        margin-right:8px;
    }
    /deep/ .wh_content_all{
        background: #ffffff !important;
    }
    /deep/ .wh_top_tag{
        color: #515a6e !important;
    }
    /deep/ .wh_content_item{
        color: #515a6e !important;
    }
    /deep/ .wh_top_changge li{
        color: #515a6e !important;
    }
    /deep/ .wh_top_changge .wh_jiantou1{
        border-top: 1px solid #515a6e !important;
        border-left: 1px solid #515a6e !important;
    }
    /deep/ .wh_top_changge .wh_jiantou2{
        border-top: 1px solid #515a6e !important;
        border-right: 1px solid #515a6e !important;
    }
    /deep/ .wh_content_item .wh_chose_day{
        background: #e8eaec;
    }
    @media screen and (min-width: 460px) {
        /deep/ .wh_item_date:hover {
            background: #e8eaec;
            border-radius: 100px;
        }
    }
    /deep/ .wh_content_item .wh_isToday{
        background: #2b85e4;
        color: #ffffff;
        border-radius: 100px;
    }
</style>
<style>
    .haveToDoCss{
        background: #fff;
        border-radius: 100px;
        border: 1px dashed #2db7f5;
    }
</style>
<template>
        <div>
            <Card :bordered="false"  :padding="0"  style="height: 420px;">
                <Spin size="large" fix v-if="toDoList.loading"></Spin>
                <p slot="title" class="card-title-slot">
                    <Icon type="ios-checkbox-outline"  size="18" color="#2d8cf0"></Icon> 待办事项
                </p>
                <div>
                    <Row>
                        <Col span="5" style="padding: 10px 10px;">
                            <Calendar
                                    @changeMonth="calendaronMonthClick"
                                    @choseDay="calendaronDayClick"
                                    :markDateMore=monthToDo.attributes
                                    :sundayStart='true'>
                            </Calendar>
                        </Col>
                        <Col span="19" style="border-left:1px solid #e8eaec;">
                            <Row>
                                <Col span="24" style="border-bottom:1px solid #e8eaec;">
                                    <Row>
                                        <Col span="5" class="countToList" @click.native="selectToDoList(2)">
                                            <div class="countToList-box">
                                                <div class="countToList-item">
                                                    <p class="countToList-item-number" style="color: #2db7f5;">{{toDoList.countAllToDo}}</p>
                                                    <p class="">全部待办</p>
                                                    <p><Icon type="ios-analytics-outline" size="40" style="color: #2db7f5;"/></p>
                                                </div>
                                            </div>
                                        </Col>
                                        <Col span="5" class="countToList" @click.native="selectToDoList(1)">
                                            <div class="countToList-box">
                                                <div class="countToList-item">
                                                    <p class="countToList-item-number" style="color: #ff9900;">{{toDoList.countTodayToDo}}</p>
                                                    <p class="">今日待办</p>
                                                    <p><Icon type="ios-alarm-outline" size="40" style="color: #ff9900;"/></p>
                                                </div>
                                            </div>
                                        </Col>
                                        <Col span="5" class="countToList" @click.native="selectToDoList(3)">
                                            <div class="countToList-box">
                                                <div class="countToList-item">
                                                    <p class="countToList-item-number" style="color: #19be6b;">{{toDoList.countFinshToDo}}</p>
                                                    <p class="">已完成</p>
                                                    <p><Icon type="ios-checkmark-circle-outline" size="40" style="color: #19be6b;"/></p>
                                                </div>
                                            </div>
                                        </Col>
                                        <Col span="6" class="countToList" @click.native="addToDoShow(1)">
                                            <div class="countToList-box">
                                                <div class="countToList-item">
                                                    <div class="add-to-do-box" title="添加待办">
                                                        <div class="add-to-do-content">
                                                            <p><Icon type="ios-add" size="40"/></p>
                                                            <p>添加待办</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </Col>
                                    </Row>
                                </Col>
                                <Col span="24"  style="height: 238px">
                                    <div class="to-do-list-box">
                                        <div v-if="toDoList.list.length < 1" style="text-align: center;font-size: 16px;top: 50%;"> {{localTime}}没有待办事项</div>
                                        <Row class="to-do-list" v-for="(item,index) in toDoList.list" :key="index" v-else>
                                            <Col span="9" class="to-do-list-title" @click.native="viewToDo(index)">{{index + 1}}、{{item.desc}}</Col>
                                            <Col span="6" class="">需要在{{item.date | formatTime10}}之前完成</Col>
                                            <Col span="6"><Progress :percent="item.completed" /></Col>
                                            <Col span="3" class="to-do-list-btn">
                                                 <span title="编辑" @click="addToDoShow(2,index)">
                                                         <Avatar style="background-color: #2d8cf0" icon="md-create" size="18" />
                                                 </span>
                                                 <Poptip
                                                         confirm
                                                         title="确认删除此待办事项?"
                                                         @on-ok="deleToDo(item.id)"
                                                         >
                                                     <span title="删除">
                                                          <Avatar style="background-color: #ed4014" icon="md-trash" size="18"/>
                                                     </span>
                                                  </Poptip>
                                            </Col>
                                        </Row>
                                        <div class="page-box" v-if="toDoList.list.length > 0">
                                            <Page :total="toDoList.count"
                                                  show-elevator
                                                  show-total
                                                  :page-size ="toDoList.search.pageSize"
                                                  @on-change="toDoListPageChange"
                                                  @on-page-size-change = "toDoListPageSizeChange"/>
                                        </div>
                                    </div>
                                </Col>
                            </Row>
                        </Col>
                    </Row>
                </div>
            </Card>
                    <!--添加待办事项开始-->
                    <Modal v-model="toDoAdd.show"
                           :loading="toDoAdd.loading"
                           :title="toDoAdd.title"
                           :closable="false"
                           :mask-closable="false">
                        <Form ref="formValidate" :model="toDoAdd.formInline" :rules="toDoAdd.ruleValidate" :label-width="95">
                            <FormItem label="事项描述" prop="desc">
                                <Input type="textarea" v-model="toDoAdd.formInline.desc" placeholder="最多300个字符"></Input>
                            </FormItem>
                            <FormItem label="完成时间" prop="date">
                                <DatePicker type="datetime"
                                            :value="toDoAdd.formInline.date"
                                            @on-change='toDoAdd.formInline.date=$event'
                                            placeholder="事项完成时间" format="yyyy-MM-dd HH:mm"></DatePicker>之前完成
                            </FormItem>
                            <FormItem label="事项完成度" prop="completed">
                                <Row :gutter="12">
                                    <Col span="17">
                                        <Slider v-model="toDoAdd.formInline.completed" :tip-format="format"></Slider>
                                    </Col>
                                    <Col span="6">
                                        {{toDoAdd.formInline.completed}}%
                                    </Col>
                                </Row>

                            </FormItem>
                        </Form>
                        <div slot="footer">
                            <Button  @click="addToDoShow(3,'')">取消</Button>
                            <Button type="primary" :loading = 'toDoAdd.loading'@click="addToDo('formValidate')">确定</Button>
                        </div>
                    </Modal>
                    <!--添加待办事项结束-->
                    <!--查看待办事项开始-->
                    <Modal v-model="viewToDoModel.show"
                           :loading="viewToDoModel.loading"
                           :footer-hide="true"
                           title="待办事项详情">
                        <Form ref="formValidate" :model="toDoAdd.formInline" :rules="toDoAdd.ruleValidate" :label-width="95">
                            <FormItem label="事项描述" prop="desc">
                                {{viewToDoModel.data.desc}}
                            </FormItem>
                            <FormItem label="完成时间" prop="date">
                                  {{viewToDoModel.data.date | formatTime10}}
                                之前完成
                            </FormItem>
                            <FormItem label="事项完成度" prop="completed">
                                <Row :gutter="12">
                                    <Col span="17">
                                        <Slider disabled v-model="viewToDoModel.data.completed" :tip-format="format"></Slider>
                                    </Col>
                                    <Col span="6">
                                        {{viewToDoModel.data.completed}}%
                                    </Col>
                                </Row>

                            </FormItem>
                        </Form>
                    </Modal>
                    <!--查看待办事项结束-->
        </div>
</template>
<script>
    import Calendar from 'vue-calendar-component'
    export default {
        components: {
            Calendar
        },
        data() {
            return {
                localTime:'',
                monthToDo:{
                    search:{
                        year:'',
                        month:''
                    },
                    loading:false,
                    attributes:[],
                },
                toDoList:{
                    loading:false,
                    search:{
                        type:2,
                        searchKey:'',
                        page:1,
                        pageSize:5,
                        date:'',
                    },
                    count:0,
                    countAllToDo:0,
                    countFinshToDo:0,
                    countTodayToDo:0,
                    list:[]
                },
                toDoAdd:{
                    title:'添加待办事项',
                    show:false,
                    loading: false,
                    formInline: {
                        type:1,//1为新增，2为编辑
                        id:'',
                        desc: '',
                        date: '',
                        completed: 0
                    },
                    ruleValidate: {
                        desc: [
                            { required: true, message: '请输入事项描述', trigger: 'blur' },
                            { type: 'string', max: 200, message: '事项描述最多200个字符', trigger: 'blur' }
                        ],
                        date: [
                            { required: true, message: '请选择事项完成时间', trigger: 'blur' }
                        ],
                    }
                },
                viewToDoModel:{
                    loading:false,
                    show:false,
                    data:{}
                }
            };
        },
        mounted:function(){
            let that = this;
            that.getToDoList();
            that.getMonthToDoList();
        },
        methods:{
            //切换日历的月份，查询每月的待办事项
            calendaronMonthClick(event){
                const date = event.split('/');
                this.monthToDo.search.year  = date[0];
                this.monthToDo.search.month = date[1];
                this.getMonthToDoList();
            },
            //点击日历的每天，查询点击日期的待办事项
            calendaronDayClick(event){
                const date = event.split('/');
                this.toDoList.search.type  = 4;
                this.toDoList.search.date  = event;
                this.localTime = event;
                this.getToDoList();
            },
            //分页
            toDoListPageChange(page){
                this.toDoList.loading = true;
                this.toDoList.search.page = page;
                this.getToDoList();
            },
            //切换条数
            toDoListPageSizeChange(pageSize){
                this.toDoList.loading = true;
                this.toDoList.search.pageSize = pageSize;
                this.getToDoList();
            },
            format (val) {
              return '已完成: ' + val + '%';
            },
            //这是iview的bug，模态框中date组件获取不到值
            selectDate(date){
                this.toDoAdd.formInline.date = date;
            },
            //点击添加事项,显示model
            addToDoShow:function(type,index){
                if(type == 1){//增加
                    this.toDoAdd.show = true;
                    this.toDoAdd.formInline.type   = 1;
                    this.toDoList.search.type      = 2;
                    this.$refs["formValidate"].resetFields();//重置表单
                }else if(type == 2){//编辑
                    this.toDoAdd.show = true;
                    this.toDoAdd.title='编辑待办事项';
                    this.toDoAdd.formInline.type      = 2;
                    this.toDoAdd.formInline.id        =  this.toDoList.list[index].id;
                    this.toDoAdd.formInline.desc      =  this.toDoList.list[index].desc;
                    this.toDoAdd.formInline.date      =  this.dayjs.unix(this.toDoList.list[index].date).format('YYYY-MM-DD HH:mm:ss');
                    this.toDoAdd.formInline.completed =  this.toDoList.list[index].completed;
                }else{
                    this.toDoAdd.loading = false;
                    this.toDoAdd.show = false;
                    this.toDoAdd.title='添加待办事项';
                    this.$refs["formValidate"].resetFields();//重置表单
                }
            },
            //添加待办事项model
            addToDo:function(name){
                const that =this;
                let type = that.toDoAdd.formInline.type;
                let info = type == 1?'添加':'编辑';
                that.$refs[name].validate((valid,errors) => {
                    if (valid) {
                        that.toDoAdd.loading = true;
                        let successCallback = function(res){
                            that.$Message.info({
                                content:info+'成功',
                                onClose:function () {
                                    that.toDoAdd.show = false;
                                    that.toDoAdd.loading = false;
                                    that.getToDoList();
                                    that.getMonthToDoList();
                                }
                            })
                        }
                        let failCallback = function(res){
                            that.$Message.error({
                                content:res.data.message,
                                onClose:function () {
                                    // that.loginLoading = false;
                                    // that.loginText = '登录';
                                    that.toDoAdd.loading = false;
                                }
                            })
                        }
                        that.HTTPJS.post(that.HTTPURL.TODO.ADDOREDIT,that.toDoAdd.formInline,successCallback,failCallback);
                    }
                })
            },
            //选择待办事项的类别
            selectToDoList(type){
                this.toDoList.search.type  = type;
                this.getToDoList();
            },
            //获取待办事项
            getToDoList:function () {
                const that =this;
                that.toDoList.loading = true;
                let successCallback = function(res){
                    that.toDoList.loading = false;
                    that.toDoList.list = res.data.data.list;
                    that.toDoList.count = res.data.data.count;
                    that.toDoList.countAllToDo = res.data.data.countAllToDo;
                    that.toDoList.countTodayToDo = res.data.data.countTodayToDo;
                    that.toDoList.countFinshToDo = res.data.data.countFinshToDo;
                }
                let failCallback = function(res){
                    that.toDoList.loading = false;
                    that.toDoList.list = [];
                }
                let otherCallback = function(res){
                    that.toDoList.loading = false;
                    that.toDoList.list = [];
                }
                that.HTTPJS.get(that.HTTPURL.TODO.LIST,that.toDoList.search,successCallback,failCallback,otherCallback);
            },
            //获取单月的待办事项
            getMonthToDoList:function () {
                const that =this;
                that.monthToDo.loading = true;
                let successCallback = function(res){
                    that.monthToDo.loading = false;
                    that.formatMonthToDoLost(res.data.data);
                }
                let failCallback = function(res){
                    that.monthToDo.loading = false;
                    that.monthToDo.attributes[1].dates  = [];
                }
                let otherCallback = function(res){
                    that.monthToDo.loading = false;
                    that.monthToDo.attributes[1].dates  = [];
                }
                that.HTTPJS.get(that.HTTPURL.TODO.MONTH_LIST,that.monthToDo.search,successCallback,failCallback,otherCallback);
            },
            formatMonthToDoLost(data){
                let that = this;
                const newArray = [];
                data.map((item, index, arr) => {
                    newArray.push(
                        {date:item.year+'/'+item.month+'/'+item.day,className:"haveToDoCss"}
                    )
                })
                that.monthToDo.attributes = newArray;
            },
            //删除待办事项
            deleToDo:function (id) {
                const that =this;
                let successCallback = function(res){
                    that.$Message.info({
                        content: '删除成功',
                        onClose:function () {
                            that.getToDoList();
                        }
                    });
                }
                that.HTTPJS.post(that.HTTPURL.TODO.DELETETODO,{id:id},successCallback);
            },
            //查看待办事项
            viewToDo:function (index) {
                const that = this;
                that.viewToDoModel.show = true;
                that.viewToDoModel.data =that.toDoList.list[index];
                //that.viewToDoModel.data.date      =  this.dayjs.unix(this.toDoList.list[index].date).format('YYYY-MM-DD HH:mm:ss');
            }
        }
    };
</script>