<template>
    <div>
        <Card :bordered="false" dis-hover  style="margin-bottom: 90px">
            <Tabs @on-click="changeTabs">
                <!--站点配置开始-->
                <TabPane label="前台配置" name="frontend">
                    <Frontend ref="frontend"></Frontend>
                </TabPane>
                <!--站点配置结束-->
                <!--附件配置开始-->
                <TabPane name="" label="后台配置" name="backend">
                    <Backend ref="backend"></Backend>
                </TabPane>
                <!--附件配置结束-->
            </Tabs>
        </Card>
        <div class="addBtn">
            <div>
                <Button type="primary" @click="editConfig">修改配置</Button>
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
                activeTabs:0
            }
        },
        mounted:function(){
            let that = this;
        },
        methods: {
            //切换选项卡
            changeTabs(name){
                this.activeTabs = name;
            },
            editConfig(){
                let that = this;
                if(this.activeTabs == 0){//前台配置
                    that.$refs['frontend'].$refs['frontedForm'].validate((valid) => {
                        if (valid) {
                            that.$Message.success('Success!');
                        }
                    })
                }else if(this.activeTabs == 1){//后台配置
                    that.$refs['backend'].$refs['backendForm'].validate((valid) => {
                        if (valid) {
                            that.$Message.success('Success!');
                        }
                    })
                }

            },

        }
    }
</script>


