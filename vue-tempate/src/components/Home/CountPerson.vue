<template>
  <Card :bordered="false" style="height: 315px;">
    <p slot="title" class="card-title-slot">
      <Icon type="ios-people-outline"  size="18" color="#2d8cf0"></Icon> 当前在线人数
    </p>
    <div class="web-info-box">
      <div class="count-person-box">
        <span class="count-person">{{countPerson.nowTime}}</span>
        <span class="count-person count-person-bumber">
            <countTo :endVal='countPerson.countPerson'></countTo>
        </span>
        <span class="count-person number-data-name"><p>在线访客数</p></span>
        <p class="count-person"  style="font-size: 12px;margin-top: 5px;">
        <div>
          <van-count-down ref="countDown" :time="countPerson.countDownTime" @finish="CountDownFinish">
            <template #default="timeData">
              <span class="block" style="font-size: 12px;"><Badge status="processing"/>{{ timeData.seconds }}秒后更新</span>
            </template>
          </van-count-down>
        </div>
        </p>
      </div>
    </div>
  </Card>
</template>


<script>
  import countTo from 'vue-count-to';
  export default {
    components: { countTo},
    data () {
      return {
        countPerson:{
          nowTime:this.dayjs().format('HH:mm:ss'),
          countDownTime: this.COMMONJS.CountDownTime,
          countPerson: Math.ceil(Math.random()*100),
        },
      }
    },
    mounted:function(){
      let that = this;
      this.CountDownStart();
    },
    methods: {
      CountDownStart() {
        this.$refs.countDown.start();
      },
      CountDownReset() {
        this.$refs.countDown.reset();
      },
      CountDownFinish(){
        this.CountDownReset();
        this.countPerson.nowTime =  this.dayjs().format('HH:mm:ss');//当前时间
        this.countPerson.countPerson = Math.ceil(Math.random()*10);//当前在线人数
      },
    }
  }



</script>

