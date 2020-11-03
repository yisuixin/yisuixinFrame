import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import router from './router'
import ViewUI from 'view-design'
import 'view-design/dist/styles/iview.css';
import commonJs from "./assets/js/common.js"; //公共操作显示文本配置文件
import "./assets/style/common.css"; //公共样式文件
Vue.prototype.COMMONJS=commonJs;//公共js文件挂载

import VCharts from 'v-charts'
Vue.use(VCharts)
Vue.config.productionTip = false
Vue.use(ViewUI);
Vue.use(Vuex);

import VeLine from 'v-charts/lib/line.common'
Vue.component(VeLine.name, VeLine)

import httpJs from "./assets/js/httpJs"; //
Vue.prototype.HTTPJS=httpJs;//
import httpUrl from "./assets/js/httpUrl"; //
Vue.prototype.HTTPURL=httpUrl;//

//vant框架
import Vant from 'vant';
import 'vant/lib/index.css';
Vue.use(Vant);

//时间处理插件
import dayjs from "dayjs"
import utc from "dayjs/plugin/utc"
dayjs.extend(utc)
Vue.prototype.dayjs = dayjs

//公共过滤js
import * as filters from './assets/js/filters'
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key])
})

// //vuex
// import store from './store'

//公共js函数
import functionJs from "./assets/js/function.js";
Vue.prototype.functionJs=functionJs;
//公共array  js函数
import arrayJs from "./assets/js/array.js";
Vue.prototype.arrayJs=arrayJs;

import VCalendar from 'v-calendar'; // 引入日历插件
Vue.use(VCalendar, {
  componentPrefix: 'vc',
});

new Vue({
  router,
  // store,
  render: h => h(App)
}).$mount('#app');
Vue.config.devtools = true;

