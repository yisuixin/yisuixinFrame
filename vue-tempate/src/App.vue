<template>
        <keep-alive>
            <router-view/>
        </keep-alive>
</template>
<script>
    import handleMenu from "./assets/js/handleMenu.js";
    export default {
        name: 'app',
        created () {
            // 当this.$router.options.routes的长度为1，且本地缓存存在菜单列表的时候才重新配置路由
            if (this.$router.options.routes.length <= 1 && sessionStorage.getItem('routeList')) {
                let subList = JSON.parse(sessionStorage.getItem('routeList'))
                let routes = handleMenu.mergeRoutes(subList);
                this.$router.addRoutes(routes)
                // this.$router不是响应式的，所以手动将路由元注入路由对象
                this.$router.options.routes.push(routes);

            }
        },
        mounted() {
         },
        methods:{

        }
    }
</script>