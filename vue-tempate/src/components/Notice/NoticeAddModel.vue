<style>
  .notice-list-box li{
    padding:6px 6px;
    cursor: pointer;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
  }
  .notice-list-box li:hover{
    color:#0d58ab;
  }
  .rowClassName{
    cursor: pointer;
  }
</style>
<template>
  <div>
    <!--整站权限设置对话框开始-->
    <Modal v-model="noticeAddModel.show"
           width="950px"
           title='发布通知公告'

           :mask-closable="false"
           :loading="noticeAddModel.loading"
           fullscreen
           @on-ok="submitNotice"
           ok-text="发布"
          >
<!--      <Spin size="large" fix v-if="noticeAddModel.loading"></Spin>-->
      <div slot>
          <Form ref="formValidate" :model="noticeAddModel.formInline" :rules="noticeAddModel.ruleValidate" :label-width="120">
            <FormItem label="公告标题" prop="title">
              <Input type="text" v-model="noticeAddModel.formInline.title" maxlength="30" show-word-limit placeholder="最多30个字符"></Input>
            </FormItem>
            <FormItem label="内容摘要" prop="desc">
              <Input type="textarea" v-model="noticeAddModel.formInline.desc" maxlength="200" show-word-limit placeholder="最多200个字符"></Input>
            </FormItem>
            <FormItem label="公告内容" prop="content">
                <editor-bar ref="EditorBar" :value="noticeAddModel.formInline.content" :isClear="false" @change="setContent"></editor-bar>

            </FormItem>
            <FormItem label="公告可见人群" prop="type">
              <RadioGroup v-model="noticeAddModel.formInline.type" @on-change="selectNoticeType">
                <Radio label="1">全部用户可见</Radio>
                <Radio label="2">指定角色可见</Radio>
                <Radio label="3">指定用户可见</Radio>
              </RadioGroup>
            </FormItem>
            <FormItem label="选择指定角色" prop="userId" v-if="noticeAddModel.formInline.type == 2">
                <Select v-model="noticeAddModel.formInline.userId" multiple transfer style="width:400px">
                    <Option :label= "item.name" :value="item.id" v-for="(item,index) in roleList.list" :key="index">{{item.name}}</Option>
                    <Page :current="roleList.search.page"
                          :page-size="roleList.search.pageSize"
                          :total="roleList.count"
                          simple
                          @on-change="getRoleListPageChange"
                          style="text-align: center;" v-if="roleList.list.length > 0"/>
                </Select>
            </FormItem>
              <FormItem label="选择指定用户" prop="userId" v-if="noticeAddModel.formInline.type == 3">
                  <Select v-model="noticeAddModel.formInline.userId" multiple transfer style="width:400px">
                      <Option :label= "item.username" :value="item.id" v-for="(item,index) in userList.list" :key="index">{{item.username}}</Option>
                      <Page :current="1"
                            :total="userList.count"
                            simple
                            style="text-align: center;"
                            @on-change="getUserListPageChange"
                            v-if="userList.list.length > 0"/>
                  </Select>
              </FormItem>
            <FormItem label="是否置顶" prop="topping">
              <RadioGroup v-model="noticeAddModel.formInline.topping">
                <Radio label="1">是</Radio>
                <Radio label="2">否</Radio>
              </RadioGroup>
            </FormItem>
          </Form>
      </div>
        <div slot="footer">
<!--            <Button  @click="showModel(2)">取消</Button>-->
            <Button type="primary" :loading = 'noticeAddModel.loading'@click="submitNotice('formValidate')">发布</Button>
        </div>
    </Modal>
  </div>
</template>
<script>
    import EditorBar from '../../components/Editor/WangEnduit'
  export default {
      components: { EditorBar },
    data () {
      return {
          roleList: {
              search:{
                  page:1,
                  pageSize:this.COMMONJS.pageSize,
              },
              count:0,
              list:[]
          },
          userList: {
              search:{
                  page:1,
                  pageSize:this.COMMONJS.pageSize,
              },
              count:0,
              list:[]
          },
          noticeAddModel:{
              show:false,
              loading:false,
              title:'发布通知公告',
              formInline: {
                is_add:1,//1为新增，2为编辑
                id:'',
                title: '',
                desc: '',
                content: '',
                userId:[],
                type: '1',
                topping: '2'
              },
          ruleValidate: {
            title: [
              { required: true, message: '请输入公告标题', trigger: 'blur' },
              { type: 'string', max: 30, message: '公告标题最多30个字符', trigger: 'blur' }
            ],
            desc: [
              { type: 'string', max: 200, message: '公告描述最多200个字符', trigger: 'blur' }
            ],
            date: [
              { required: true, message: '请选择事项完成时间', trigger: 'blur' }
            ],
            content: [
              { required: true, message: '请输入公告内容', trigger: 'blur' }
            ],
            userId: [
                { type: 'array', required: true,min:1, message: '请选择可见人群' }
              ],

          }
        },
      }
    },
    mounted:function(){

    },
    methods: {
        //将编辑器的值赋值到content
        setContent(val) {//val编辑器的值，isDesc是否将编辑器中的200个字符设置为描述
          this.noticeAddModel.formInline.content = val.html;
        },
      //显示发布通知对话框
      showModel:function(type){//type == 1显示，2关闭
        if(type == 1){
          this.noticeAddModel.show = true;
        }else{
          this.noticeAddModel.show = false;
          this.noticeAddModel.loading = false;
        }
      },
        //选择可见人群
        selectNoticeType(value){
            this.noticeAddModel.formInline.userId = [];
            if(value == 2){
                this.getRoleList();
            }else if(value == 3){
                this.getUserList();
            }
        },
        //获取角色列表页码改变
        getRoleListPageChange(page){
            this.roleList.search.page = page;
            this.getRoleList();
        },
        //获取角色列表
        getRoleList(){
            const that = this;
            let successCallback = function(res){
                that.roleList.count = res.data.data.count;
                that.roleList.list = res.data.data.list;
            }
            let failCallback = function(res){
                that.roleList.loading = false;
            }
            that.HTTPJS.get(that.HTTPURL.ROLE.GET_ROLE_LIST,that.roleList.search,successCallback,failCallback);
        },
        //获取角色列表页码改变
        getUserListPageChange(page){
            this.userList.search.page = page;
            this.getUserList();
        },
        //获取用户列表
        getUserList(){
            const that = this;
            let successCallback = function(res){
                that.userList.count = res.data.data.count;
                that.userList.list = res.data.data.list;
            }
            let failCallback = function(res){
                that.userList.loading = false;
            }
            that.HTTPJS.get(that.HTTPURL.MANAGER.GET_USER_LIST,that.userList.search,successCallback,failCallback);
        },
        //点击发布公告
        submitNotice(){
          const that = this;
          // console.log(this.noticeAddModel.formInline)
          that.noticeAddModel.loading = true;
          that.getEditorText();
          let type = that.noticeAddModel.formInline.is_add;
          let info = type == 1?'添加':'编辑';
          that.$refs['formValidate'].validate((valid) => {
              if (valid) {
                  let successCallback = function(res){
                      that.$Message.info({
                          content:info+'成功',
                          onClose:function () {
                              that.noticeAddModel.show = false;
                              that.noticeAddModel.loading = false;
                              that.$emit('getNoticeList');
                          }
                      })
                  }
                  let failCallback = function(res){
                      that.$Message.error({
                          content:res.data.message,
                          onClose:function () {
                              that.noticeAddModel.loading = false;
                          }
                      })
                  }
                  that.HTTPJS.post(that.HTTPURL.COMMON.NOTICE.ADD_NOTICE,that.noticeAddModel.formInline,successCallback,failCallback);
              } else {
                  this.noticeAddModel.loading = false;
              }
          })
      },
        //获取编辑的值，如果“是否截取内容200字符至内容摘要”选中的话，截取字符到desc
        getEditorText(){
            let value = this.$refs.EditorBar.getEditorText();
            if(value.isDesc && this.noticeAddModel.formInline.desc == ''){//如果描述为空并且isDesc为真的话才执行
                this.noticeAddModel.formInline.desc = this.$options.filters.reBytesStr(value.text,200)
            }
      },

    }
  }
</script>


