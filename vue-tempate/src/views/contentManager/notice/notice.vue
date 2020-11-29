<style scoped>
    .notice-list{
        height: 300px;
        width: auto;
        margin-bottom: 10px;
        cursor: pointer;

    }
    .notice-list .title{
        margin-top: 20px;
        font-size: 16px;
        color: #464c5b;
        font-weight: bold;
    }
    .notice-list .desc{
        height: 100px;
        line-height: 25px;
        color: #515a6e;
        margin-top: 10px;
        text-indent: 20px;
        font-size: 14px;
    }
    .notice-list .time{
        color: #808695;
        font-size: 14px;
    }
    .notice-list .option{
        height: 30px;
        line-height: 30px;
        padding-left: 20px;
    }
    .notice-list .option li{
        float: left;
        font-size: 14px;
        color: #808695;
        padding-right: 10px;
    }
    .notice-list .option li:hover{
        color: #2d8cf0;
    }
    .topping-box{
        width: 100px;
        height: 100px;
        position: absolute;
        top: 0;
        right: 0;
        overflow: hidden;
    }
    .topping-box .topping{
        width:100px;
        height:100px;
        position: absolute;
        background: #2db7f5;
        top:-50px;
        right:-50px;
        transform: rotate(45deg);
    }
    .topping-box .topping span{
        position: absolute;
        bottom: 8px;
        display: block;
        width:100px;
        text-align: center;
        color: #fff;
    }
</style>
<template>
    <div>
        <Card :bordered="false" dis-hover style="margin-bottom: 10px;">
            <div class="category-btn-list">
                <Form ref="search" :model="notice.search" :label-width="100">
                    <Row>
                        <Col span="6">
                            <FormItem label="关键字："prop="searchKey">
                                <Input type="text" v-model="notice.search.searchKey" placeholder="请输入标题"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="发布者："prop="author">
                                <Input type="text" v-model="notice.search.author" placeholder="请输入作者"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="发布时间：" prop="time" >
                                <DatePicker type="daterange" placeholder="请选择发布时间" v-model="notice.search.time":editable="false"></DatePicker>
                            </FormItem>
                        </Col>
                        <Col span="6">

                        </Col>
                    </Row>
                    <Row>
                        <Col span="6">
                            <FormItem label="是否置顶：" prop="topping" >
                                <Select v-model="notice.search.topping" >
                                    <Option value="" >全部</Option>
                                    <Option value="1" >是</Option>
                                    <Option value="2" >否</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="8">
                            <FormItem>
                                <Button type="primary" @click="searchSubmit('search')" class="list-btn">搜索</Button>
                                <Button type="default" @click="resetSearch('search')" class="list-btn">重置</Button>
                            </FormItem>
                        </Col>
                    </Row>
                </Form>
            </div>
        </Card>
        <Card :bordered="false" dis-hover  class="main-list-box" style="background: #f5f7f9;margin-bottom: 50px;">
            <Alert show-icon closable>通知公告一经发布，不能再进行编辑；如果需要编辑，请删除之后再重新发布即可</Alert>
            <Spin size="large" fix v-if="notice.loading"></Spin>
            <Row :gutter="15">
                <Col span="6"  v-auth="`add_notice`">
                    <Card :bordered="false"  class="notice-list">
                        <div style="height: 250px;width: auto;" >
                            <Button type="dashed"
                                    icon="md-add"
                                    long
                                    class="add-content-btn"
                                    title="发布通知公告"
                                    style="height: 250px;"
                                    @click="showAddNoticeModel(1)">发布通知公告</Button>
                        </div>
                    </Card>
                </Col>
                <Col span="6" v-for="(item,index) in notice.list" :key="index">
                    <Card :bordered="false" class="notice-list">
                        <div class="topping-box" v-if="item.topping == 1">
                            <div class="topping">
                                <span>置顶</span>
                            </div>
                        </div>
                        <div >
                            <div class="user"><Avatar :src="item.avatar" size="35"/>&nbsp;&nbsp;{{item.username}}</div>
                            <div class="title"  @click="showNoticeInfoModel(1,item.id)">{{item.title | reBytesStr(40)}}</div>
                            <div class="desc"  @click="showNoticeInfoModel(1,item.id)">{{item.desc | reBytesStr(180)}}</div>
                            <div>
                                <Divider orientation="right" class="time">{{item.created_at | formatTime10}}</Divider>
                            </div>
                            <div class="option">
                                <li title="可查看用户列表">
                                    <Icon type="ios-people" size="18"/>
                                    <span v-if="item.type == 1"> 所有用户可见</span>
                                    <span v-else-if="item.type == 2"> 指定角色可见</span>
                                    <span v-else> 指定用户可见</span>
                                    <Divider type="vertical" />
                                </li>
<!--                                <li title="修改" class="contentMangeBtn"@click="showAddNoticeModel(1,2,item.id)">-->
<!--                                    <Icon type="ios-brush"  size="17"/> 修改-->
<!--                                    <Divider type="vertical" />-->
<!--                                </li>-->
                                <li title="置顶" class="contentMangeBtn">
                                    <span v-if="item.topping == 1">
                                        <Poptip
                                                transfer
                                                confirm
                                                title="确认取消置顶?"
                                                @on-ok="toppingNotice(index,2)">
                                                 <Icon type="md-arrow-round-down" size="18" /> 取消置顶
                                        </Poptip>
                                    </span>
                                    <span v-else>
                                        <Poptip
                                                transfer
                                                confirm
                                                title="确认置顶?"
                                                @on-ok="toppingNotice(index,1)">
                                                 <Icon type="md-arrow-round-up" size="18"/> 置顶
                                        </Poptip>
                                    </span>
                                    <Divider type="vertical" />
                                </li>
                                <li title="删除" class="contentMangeBtn">
                                    <Poptip
                                            transfer
                                            confirm
                                            title="确认删除此通知公告?"
                                            @on-ok="delNotice(item.id)">
                                            <Icon type="ios-trash" size="18"/> 删除
                                    </Poptip>
                                </li>
                            </div>
                        </div>
                    </Card>
                </Col>
            </Row>
            <div class="page-box-fix">
                <Page :total="notice.count"
                      :transfer="true"
                      show-elevator
                      show-total
                      :page-size ="notice.search.pageSize"
                      @on-change="noticePageChange"
                      @on-page-size-change = "noticePageSizeChange"/>
            </div>
        </Card>
        <NoticeAddModel ref="noticeAddModel" @getNoticeList="getNoticeList"></NoticeAddModel>
        <NoticeInfoModel ref="NoticeInfoModel"></NoticeInfoModel>
    </div>
</template>
<script>
    import NoticeAddModel from '../../../components/Notice/NoticeAddModel'
    import NoticeInfoModel from "../../../components/Home/NoticeInfoModel";
    export default {
        components: {NoticeAddModel,NoticeInfoModel},
        data () {
            return {
                notice:{
                    loading:false,
                    search: {
                        searchKey: '',
                        author: '',
                        time: '',
                        topping:'',
                        page:1,
                        pageSize:11
                    },
                    count:0,
                    list: []
                },
            }
        },
        activated:function(){
            this.getNoticeList();
        },
        methods: {
            //分页
            noticePageChange(page){
                this.notice.loading = true;
                this.notice.search.page = page;
                this.getNoticeList();
            },
            //切换条数
            noticePageSizeChange(pageSize){
                this.notice.loading = true;
                this.notice.search.pageSize = pageSize;
                this.getNoticeList();
            },
            //获取通知列表
            getNoticeList:function () {
                const that =this;
                that.notice.loading = true;
                let successCallback = function(res){
                    that.notice.loading = false;
                    that.notice.list = res.data.data.list;
                    that.notice.count = res.data.data.count;
                }
                let failCallback = function(res){
                    that.notice.loading = false;
                    that.notice.list = [];
                }
                let otherCallback = function(res){
                    that.notice.loading = false;
                    that.notice.list = [];
                }
                that.HTTPJS.get(that.HTTPURL.CONTENT.NOTICE.GET_ADMIN_NOTICE_LIST,that.notice.search,successCallback,failCallback,otherCallback);
            },
            //点击搜索
            searchSubmit(){
                const that = this;
                that.notice.search.page     = 1;
                that.notice.search.pageSize = 9;
                that.getNoticeList();
            },
            //重置搜索
            resetSearch(){
                this.$refs['search'].resetFields();
                this.getNoticeList();
            },
            showAddNoticeModel:function(type){//type == 1显示，2关闭
                if(type == 1){
                    this.$refs.noticeAddModel.showModel(1);
                }else{
                    this.$refs.noticeAddModel.showModel(2);
                }
            },
            //删除通知公告
            delNotice:function (id) {
                const that =this;
                let successCallback = function(res){
                    that.$Message.info({
                        content: '删除成功',
                        onClose:function () {
                            that.getNoticeList();
                        }
                    });
                }
                that.HTTPJS.post(that.HTTPURL.CONTENT.NOTICE.DEL_NOTICE,{id:id},successCallback);
            },
            //置顶或者取消置顶
            toppingNotice(key,type){
                const that = this;
                const info = type == 1 ? '置顶' :'取消置顶';
                const id = that.notice.list[key].id;
                console.log()
                let successCallback = function(res){
                    that.$Message.info({
                        content: info+'成功',
                        onClose:function () {
                            that.notice.list[key].topping = type;
                        }
                    });
                }
                that.HTTPJS.post(that.HTTPURL.CONTENT.NOTICE.TOPPING_NOTICE,{id:id,type:type},successCallback);
            },
            showNoticeInfoModel:function(type,id){//type == 1显示，2关闭
                this.$refs.NoticeInfoModel.showModel(type,id,'admin');
            },
        }
    }
</script>
