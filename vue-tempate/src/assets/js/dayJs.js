/**
 * 封装自定义 dayjs 日期处理模块
 */
import dayjs from 'dayjs'
import rTime from 'dayjs/plugin/relativeTime'
import 'dayjs/locale/zh-cn'

// 全局使用中文
dayjs.locale('zh-cn')

// dayjs 本身只处理日期格式化之类的核心功能
// 其它例如相对时间，需要单独配置它自己的插件才可以使用
dayjs.extend(rTime)

export const relativeTime = value => {
    return dayjs().to(dayjs(value))
}
//10位时间戳
export const formatTime10 = (value, format = 'YYYY-MM-DD hh:mm:ss') => {
    return dayjs.unix(value).format(format)
}
//13位时间戳
export const formatTime13 = (value, format = 'YYYY-MM-DD hh:mm:ss') => {
    return dayjs(value).format(format)
}
export const dateCompare = (date1,date2)=>{
    date1 = date1.replace(/\-/gi,"/");
    date2 = date2.replace(/\-/gi,"/");
    var time1 = new Date(date1).getTime();
    var time2 = new Date(date2).getTime();
    if(time1 > time2){
        return 1;
    }else if(time1 == time2){
        return 2;
    }else{
        return 3;
    }
}


dayjs.unix(1318781876)

export default {
    install (Vue) {
        Vue.filter('relativeTime', relativeTime)
        Vue.filter('formatTime', formatTime)
        Vue.filter('dateCompare', dateCompare)
    }
}