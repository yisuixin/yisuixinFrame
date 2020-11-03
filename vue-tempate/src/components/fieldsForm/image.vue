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
                  <Radio label="1">单图片模式</Radio>
                  <Radio label="2">多图片模式</Radio>
              </RadioGroup>
          </FormItem>
          <FormItem label="最大上传图片数" prop="max_img">
              <div slot="label">
                  <Row>
                      <Col span="24" class="label-name">最大上传图片数</Col>
                      <Col span="24" class="label-info">当上传模式为单图片时，最多上传1张；</Col>
                  </Row>
              </div>
              <Input type="text" v-model="formInline.max_img"  :disabled = "max_img_disabled" style="width: 319px"></Input>
          </FormItem>
          <FormItem label="是否添加水印" prop="watermark">
              <RadioGroup v-model="formInline.watermark">
                  <Radio label="1">是</Radio>
                  <Radio label="2">否</Radio>
              </RadioGroup>
          </FormItem>
          <FormItem label="自动裁减图像大小">
              <Row>
                  <Col span="2">
                      <FormItem prop="watermark_width">
                          <Input type="text" v-model="formInline.watermark_width" placeholder="宽(px)"></Input>
                      </FormItem>
                  </Col>
                  <Col span="1" style="text-align: center;">-</Col>
                  <Col span="2">
                      <FormItem prop="watermark_height">
                          <Input type="text" v-model="formInline.watermark_height" placeholder="高(px)"></Input>
                      </FormItem>
                  </Col>
              </Row>
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
                  accept:'gif|jpg|jpeg|png|bmp',
                  // default:'',
                  is_multiple:'1',
                  max_img:'1',
                  watermark:'2',
                  watermark_width:'',
                  watermark_height:'',
              },
              ruleInline: {
                  width: [{type: 'number', message: '文本框长度必须为数值', trigger: 'blur', transform(value) {
                              return Number(value);
                          }}],
                  max_img: [{type: 'number', message: '最大图片数必须为数值', trigger: 'blur', transform(value) {
                          return Number(value);
                      }}],
                  watermark_width: [{type: 'number', message: '裁剪图片宽度必须为数值', trigger: 'blur', transform(value) {
                          return Number(value);
                      }}],
                  watermark_height: [{type: 'number', message: '裁剪图片高度必须为数值', trigger: 'blur', transform(value) {
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