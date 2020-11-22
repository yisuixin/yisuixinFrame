<style src="../../../assets/style/home.css" scoped></style>
<template>
    <div>
        <Row style="margin-bottom: 15px;">
            <Col span="24">
                <Row :gutter="20">
                    <Col span="6">
                        <Weather></Weather>
                    </Col>
                    <Col span="6">
                        <QuickOperation></QuickOperation>
                    </Col>
                    <Col span="6">
                        <ServerInfo></ServerInfo>
                    </Col>
                    <Col span="6">
                        <Notice></Notice>
                    </Col>
                </Row>
            </Col>
        </Row>
        <Row  style="margin-bottom: 15px;">
            <Col span="24">
                <ToDo></ToDo>
            </Col>
        </Row>
    </div>
</template>

<script>
    import WebInfo from '../../../components/Home/WebInfo'
    import ServerInfo from '../../../components/Home/ServerInfo'
    import CountPerson from '../../../components/Home/CountPerson'
    import LoginLog from '../../../components/Log/LoginLog'
    import Notice from '../../../components/Home/Notice'
    import Weather from '../../../components/Home/Weather'
    import QuickOperation from '../../../components/Home/QuickOperation'
    import ToDo from '../../../components/Home/ToDo'

    export default {
        components: {WebInfo,ServerInfo,CountPerson,LoginLog,Notice,Weather,QuickOperation,ToDo},
        data () {
            return {
                // countPerson:{
                //     nowTime:formatDate(new Date( nowTime() * 1000), 'hh:mm:ss'),
                //     countDownTime: this.COMMONJS.CountDownTime,
                //     countPerson: Math.ceil(Math.random()*100),
                // },
            }
        },
        mounted:function(){
            let that = this;
        },
        methods: {

        }
    }
</script>

