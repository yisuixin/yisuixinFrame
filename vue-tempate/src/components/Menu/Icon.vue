<template>
<!--    <Button type="primary" @click="modal1 = true">Display dialog box</Button>-->
    <Modal
            :width="800"
            :footer-hide="true"
            v-model="modal1"
            title="选择图标">
        <div class="model-box">
            <Spin size="large" fix v-if="spinShow"></Spin>
            <Row v-else>
                <Col span="6" v-for="(item,index) in iconList" :key="index">
                    <div class="item">
                        <div style="display: table-cell;vertical-align: middle;" @click="selectIcon(item)">
                            <div :title="item"><Icon :type="item" :size="30"/></div>
                            <div :title="item">{{item}}</div>
                        </div>

                    </div>
                </Col>
            </Row>
        </div>
    </Modal>
</template>
<style scoped>
    .model-box{
        max-height:500px;
        overflow-y:auto;
        overflow-x:hidden;
        text-align: center;
    }
    .model-box .item{
        width: 150px;
        height: 100px;
        /*line-height: 100px;*/
        padding:10px 10px;
        text-align: center;
        display: table;
    }
    .model-box .item:hover{
        cursor: pointer;
        background: #f8f8f9;
    }
</style>
<script>
    import iconList from '../../assets/js/icon.json'
    export default {
        data () {
            return {
                spinShow:true,
                modal1: false,
                iconList:[],
            }
        },
        methods: {
            selectIcon(icon){
                this.$emit('getIcon',icon)
            },
            //父组件传值过来显示选择列表
            showMoel(flag) {  //这个就是子组件的函数 参数是父组件调用时传过来的
                this.modal1 = flag;   //将这个状态赋给当前的对话框所绑定data数据上
                if(flag){
                    this.getIconJson();
                }
            },
            getIconJson () {
                let that =this;
                that.iconList = iconList;
                that.spinShow = false;
            }
        }
    }
</script>
