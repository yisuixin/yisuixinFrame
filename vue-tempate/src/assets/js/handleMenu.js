const routes = [
    {
        path: '/',
        name: '/',
        component: () => import('../../components/Layout/Layout'),
        children:[
            {
                path: '/info',
                name: 'info',
                component: () => import('../../views/home/info/info.vue'),
                 meta: {
                    needLogin:true,
                    keepAlive: true,
                    title:'首页'
                },
            },
            {
                path: '/adminData',
                name: 'adminData',
                component: () => import('../../views/home/adminData/adminData.vue'),
                meta: {
                    needLogin:true,
                    keepAlive: true,
                    title:'数据统计'
                },
            },
            {
                path: '/basicInfo',
                name: 'basicInfo',
                component: () => import('../../views/account/basicInfo.vue'),
                meta: {
                    needLogin:true,
                    keepAlive: true,
                    title:'基本信息'
                },
            },
            {
                path: '/safeInfo',
                name: 'safeInfo',
                component: () => import('../../views/account/safeInfo.vue'),
                meta: {
                    needLogin:true,
                    keepAlive: true,
                    title:'安全信息'
                },
            },
            {
                path: '/403',
                name: '403',
                meta: {
                    needLogin:false,
                    keepAlive: false, // 需要缓存
                    title:'403'
                },
                component: () => import('../../views/403.vue'),
            },
            {
                path: '/404',
                name: '404',
                meta: {
                    needLogin:false,
                    keepAlive: false, // 需要缓存
                    title:'404'
                },
                component: () => import('../../views/404.vue'),
            },
            {
                path: '/500',
                name: '500',
                meta: {
                    needLogin:false,
                    keepAlive: false, // 需要缓存
                    title:'500'
                },
                component: () => import('../../views/500.vue'),
            }
        ]
    },
]
export default {
    /**
     * 合并主菜单和子菜单
     * @param: rootList [Array] 主菜单列表
     * @param: subList [Array] 子菜单
     * */
    mergeSubInRoot (roots, subs) {
        if (roots && subs) {
            for (let i = 0; i < roots.length; i++) {
                let rootCode = roots[i].code
                roots[i].children = []
                for (let j = 0; j < subs.length; j++) {
                    if (rootCode === subs[j].code.substring(0, 4)) {
                        roots[i].children.push(subs[j])
                    }
                }
            }
        }
        return roots
    },
    /**
     * 合并远程路由到本地路由
     * @param: subList [Array] 远程路由列表
     * @param: routes [Array] 本地路由列表
     * */
    mergeRoutes (subs) {
        if (subs) {
            for (let i = 0; i < subs.length; i++) {
                let temp = {
                    path: subs[i].path,
                    name: subs[i].name,
                    component: () => import(`@/views/${subs[i].component}`),
                    meta: {
                        keepAlive: subs[i]['meta'].keepAlive,
                        needLogin: subs[i]['meta'].needLogin,
                        title: subs[i]['meta'].title,
                        // permissionList: subs[i].permissionList
                    }
                }
                routes[0].children.push(temp);
            }
        }
        routes[0].children.push({
         path: '*', redirect: '/404'
        })
        console.log('111',routes)
        return routes
    }
}