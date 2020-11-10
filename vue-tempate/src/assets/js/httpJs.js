import axios from 'axios';
import Vue from 'vue'
import Qs from 'qs'
import router from '../../router'
import { Message } from 'view-design';
Vue.component('Message', Message);


axios.defaults.timeout = 20000;
axios.defaults.baseURL ='mork'; //填写域名


//http request 拦截器
axios.interceptors.request.use(
    config => {
        config.data = Qs.stringify(config.data);
        config.headers = {
            'Content-Type':'application/x-www-form-urlencoded'
        }
        if (sessionStorage.getItem('token')) {
            config.headers.Authorization = 'Bearer ' + sessionStorage.getItem('token')
        }
        return config;
    },
    error => {
        return Promise.reject(err);
    }
);

//响应拦截器即异常处理
axios.interceptors.response.use(response => {
    return response
}, err => {
    if (err && err.response) {
        switch (err.response.status) {
            case 400:
                console.log('请求失败，错误请求')
                break;
            case 401:
                Message.error({
                    content:'登录信息已过期,请重新登录',
                    onClose:function () {
                        router.push({
                            path:'/login',
                            query:{redirect:location.hostname}
                        })
                    }
                })

                break;
            case 403:
                router.push({
                    path:'/403',
                })
                //Message.error('请求失败，没有访问权限')
                break;
            case 404:
                // router.push({
                //     path:'/404',
                // })
                Message.error('请求失败，资源丢失')
                break;
            case 405:
                console.log('请求失败，请求方法未允许')
                break;
            case 408:
                Message.error('请求失败，请求超时')
                break;
            case 500:
                // router.push({
                //     path:'/500',
                // })
                Message.error('请求失败，服务器错误')
                break;
            case 501:
                Message.error('请求失败，网络断开')
                break;
            case 502:
                Message.error('请求失败，网络错误')
                break;
            case 503:
                Message.error('请求失败，服务不可用')
                break;
            case 504:
                Message.error('请求失败，网络超时')
                break;
            case 505:
                console.log('http版本不支持该请求')
                break;
            default:
                Message.error(`连接错误${err.response.status}`)
        }
    } else {
        Message.error('连接到服务器失败')
    }
    return Promise.resolve(err.response)
})

function get(url,data,successCallback,failCallback,otherCallback) {
    axios.get(url,{params:data}) .then(function (response) {
        if(response.data.code == 200){
            if(response.data.data.status == 1){
                successCallback(response.data);
            }else{
                failCallback(response.data);
            }
        }else{
            if(otherCallback){
                otherCallback();
            }
        }
    })
    .catch(function (error) {
        if(failCallback){
            failCallback();
        }
    });
}

function post(url,data,successCallback,failCallback,otherCallback) {
    axios.post(url,data) .then(function (response) {
            if(response.data.code == 200){
                if(response.data.data.status == 1){
                    successCallback(response.data);
                }else{
                    failCallback(response.data);
                }
            }else{
                if(otherCallback){
                    otherCallback();
                }
            }
        }).catch(function (error) {
                if(failCallback){
                    failCallback();
                }
        });
}
export default{
    get:get,
    post:post
};


