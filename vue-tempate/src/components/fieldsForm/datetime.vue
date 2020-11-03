<template>
  <div>
      <Form ref="formValidate" :label-width="250"  :model="formInline" :rules="ruleInline" >
          <FormItem label="日期模式" prop="date_type" >
              <RadioGroup v-model="formInline.date_type" @on-change="multiple">
                  <Radio label="1">单日期</Radio>
                  <Radio label="2">日期范围</Radio>
                  <Radio label="3">单时间</Radio>
                  <Radio label="4">日期时间</Radio>
                  <Radio label="5">日期时间范围</Radio>
              </RadioGroup>
          </FormItem>
          <FormItem label="默认值" prop="default">
              <RadioGroup v-model="formInline.default">
                  <Radio label="1">无</Radio>
                  <Radio label="2">当前时间</Radio>
              </RadioGroup>
          </FormItem>

      </Form>
  </div>
</template>


<script>
  export default {
      data () {
          return{
              sonData: '我是子组件的数据！',
              max_img_disabled:true,
              formInline: {
                  date_type:'1',
                  default:'1',
              },
              ruleInline: {
                  width: [{type: 'number', message: '文本框长度必须为数值', trigger: 'blur', transform(value) {
                              return Number(value);
                          }}],
                  max_img: [{type: 'number', message: '最大图片数必须为数值', trigger: 'blur', transform(value) {
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
        multiple(value){
            if(value == 1){//单图片模式，上传最大值为1
                this.formInline.max_img = 1;
                this.max_img_disabled = true;
            }else{
                this.max_img_disabled = false;
            }
        }
    },
  };
</script>


<style lang="scss">



</style>