<template>
    <div>
        <Card :bordered="false" dis-hover  style="margin-bottom: 90px">
            <Tabs @on-click="changeTabs">
                <!--站点配置开始-->
                <TabPane label="前台配置" :disabled="disabledTabs">
                    <Frontend ref="frontend" @fun="setSubmitStatus"></Frontend>
                </TabPane>
                <!--站点配置结束-->
                <!--附件配置开始-->
<!--                <TabPane label="后台配置" :disabled="disabledTabs">-->
<!--                    <Backend ref="backend" @fun="setSubmitStatus"></Backend>-->
<!--                </TabPane>-->
                <!--附件配置结束-->
            </Tabs>
        </Card>
        <div class="addBtn">
            <div>
                <Button type="primary" :loading="submitBtnLoading" @click="submitValidate">{{submitBtnText}}</Button>
            </div>
        </div>
    </div>
</template>
<script>
    import Backend from '../../../components/WebConfig/Backend'
    import Frontend from '../../../components/WebConfig/Frontend'
    export default {
        components: {Backend,Frontend},
        data () {
            return {
                disabledTabs:false,
                activeTabs:0,
                submitBtnLoading:false,
                submitBtnText:'修改配置',
            }
        },
        mounted:function(){
            let that = this;
            this.$refs['frontend'].getConfig();
        },
        methods: {
            changeTabs(name){//切换选项卡
                let that = this;
                that.activeTabs = name;
                if(that.activeTabs == 0){//获取前台配置
                   // this.$refs['frontend'].getConfig();
                }else if(that.activeTabs == 1){//获取后台配置
                   // this.$refs['backend'].getConfig();
                 }
            },
            //点击编辑验证
            submitValidate(){
                let that = this;
                if(this.activeTabs == 0){//前台配置
                    that.$refs['frontend'].$refs['frontedForm'].validate((valid) => {
                        if (valid) {
                            this.$refs['frontend'].submit();
                        }
                    })
                }else if(this.activeTabs == 1){//后台配置
                    that.$refs['backend'].$refs['backendForm'].validate((valid) => {
                        if (valid) {
                            this.$refs['backend'].submit();
                        }
                    })
                }
            },
            //设置按钮状态
            setSubmitStatus(submitBtnText,submitBtnLoading,disabledTabs){
                this.submitBtnLoading = submitBtnLoading;
                this.submitBtnText    = submitBtnText;
                this.disabledTabs = disabledTabs;
            }
        }
    }
</script>


