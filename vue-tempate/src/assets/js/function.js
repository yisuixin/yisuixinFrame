/**
 * 获取url参数
 * @param variable
 * @returns {string|boolean}
 */
export const getQueryVariable = (queryName)=>{
         var query = decodeURI(window.location.search.substring(1));
         var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
                 var pair = vars[i].split("=");
                 if (pair[0] == queryName) { return pair[1]; }
             }
         return null;
}
export const getRouteList = (router)=>{
    let menus = sessionStorage.getItem('routeList');
    let allRouteList = [];
    //let t = router.options.routes[0].children=[];
    JSON.parse(menus).map((item, index, arr) => {
        allRouteList.push({
                path: item.path,
                name: item.name,
                //component: () => import(`@/views/${item.component}`),  component: () => import('../views/login/Login.vue'),
                component: () => import(`@/views/${item.component}`),
                meta: {
                    needLogin: true,
                    keepAlive: true, // 需要缓存
                    title:'首页'
                },
            },
        )
    })
    router.options.routes[0].children = allRouteList
    router.selfaddRoutes(router.options.routes);
    //router.addRoutes(router.options.routes);
}
export default {
    getQueryVariable,
    getRouteList
}