<template>
  <Card :bordered="false" style="height: 315px;">
    <Spin size="large" fix v-if="loading"></Spin>
    <p slot="title" class="card-title-slot">
      <Icon type="ios-locate-outline"  size="18" color="#2d8cf0"></Icon> 当地信息
    </p>
    <p slot="extra" style="cursor: pointer;color: #808695;" title="刷新">
      <span @click="refresh()"><Icon type="ios-refresh" /></span>
    </p>
    <div class="web-info-box">
      <div id="weather-v2-plugin-standard"></div>
      <div style="font-size: 14px;margin-bottom: 12px;margin-top: 15px;text-align: center;">
        <!-- 调用加载随机语录的内容 如果需要GBK编码，修改 bm=utf 修改为 bm=gbk  -->
        <div>
          <span id="apiliebie"></span> —— <!-- 显示随机语录的【类别】 -->
          <span id="apineirong"></span><!-- 显示随机语录的【内容】 -->
        </div>
      </div>
    </div>
  </Card>
</template>

<script>
  export default {
    data () {
      return {
        loading:false,
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
      that.loading = true;
      that.getWeather();
      that.getRandQuotations();
      // that.getLocalTime();//获取当前时间
      that.loading = false;
    },
    methods: {
      refresh(){
        let that = this;
        that.loading = true;
        that.getWeather();
        that.getRandQuotations();
        // that.getLocalTime();//获取当前时间
        that.loading = false;
      },
      // getLocalTime(){
      //   // 获取当前时间
      //   let timeNow = new Date();
      //   // 获取当前小时
      //   let hours = timeNow.getHours();
      //   // 设置默认文字
      //   let text = ``;
      //   // 判断当前时间段
      //   if (hours >= 0 && hours <= 10) {
      //     text = `早上好，`;
      //   } else if (hours > 10 && hours <= 14) {
      //     text = `中午好，`;
      //   } else if (hours > 14 && hours <= 18) {
      //     text = `下午好，`;
      //   } else if (hours > 18 && hours <= 24) {
      //     text = `晚上好，!`;
      //   }
      //   // console.log(`hours >>>>>`, hours);
      //   // console.log(`text >>>>`, text);
      //   this.localTime.title = text;
      // },
      getWeather(){
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
      },//天气
      getRandQuotations(){//随机励志语录
        const s = document.createElement('script');
        s.id = 'apijs';
        s.type = 'text/javascript';
        s.src = 'http://www.kegood.com/jsapi/sjapi.js?lmapi=2&sjlm=99&bm=utf';
        document.getElementById('apiliebie').append(s);
      }
    }
  }
</script>