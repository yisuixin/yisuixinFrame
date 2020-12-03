<style scoped>
    /deep/ .fc-day {
        /*width: 90px !important;*/
    }
    /deep/ .fc-col-header{
        width: 100% !important;
    }
    /deep/ .fc-daygrid-body {
        width: 100% !important;
    }
    /deep/ .fc-scrollgrid-sync-table {
        width: 100% !important;
    }
    /deep/ .fc-scrollgrid-sync-table tr td{
        /*background: red;*/
    }
    /deep/ .fc-addScheduleBtn-button{
        background: #0e64c3 !important;
        border: none !important;
    }
    /deep/ .fc-toolbar-chunk div{
        display: flex;
    }
    /deep/ .fc-prev-button{
        background: none !important;
        border: none !important;
        color: #515a6e;
    }
    /deep/ .fc-prev-button:hover{
        color: #515a6e;
    }
    /deep/ .fc-next-button{
        background: #ffffff !important;
        border: none !important;
        color: #515a6e;
    }
    /deep/ .fc-next-button:hover{
        color: #515a6e;
    }
    /deep/ .fc-toolbar-title{
        font-size: 18px;
        padding-top: 5px;
        font-weight: unset;
        color: #515a6e;
    }
    /deep/ .fc-button:focus,.fc-button:active:focus,
    .fc-button.active:focus,.fc-button.focus,
    .fc-button:active.focus,.fc-button.active.focus{
        outline: none !important;
        border-color: transparent !important;
        box-shadow:none !important;
    }
    /deep/ .fc-today-button,/deep/ .fc-dayGridMonth-button,/deep/ .fc-timeGridWeek-button,/deep/ .fc-timeGridDay-button,/deep/ .fc-listYear-button{
        background: #0e64c3 !important;
        border: none !important;
        margin-right: 10px;
        border-radius: 0.25em !important;
    }
    /deep/ .fc-button-active{
        background: #c5c8ce !important;
    }

    /deep/ a{
        color: #515a6e;
    }
    /deep/ .fc-header-toolbar{
        border-bottom: 1px solid #e8eaec !important;
        padding: 16px 16px 10px 16px !important;
    }
    /deep/ .ivu-card-body{
        padding: 0px !important;
    }
    /deep/ .fc .fc-view-harness-active > .fc-view {
        position: absolute;
        top: 0;
        right: 18px;
        bottom: 0;
        left: 18px;
    }

    /deep/ .toDolistMoreCss{
        display: block;
        text-align: right !important;
    }
    .to-do-list-event-icon{
        padding-left: 5px;
        cursor: pointer;
    }
    /deep/ .not-start{
        border: 2px solid #2db7f5 !important;
        color: #000000 !important;
        background: #ffffff !important;
    }
    /deep/ .doing{
        border: 2px solid #2b85e4 !important;
        color: #000000 !important;
        background: #ffffff !important;
    }
    /deep/ .finsh{
        border: 2px solid #19be6b !important;
        color: #000000 !important;
        background: #ffffff !important;
    }
    /deep/ .overdue{
        color: #000000 !important;
        border: 2px solid #ed4014 !important;
        background: #ffffff !important;
    }
    /deep/ .not-start .fc-event-main,/deep/ .doing .fc-event-main,/deep/ .finsh .fc-event-main,/deep/ .overdue .fc-event-main {
        color: #000000 !important;
    }
    /deep/ .fc-eventBadge_not_start_icon-button,/deep/ .fc-eventBadge_doing_icon-button,/deep/ .fc-eventBadge_finsh_icon-button,/deep/ .fc-eventBadge_overdue_icon-button {
        width: 14px  !important;
        height: 14px  !important;
        font: 12px/18px Arial  !important;
        display: inline-block  !important;
        vertical-align: middle  !important;
        position: relative  !important;
        border: none;
        margin-top: 10px;
    }
    /deep/ .fc-eventBadge_not_start_icon-button{
        background: #2db7f5 !important;
    }
    /deep/ .fc-eventBadge_doing_icon-button{
        background: #2b85e4 !important;
    }
    /deep/ .fc-eventBadge_finsh_icon-button{
        background: #19be6b !important;
    }
    /deep/ .fc-eventBadge_overdue_icon-button{
        background: #ed4014 !important;
    }
    /deep/ .fc-eventBadge_not_start-button,/deep/ .fc-eventBadge_doing-button,/deep/ .fc-eventBadge_finsh-button,/deep/ .fc-eventBadge_overdue-button{
        background: #ffffff !important;
        color: #0e0620;
        border: none;
    }
    /deep/ .fc-eventBadge_not_start-button:hover,/deep/ .fc-eventBadge_doing-button:hover,/deep/ .fc-eventBadge_finsh-button:hover,/deep/ .fc-eventBadge_overdue-button:hover{
        background: #ffffff !important;
        color: #0e0620;
        border: none;
    }

</style>
<template>
    <div>
        <Card style="height: 900px;">
            <p slot="title" class="card-title-slot">
                <Icon type="ios-locate-outline"  size="18" color="#2d8cf0"></Icon> 待办事项
            </p>
            <div>
                <!--<Spin size="large" fix v-if="toDoList.loading"></Spin>-->
                <FullCalendar ref="fullCalendar" :options="calendarOptions">
                    <template v-slot:eventContent='arg'>
                        <span style="font-size: 14px;">
                            <span>{{ arg.timeText }}</span>
                            <span v-if="arg.view.type != 'listYear'"> - </span>
                            <span>{{ arg.event.title | reBytesStr(14)}}</span>
                            <Icon type="md-create"  color="#515a6e" title="编辑" class="to-do-list-event-icon" @click="addToDoModelShow(2,arg.event.id)"/>
                            <Icon type="md-eye" color="#515a6e" title="查看" class="to-do-list-event-icon" @click="viewToDo(arg.event.id)"/>
                            <Poptip
                                    confirm
                                    transfer
                                    title="确定删除此待办事项吗?"
                                    @on-ok="deleToDo(arg.event.id)">
                                        <Icon type="md-trash" color="#515a6e" title="删除" class="to-do-list-event-icon"/>
                                    </Poptip>

                        </span>
                    </template>
                </FullCalendar>
            </div>
        </Card>
        <!--添加待办事项开始-->
        <Modal v-model="toDoAdd.show"
               :loading="toDoAdd.loading"
               :title="toDoAdd.title"
               :closable="false"
               :mask-closable="false">
            <Spin v-if="toDoAdd.formInline.type == 2 && toDoAdd.loading"></Spin>
            <Form ref="formValidate" :model="toDoAdd.formInline" :rules="toDoAdd.ruleValidate" :label-width="95">
                <FormItem label="标题" prop="title">
                    <Input type="text" v-model="toDoAdd.formInline.title" placeholder="最多30个字符"></Input>
                </FormItem>
                <FormItem label="说明" prop="desc">
                    <Input type="textarea" v-model="toDoAdd.formInline.desc" placeholder="最多300个字符"></Input>
                </FormItem>
                <FormItem label="开始时间" prop="start">
                    <DatePicker type="datetime"
                                :editable="false"
                                :options="toDoAdd.startDateOptions"
                                :start-date="toDoAdd.startDate"
                                :value="toDoAdd.formInline.start"
                                @on-change='toDoAdd.formInline.start=$event'
                                placeholder="事项开始时间" format="yyyy-MM-dd HH:mm:ss"></DatePicker>
                </FormItem>
                <FormItem label="结束时间" prop="end">
                    <DatePicker type="datetime"
                                :editable="false"
                                :options="toDoAdd.startDateOptions"
                                :value="toDoAdd.formInline.end"
                                @on-change='toDoAdd.formInline.end=$event'
                                placeholder="事项结束时间" format="yyyy-MM-dd HH:mm:ss"></DatePicker>
                </FormItem>
                <FormItem label="状态" prop="status">
                    <RadioGroup v-model="toDoAdd.formInline.status">
                        <Radio label="1">未开始</Radio>
                        <Radio label="2">进行中</Radio>
                        <Radio label="3">已完成</Radio>
                        <Radio label="4">已过期</Radio>
                    </RadioGroup>
                </FormItem>
            </Form>
            <div slot="footer">
                <Button  @click="addToDoModelShow(3,'')">取消</Button>
                <Button type="primary" :loading = 'toDoAdd.loading'@click="addToDo('formValidate')">确定</Button>
            </div>
        </Modal>
        <!--添加待办事项结束-->
        <!--查看待办事项开始-->
        <Modal v-model="viewToDoModel.show"
               :loading="viewToDoModel.loading"
               :footer-hide="true"
               title="待办事项详情">
            <Spin v-if="viewToDoModel.loading"></Spin>
            <Form :label-width="95" v-else>
                <FormItem label="标题">
                    {{viewToDoModel.data.title}}
                </FormItem>
                <FormItem label="说明">
                   {{viewToDoModel.data.desc}}
                </FormItem>
                <FormItem label="开始时间">
                    {{viewToDoModel.data.start | formatTime10}}
                </FormItem>
                <FormItem label="结束时间">
                    {{viewToDoModel.data.end | formatTime10}}
                </FormItem>
                <FormItem label="状态">
                    <RadioGroup v-model="viewToDoModel.data.status">
                        <Radio :label='1' disabled>未开始</Radio>
                        <Radio :label='2' disabled>进行中</Radio>
                        <Radio :label='3' disabled>已完成</Radio>
                        <Radio :label='4' disabled>已过期</Radio>
                    </RadioGroup>
                </FormItem>
            </Form>
        </Modal>
        <!--查看待办事项结束-->
    </div>
</template>
<script>
    import { Calendar } from '@fullcalendar/core';
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import cnLocale from '@fullcalendar/core/locales/zh-cn'
    import timeGridPlugin from '@fullcalendar/timegrid';
    import listPlugin from '@fullcalendar/list';
    export default {
        components: {
            FullCalendar
        },
        data() {
            let that = this;
            return {
                calendarOptions: {
                    locale: cnLocale, // the initial locale
                    plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin ],
                    initialView: 'dayGridMonth',
                    customButtons: {// 自定义按钮(其实包含文字，自定义图标等，通过自定义按钮的接口实现)
                        addScheduleBtn: {
                            text: '新建事项',
                            click: function() {
                                that.addToDoModelShow(1);
                            }
                        },
                        eventBadge_not_start_icon: {
                            text: '',
                        },
                        eventBadge_not_start: {
                            text: '未开始',
                        },
                        eventBadge_doing_icon: {
                            text: '',
                        },
                        eventBadge_doing: {
                            text: '进行中',
                        },
                        eventBadge_finsh_icon: {
                            text: '',
                        },
                        eventBadge_finsh: {
                            text: '已完成',
                        },
                        eventBadge_overdue_icon: {
                            text: '',
                        },
                        eventBadge_overdue: {
                            text: '已过期',
                        },
                    },
                    buttonText: {
                        addScheduleBtn:'新建事项',
                        today: '今天',
                        month: '月',
                        week: '周',
                        day: '天',
                        listYear:'本年事项列表',
                    },
                    noEventsText:'暂时没有待办事项',
                    height: '800px',
                    headerToolbar: {
                        left:  'eventBadge_not_start_icon,eventBadge_not_start,eventBadge_doing_icon,eventBadge_doing,eventBadge_finsh_icon,eventBadge_finsh,eventBadge_overdue_icon,eventBadge_overdue',
                        center: '',
                        right: 'prev,title,next,today,dayGridMonth,timeGridWeek,timeGridDay,listYear,addScheduleBtn'
                    },
                    dayMaxEventRows: true,
                    moreLinkClassNames:'toDolistMoreCss',
                    moreLinkContent:'+查看更多',
                    dayMaxEvents: true, // for all non-TimeGrid views
                    events: [],
                    datesSet:this.changeDateView,//日历视图改变事件
                },
                toDoList:{
                    loading:false,
                    search:{
                        type:1,
                        searchKey:'',
                        date:'',
                        startDate:'',
                        endtDate:'',
                    },
                },
                toDoAdd:{
                    //设置事项开始时间不能选择当前时间以前
                    startDateOptions: {
                        disabledDate (date) {
                            return date && date.valueOf() < Date.now() - 86400000;
                        }
                    },
                    title:'添加待办事项',
                    show:false,
                    loading: false,
                    formInline: {
                        title:'',
                        type:1,//1为新增，2为编辑
                        id:'',
                        desc: '',
                        start: '',
                        end: '',
                        status: '2'
                    },
                    ruleValidate: {
                        title: [
                            { required: true, message: '请输入事项标题', trigger: 'blur' },
                            { type: 'string', max: 20, message: '事项标题最多20个字符', trigger: 'blur' }
                        ],
                        desc: [
                            { type: 'string', max: 200, message: '事项说明最多200个字符', trigger: 'blur' }
                        ],
                        start: [
                            { required: true, message: '请选择事项开始时间', trigger: 'blur' }
                        ],
                        end: [
                            { required: true, message: '请选择事项结束时间', trigger: 'blur' }
                        ],
                        status: [
                            { required: true, message: '请选择事项状态', trigger: 'blur' }
                        ],
                    }
                },
                //查看待办事项模型
                viewToDoModel:{
                    loading:false,
                    show:false,
                    data:{}
                }
            }
        },
        mounted:function(){
            let that = this;

        },
        methods: {
            //编辑待办事项
            editToDo(id){
                const that = this;
                that.toDoAdd.show = true;
                that.toDoAdd.loading = true;
                let successCallback = function(res){
                    that.toDoAdd.loading = false;
                    let data = res.data.data;
                    that.toDoAdd.title='编辑待办事项';
                    that.toDoAdd.formInline.type      = 2;
                    that.toDoAdd.formInline.title = data.title;
                    that.toDoAdd.formInline.id =  data.id;
                    that.toDoAdd.formInline.desc =  data.desc;
                    that.toDoAdd.formInline.start =  that.dayjs.unix(data.start).format('YYYY-MM-DD HH:mm:ss');
                    that.toDoAdd.formInline.end =    that.dayjs.unix(data.end).format('YYYY-MM-DD HH:mm:ss');
                    that.toDoAdd.formInline.status =  data.status.toString();
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:res.data.message,
                        onClose:function () {
                            that.viewToDoModel.loading = false;
                            that.viewToDoModel.loading = false;
                        }
                    })
                }
                that.getToDoView({id:id},successCallback,failCallback);
            },
            //查看待办事项
            viewToDo(id){
                const that = this;
                that.viewToDoModel.loading = true;
                that.viewToDoModel.show = true;
                let successCallback = function(res){
                    that.viewToDoModel.loading = false;
                    that.viewToDoModel.data = res.data.data;
                }
                let failCallback = function(res){
                    that.$Message.error({
                        content:res.data.message,
                        onClose:function () {
                            that.viewToDoModel.loading = false;
                            that.viewToDoModel.loading = false;
                        }
                    })
                }
                that.getToDoView({id:id},successCallback,failCallback);
            },
            //删除待办事项
            deleToDo(id){
                const that =this;
                let successCallback = function(res){
                    that.$Message.info({
                        content: '删除成功',
                        onClose:function () {
                            that.getToDoList();
                        }
                    });
                }
                that.HTTPJS.post(that.HTTPURL.COMMON.TODO.DELETETODO,{id:id},successCallback);
            },
            //改变日历日期事件
            changeDateView(type){
                let that = this;
                let calendarApi = this.$refs.fullCalendar.getApi();
                this.toDoList.search.startDate = calendarApi.getCurrentData().viewApi.currentStart;
                this.toDoList.search.endtDate = calendarApi.getCurrentData().viewApi.currentEnd;
                this.toDoList.search.date = calendarApi.getCurrentData().viewTitle;
                that.getToDoList();
            },
            //获取待办事项详情
            getToDoView:function (parms,successCallback,failCallback) {
                this.HTTPJS.get(this.HTTPURL.COMMON.TODO.VIEWTODO,parms,successCallback,failCallback);
            },
            //获取待办事项列表
            getToDoList:function (dateInfo) {
                const that =this;
                let calendarApi = this.$refs.fullCalendar.getApi();
                let events = calendarApi.getEvents();
                if (events.length > 0) {
                    events.map((item, index, arr) => {//这里一定要用日历组件自带的方法，不能直接赋值，否则会死循环
                        item.remove()
                    })
                }
                let successCallback = function(res){
                    that.toDoList.loading = false;
                    let list = res.data.data.list;
                    list.map((item, index, arr) => {
                        if(item.status == 1){
                            item.className = 'not-start';
                        }else if(item.status == 2){
                            item.className = 'doing';
                        }else if(item.status == 3){
                            item.className = 'finsh';
                        }else if(item.status == 4){
                            item.className = 'overdue';
                        }

                        calendarApi.addEvent(item)//这里一定要用日历组件自带的方法，不能直接赋值，否则会死循环
                    })
                }
                let failCallback = function(res){
                    that.toDoList.loading = false;
                    that.calendarOptions.events = [];
                }
                let otherCallback = function(res){
                    that.toDoList.loading = false;
                    that.calendarOptions.events = [];
                }
                that.HTTPJS.get(that.HTTPURL.COMMON.TODO.LIST,that.toDoList.search,successCallback,failCallback,otherCallback);
                return
            },
            //点击添加事项,显示model
            addToDoModelShow:function(type,id){
                if(type == 1){//增加
                    this.toDoAdd.show = true;
                    this.toDoAdd.formInline.type   = 1;
                    //this.$refs["formValidate"].resetFields();//重置表单
                }else if(type == 2){//编辑
                    this.editToDo(id);
                }else{
                    this.toDoAdd.loading = false;
                    this.toDoAdd.show = false;
                    this.toDoAdd.title='添加待办事项';
                    this.$refs["formValidate"].resetFields();//重置表单
                }
            },
            //添加待办事项
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
                                    that.$refs["formValidate"].resetFields();//重置表单
                                    that.getToDoList();
                                }
                            })
                        }
                        let failCallback = function(res){
                            that.$Message.error({
                                content:res.data.message,
                                onClose:function () {
                                    that.toDoAdd.loading = false;
                                }
                            })
                        }
                        that.HTTPJS.post(that.HTTPURL.COMMON.TODO.ADDOREDIT,that.toDoAdd.formInline,successCallback,failCallback);
                    }
                })
            },
        }
    }
</script>
