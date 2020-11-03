<template>
  <div>
      <Form ref="formValidate" :label-width="250"  :model="formInline" :rules="ruleInline" >
<!--              <FormItem label="默认值" prop="default"style="width: 300px">-->
<!--                  <Input type="text" v-model="formInline.default" placeholder="" style="width: 319px"></Input>-->
<!--              </FormItem>-->
          <FormItem label="允许上传的类型" prop="height"style="width: 300px">
              <div slot="label">
                  <Row>
                      <Col span="24" class="label-name">允许上传的类型</Col>
                      <Col span="24" class="label-info">多个类型用|隔开</Col>
                  </Row>
              </div>
              <Input type="text" v-model="formInline.accept" placeholder="" style="width: 319px"></Input>
          </FormItem>
          <FormItem label="上传模式" prop="is_multiple" >
              <RadioGroup v-model="formInline.is_multiple" @on-change="multiple">
                  <Radio label="1">单文件模式</Radio>
                  <Radio label="2">多文件模式</Radio>
              </RadioGroup>
          </FormItem>
          <FormItem label="最大上传文件数" prop="max_value">
              <div slot="label">
                  <Row>
                      <Col span="24" class="label-name">最大上传文件数</Col>
                      <Col span="24" class="label-info">当上传模式为单文件模式时，最多上传1份文件；</Col>
                  </Row>
              </div>
              <Input type="text" v-model="formInline.max_value"  :disabled = "max_value_disabled" style="width: 319px"></Input>
          </FormItem>


      </Form>
  </div>
</template>


<script>
  export default {
      data () {
          return{
              sonData: '我是子组件的数据！',
              max_value_disabled:true,
              formInline: {
                  accept:'doc|txt|xls',
                  is_multiple:'1',
                  max_value:'1',
              },
              ruleInline: {
                  width: [{type: 'number', message: '文本框长度必须为数值', trigger: 'blur', transform(value) {
                              return Number(value);
                          }}],
                  max_value: [{type: 'number', message: '最大上传数必须为数值', trigger: 'blur', transform(value) {
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
                this.formInline.max_value = 1;
                this.max_value_disabled = true;
            }else{
                this.max_value_disabled = false;
            }
        }
    },
  };
</script>


<style lang="scss">



</style>