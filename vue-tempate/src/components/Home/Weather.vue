<template>
  <Card :bordered="false" style="height: 315px;">
    <p slot="title" class="card-title-slot">
      <Icon type="ios-locate-outline"  size="18" color="#2d8cf0"></Icon> 当地信息
    </p>
    <div class="web-info-box">
      <div id="weather-v2-plugin-standard"></div>
      <div style="font-size: 16px;margin-bottom: 12px;margin-top: 30px;text-align: center">
        {{userInfo.username}}，{{localTime.title}}
      </div>
    </div>
  </Card>
</template>


<script>
  export default {
    data () {
      return {
        localTime:{
          title:''
        }
      }
    },
    computed: {
      userInfo() {
        let userInfo = sessionStorage.getItem('userInfo');
        return  JSON.parse(userInfo);
      },
    },
    mounted:function(){
      let that = this;
      window.WIDGET = {
        CONFIG: {
          "layout": 1,
          "width": "381",
          "height": "150",
          "background": 2,
          "dataColor": "4A4A4A",
          "borderRadius": 5,
          "key": "jqtHcYRYLr"
        }
      }
      var script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = 'https://apip.weatherdt.com/standard/static/js/weather-standard-common.js?v=2.0';
      document.getElementsByTagName('head')[0].appendChild(script);
      //获取当前时间
      this.getLocalTime();
    },
    methods: {
      getLocalTime(){
        // 获取当前时间
        let timeNow = new Date();
        // 获取当前小时
        let hours = timeNow.getHours();
        // 设置默认文字
        let text = ``;
        // 判断当前时间段
        if (hours >= 0 && hours <= 10) {
          text = `早上好，开始您一天的工作吧!`;
        } else if (hours > 10 && hours <= 14) {
          text = `中午好，午休一下，下午会更有精神哦!`;
        } else if (hours > 14 && hours <= 18) {
          text = `下午好，活动一下，才会有动力工作哦!`;
        } else if (hours > 18 && hours <= 24) {
          text = `晚上好，还要加班了吗？要注意休息哦!`;
        }
        // console.log(`hours >>>>>`, hours);
        // console.log(`text >>>>`, text);
        this.localTime.title = text;
      }
    }
  }
</script>