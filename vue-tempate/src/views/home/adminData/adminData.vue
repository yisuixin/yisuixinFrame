<template>
    <div>
        <!--后台信息开始-->
        <Row :gutter="16"style="margin-bottom: 15px;margin-right: 30px;">
            <Col span="24">
                <Row :gutter="16">
                    <Col span="6">
                        <Card :bordered="false" class="admin-data-count-box">
                            <span class="data-info-box"><Avatar style="background-color: #2d8cf0" icon="md-contact" size="18px"/></span>
                            <span class="data-info-box number-data">100</span>
                            <span class="data-info-box number-data-name"><p>管理员 / 个</p></span>
                        </Card>
                    </Col>
                    <Col span="6">
                        <Card :bordered="false" class="admin-data-count-box">
                            <span class="data-info-box"><Avatar style="background-color: #2d8cf0" icon="md-funnel" size="18px"/></span>
                            <span class="data-info-box number-data">8</span>
                            <span class="data-info-box number-data-name"><p>栏目 / 个</p></span>
                        </Card>
                    </Col>
                    <Col span="6">
                        <Card :bordered="false" class="admin-data-count-box">
                            <span class="data-info-box"><Avatar style="background-color: #2d8cf0" icon="md-clipboard" size="18px"/></span>
                            <span class="data-info-box number-data">100</span>
                            <span class="data-info-box number-data-name"><p>内容 / 篇</p></span>
                        </Card>
                    </Col>
                    <Col span="6">
                        <Card :bordered="false" class="admin-data-count-box">
                            <span class="data-info-box"><Avatar style="background-color: #2d8cf0" icon="md-aperture" size="18px"/></span>
                            <span class="data-info-box number-data">20</span>
                            <span class="data-info-box number-data-name"><p>主题 / 套</p></span>
                        </Card>
                    </Col>
                </Row>
            </Col>
        </Row>
        <!--后台信息结束-->
        <!--后台信息开始-->
        <div>
            <Row style="margin-bottom: 15px;margin-right: 31px;">
                <Col span="24">
                    <Card :bordered="false">
                        <p slot="title" style="font-size: 14px;height: 30px;">
                            <Avatar style="background-color: #2d8cf0" icon="ios-stats" size="small"/> 前台访问数据
                        </p>
                        <p slot="extra" style="cursor: pointer;" title="更多">
                            <DatePicker type="daterange" placeholder="选择日期" style="width: 200px"></DatePicker>
                        </p>
                        <Row>
                            <Col span="14" style="height: 400px;">
                                <strong>访问量趋势</strong>
                                <ve-line :data="chartData" :settings="chartSettings" :extend="extend"></ve-line>
                            </Col>
                            <!--                            <Col span="2">123-->
                            <!--                            </Col>-->
                            <Col span="10">
                                <strong>访问量排行</strong>
                                <ul class="view-top-list">
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#2d8cf0',marginRight:'8px'}"size="small">1</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#2d8cf0',marginRight:'8px'}"size="small">2</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#2d8cf0',marginRight:'8px'}"size="small">3</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#ccc',marginRight:'8px'}"size="small">4</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#ccc',marginRight:'8px'}"size="small">5</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#ccc',marginRight:'8px'}"size="small">6</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#ccc',marginRight:'8px'}"size="small">7</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#ccc',marginRight:'8px'}"size="small">8</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#ccc',marginRight:'8px'}"size="small">9</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>
                                    <li>
                                        <Row>
                                            <Col span="14">
                                                <Avatar :style="{background: '#ccc',marginRight:'8px'}"size="small">10</Avatar>东直门 1 号
                                            </Col>
                                            <Col span="10" style="text-align: right;">123,456 </Col>
                                        </Row>
                                    </li>

                                </ul>

                            </Col>
                        </Row>

                    </Card>
                </Col>
            </Row>
        </div>
        <!--后台信息结束-->

    </div>
</template>
<script>
    import 'v-charts/lib/style.css'
    export default {
        data() {
            this.chartSettings = {
                metrics: ['昨天访问数', '今日访问数'],
                xAxisType: 'time',
            }
            this.extend = {
                color: ["#dcdee2", "#2d8cf0"],
                xAxis: {
                    show:true,
                    splitLine: {
                        show: false //坐标轴在 grid 区域中的分隔线,竖的切割线
                    },
                },
                grid: {
                    height:'75%',
                    width:'92%',
                    bottom:'5%',
                    top:'15%',
                    // left: '3%',
                    // right: '2%', ///   调整大小
                    //bottom: '3%',
                    // show:true, //  边框是否显示
                    containLabel: true
                },
                yAxis: {
                    // type: "value",
                    // name:'访问量趋势',
                    // nameTextStyle:{
                    //     fontWeight:'bold',
                    //     align:'right'
                    // }
                }
            }
            return {
                chartData: {
                    columns: ['日期', '昨天访问数', '今日访问数', '下单率'],
                    rows: [
                        {'日期': '2018-01-01', '昨天访问数': 1393, '今日访问数': 1093, '下单率': 1093},
                        {'日期': '2018-01-02', '昨天访问数': 3530, '今日访问数': 3230, '下单率': 3230},
                        {'日期': '2018-01-03', '昨天访问数': 2923, '今日访问数': 2623, '下单率': 0.76},
                        {'日期': '2018-01-05', '昨天访问数': 1723, '今日访问数': 1423, '下单率': 2623},
                        {'日期': '2018-01-10', '昨天访问数': 3792, '今日访问数': 3492, '下单率': 0.323},
                        {'日期': '2018-01-20', '昨天访问数': 4593, '今日访问数': 4293, '下单率': 0.78}
                    ]
                },
            }
        },
        mounted:function(){
            let that = this;
        },
        methods: {

        }
    }
</script>
<style src="../../../assets/style/adminData.css" scoped></style>
