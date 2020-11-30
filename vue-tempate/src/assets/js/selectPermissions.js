import Vue from 'vue'
import $ from 'jquery'
Vue.directive('auth-select', {
    // 当被绑定的元素插入到 DOM 中时……
    inserted: (el, binding, vnode) => {
        const value = binding.value;
        const auths = JSON.parse(sessionStorage.getItem('btnPermission'))  || '';
        const userInfo = JSON.parse(sessionStorage.getItem('userInfo'))  || '';
        //el.parentNode.removeChild(el);
        if (userInfo.roleId != '' && !auths.includes(value)) {
            el.style.pointerEvents = "none";
            // el.style.background = "#c5c8ce";
            el.style.color = "#c5c8ce";
            el.style.cursor = "not-allowed";

        }
    }
});

