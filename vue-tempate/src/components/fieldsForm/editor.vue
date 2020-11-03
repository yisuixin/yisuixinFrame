<template>
    <div>
        <Form ref="formValidate" :label-width="120"  :model="formInline" :rules="ruleInline" >
            <FormItem label="编辑器长度" prop="width"style="width: 300px">
                <Input type="text" v-model="formInline.width" placeholder="" style="width: 319px"></Input>
            </FormItem>
            <FormItem label="编辑器高度" prop="height"style="width: 300px">
                <Input type="text" v-model="formInline.height" placeholder="" style="width: 319px"></Input>
            </FormItem>
            <FormItem label="默认值" prop="default"style="width: 300px">
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
                    width:'',
                    height:'',
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