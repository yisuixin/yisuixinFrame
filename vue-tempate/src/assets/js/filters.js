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

//10位时间戳
export const formatTime10 = (value, format = 'YYYY-MM-DD HH:mm:ss') => {
    return dayjs.unix(value).format(format)
}
//13位时间戳
export const formatTime13 = (value, format = 'YYYY-MM-DD HH:mm:ss') => {
    return dayjs(value).format(format)
}
export const getQueryVariable = (variable)=>{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){return pair[1];}
    }
    return(false);
}
//字符串长度截取
export const reBytesStr = (str, len,Symbol="...")=>{
//length属性读出来的汉字长度为1
    if(str.length*2 <= len) {
        return str;
    }
    var strlen = 0;
    var s = "";
    for(var i = 0;i < str.length; i++) {
        s = s + str.charAt(i);
        if (str.charCodeAt(i) > 128) {
            strlen = strlen + 2;
            if(strlen >= len){
                return s.substring(0,s.length-1) + Symbol;
            }
        } else {
            strlen = strlen + 1;
            if(strlen >= len){
                return s.substring(0,s.length-2) + Symbol;
            }
        }
    }
    return s;
}



export default {
    formatTime10,
    formatTime13,
    getQueryVariable,
    reBytesStr
}