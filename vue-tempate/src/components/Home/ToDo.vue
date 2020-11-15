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
    /deep/ .fc-cardTitle-button{
        background: none !important;
        border: none !important;
        color: #17233d !important;
        left: 30px;
        position: absolute;
    }
    /deep/ .fc-cardTitleIcon-button{
        background: none !important;
        border: none !important;
        color: #17233d !important;
        display: inline-block;
        font-family: Ionicons;
        speak: none;
        font-style: normal;
        font-weight: 400;
        font-variant: normal;
        text-transform: none;
        text-rendering: optimizeLegibility;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        vertical-align: -.125em;
        text-align: center;
        font-size: 18px;
        color: #2d8cf0 !important;
    }
    /deep/ .fc-cardTitleIcon-button:before{
        content: "\F16D" !important;
    }
    /deep/ .toDolistMoreCss{
        display: block;
        text-align: right !important;
    }

</style>
<template>
    <div>
        <Card style="height: 830px;">
            <div>
                <!--<Spin size="large" fix v-if="toDoList.loading"></Spin>-->
                <FullCalendar ref="fullCalendar" :options="calendarOptions">
                    <template v-slot:eventContent='arg'>
                        <span style="font-size: 14px;">
                            {{ arg.timeText }}{{ arg.event.title }}
                            <Icon type="md-create"  color="#17233d" title="编辑" style="padding-left: 5px;" @click="ttt(arg.event.id)"/>
                            <Icon type="md-eye" color="#17233d" title="查看" style="padding-left: 5px;"/>
                            <Icon type="md-trash" color="#17233d" title="删除" style="padding-left: 5px;"/>
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
            FullCalendar // make the <FullCalendar> tag available
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
                        cardTitleIcon: {
                            text: '',
                        },
                        cardTitle: {
                            text: '待办事项',
                        }
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
                        left: 'cardTitleIcon cardTitle',
                        center: '',
                        right: 'prev,title,next,today,dayGridMonth,timeGridWeek,timeGridDay,listYear,addScheduleBtn'
                    },
                    dayMaxEventRows: true,
                    moreLinkClassNames:'toDolistMoreCss',
                    moreLinkContent:'+查看更多',
                    dayMaxEvents: true, // for all non-TimeGrid views
                    events: [
                        { id:'1',title: 'event 1',color:'green' ,start: '2020-11-14 10:30:00',end: '2020-11-17 11:30:00'},
                        // { id:'2',title: 'event 2',color:'red' ,start:'2020-11-13',end:'2020-11-17'},
                        // { id:'3',title: '准备李医生的货',color:'red' ,start:'2020-10-01 0000:0000:0000',end:'2020-11-01 0000:0000:0000'},
                    ],
                    // dateClick: this.eventDayClick,//每日点击事件
                    // eventClick:this.toDoClick,//待办事项点击事件
                    datesSet:this.changeDate,//日历视图改变事件
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

            }
        },
        mounted:function(){
            let that = this;

        },
        methods: {
            ttt(id){
                alert(id);
            },
            changeDate(dateInfo){
                let that = this;
                let calendarApi = this.$refs.fullCalendar.getApi()
                //console.log(calendarApi);
                let type = calendarApi.getCurrentData().currentViewType;
                if(type == 'dayGridMonth'){//获取月的事项
                    this.toDoList.search.type = 1;
                }else if(type == 'timeGridWeek'){//获取周的事项
                    this.toDoList.search.type = 2;
                }else{//获取天的的事项   timeGridDay
                    this.toDoList.search.type = 3;
                }
                this.toDoList.search.startDate = calendarApi.getCurrentData().viewApi.currentStart;
                this.toDoList.search.endtDate = calendarApi.getCurrentData().viewApi.currentEnd;
                this.toDoList.search.date = calendarApi.getCurrentData().viewTitle;
                that.getToDoList();
            },
            // eventDayClick (arg) {//点击日历上的每天，添加点击时间的待办事项
            //     let calendarApi = this.$refs.fullCalendar.getApi()
            //     console.log(arg);
            //     this.toDoAdd.formInline.start = arg.dateStr +' 00:00:00';
            //     this.addToDoModelShow(1);
            // },
            toDoClick (arg) {//获取事项详情
                console.log(arg.event);
            },
            //获取待办事项
            getToDoList:function () {
                const that =this;
                that.toDoList.loading = true;
                let successCallback = function(res){
                    that.toDoList.loading = false;
                    let list = res.data.data.list;
                    list.map((item, index, arr) => {
                        if(item.status == 1){
                            item.color = "#ff9900";
                        }else if(item.status == 2){
                            item.color = "#2db7f5";
                        }else if(item.status == 3){
                            item.color = "#19be6b";
                        }else{
                            item.color = "#ed4014";
                        }
                    })
                    that.calendarOptions.events = res.data.data.list;
                    // console.log(res.data.data.list);
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
            },
            //点击添加事项,显示model
            addToDoModelShow:function(type,index){
                if(type == 1){//增加
                    this.toDoAdd.show = true;
                    this.toDoAdd.formInline.type   = 1;
                    //this.$refs["formValidate"].resetFields();//重置表单
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
