import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import ViewUI, {Message} from 'view-design';
Vue.use(ViewUI);


let router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/login',
      name: 'login',
      meta: {
        needLogin:false,
        keepAlive: false, // 需要缓存
        title:'登录'
      },
      component: () => import('../views/login/Login.vue'),
    }]
})

// 拦截登录，token验证
router.beforeEach((to, from, next) => {
    ViewUI.LoadingBar.start();//加载进度条
    if (to.meta.needLogin === undefined) {
      if (sessionStorage.getItem("token")) {//表示已经登录
          next()
      } else {
          ViewUI.Message.error({
            content:'您还未登录！请先登录',
            onClose:function () {next({
              path: '/login'
            }) }
          })

      }
    } else {
      next()
    }
    if (to.meta.title) {//设置网页标题
      document.title = to.meta.title
    }
})


//销毁加载进度条
router.afterEach(route => {
  ViewUI.LoadingBar.finish();
});

//解决当前路由重复显示的报错
const originalPush = Router.prototype.push
Router.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err)
}
export default router