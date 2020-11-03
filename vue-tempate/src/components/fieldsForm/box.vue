<template>
    <div>
        <Form ref="formValidate" :label-width="250"  :model="formInline" :rules="ruleInline" >
            <FormItem label="选项列表" prop="list"style="width: 300px">
                <div slot="label">
                    <Row>
                        <Col span="24" class="label-required-name">选项列表</Col>
                        <Col span="24" class="label-info">如：苹果|1；多个请按enter换行输入</Col>
                    </Row>
                </div>
                <Input type="textarea" v-model="formInline.list" placeholder="" style="width: 319px" :rows="4"></Input>
            </FormItem>
            <FormItem label="选项类型" prop="type">
                <RadioGroup v-model="formInline.type">
                    <Radio label="1">单选按钮</Radio>
                    <Radio label="2">复选框</Radio>
                    <Radio label="3">下拉框</Radio>
                    <Radio label="4">多选列表框</Radio>
                </RadioGroup>
            </FormItem>
            <FormItem label="默认值" prop="default"style="width: 300px">
                <div slot="label">
                    <Row>
                        <Col span="24" class="label-name">默认值</Col>
                        <Col span="24" class="label-info">如果选项类型是单选按钮、下拉框，只有一个默认值;请输入选项值；如果是复选框、多选列表框，有多个默认值，请在每个默认值之间用,号隔开；</Col>
                    </Row>
                </div>
                <Input type="text" v-model="formInline.default" placeholder="" style="width: 319px"></Input>
            </FormItem>

        </Form>
    </div>
</template>


<script>
    export default {
        data () {
            return{
                sonData: '我是子组件的数据！',
                formInline: {
                    list:'选项名称1|选项值1',
                    type:'1',
                    default:'',
                },
                ruleInline: {
                    width: [{type: 'number', message: '编辑器长度必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                    height: [{type: 'number', message: '编辑器高度必须为数值', trigger: 'blur', transform(value) {
                            return Number(value);
                        }}],
                }
            }
        },
        methods: {
            sonMethod() {
                this.$emit('addField',this.formInline,this.ruleInline);
                console.log('我是子组件的方法！')
            },
            run(){
                console.log("111");
                // this.$emit('addField',this.formInline,this.ruleInline)
            },
            // run(){
            //     this.$emit('addField',this.formInline,this.ruleInline)
            // }
        },
    };
</script>


<style lang="scss">



</style>