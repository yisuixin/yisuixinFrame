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
</style>
<!--<style lang="less" scope>-->
<!--    @import '../../assets/style/fullCalendar.css';-->
<!--</style>-->
<template>
        <div>
<!--            <Card style="height: 900px;">-->
<!--&lt;!&ndash;               style="height: 420px;" <Spin size="large" fix v-if="toDoList.loading"></Spin>&ndash;&gt;-->
<!--&lt;!&ndash;                <p slot="title" class="card-title-slot">&ndash;&gt;-->
<!--&lt;!&ndash;                    <Icon type="ios-checkbox-outline"  size="18" color="#2d8cf0"></Icon> 待办事项&ndash;&gt;-->
<!--&lt;!&ndash;                </p>&ndash;&gt;-->
<!--                <div style="width: 98%;padding: 10px 10px;">-->
<!--                    <FullCalendar :options="calendarOptions" @dayClick="handleDateClick"/>-->
<!--                </div>-->

<!--            </Card>-->
            <Card style="height: 830px;">
                <div>
                     <FullCalendar :options="calendarOptions" @dayClick="handleDateClick"/>
                </div>
            </Card>
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
            return {
                calendarOptions: {
                    locale: cnLocale, // the initial locale
                    plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin ],
                    initialView: 'dayGridMonth',
                    customButtons: {// 自定义按钮(其实包含文字，自定义图标等，通过自定义按钮的接口实现)
                        addScheduleBtn: {
                            text: '新建事项',
                            click: function() {
                                alert(111);
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
                        listYear:'本年事项列表'
                    },
                    height: '800px',
                    headerToolbar: {
                        left: 'cardTitleIcon cardTitle',
                        center: '',
                        right: 'prev,title,next,today,dayGridMonth,timeGridWeek,timeGridDay,listYear,addScheduleBtn'
                    },
                    events: [
                        { title: 'event 1', date: '2020-11-13',color:'red' },
                        { title: 'event 2', date: '2020-11-14' }
                    ],
                    dateClick: this.handleDateClick,
                },

            }
        },
        methods: {
            handleDateClick (arg) {
                console.log(arg);
            }
        }
    }
</script>
