import Vue from 'vue'

Vue.directive('auth', {
    // 当被绑定的元素插入到 DOM 中时……
    inserted: (el, binding, vnode) => {
        const value = binding.value;
        const auths = JSON.parse(sessionStorage.getItem('btnPermission'))  || '';
        const userInfo = JSON.parse(sessionStorage.getItem('userInfo'))  || '';
        if (userInfo.role != '' && !auths.includes(value)) {
            el.parentNode.removeChild(el);
        }
    }
});