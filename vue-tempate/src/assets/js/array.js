/**
 * 树形数据处理
 * @param variable
 * @returns {string|boolean}
 */
//获取所有的父级
export const getAllParent = (data2, nodeId2)=>{
    var arrRes = [];
    if (data2.length == 0) {
        if (!!nodeId2) {
            arrRes.unshift(data2)
        }
        return arrRes;
    }
    let rev = (data, nodeId) => {
        for (var i = 0, length = data.length; i < length; i++) {
            let node = data[i];
            if (node.id == nodeId) {
                arrRes.unshift(node)
                rev(data2, node.parent_id);
                break;
            }
            else {
                if (!!node.children) {
                    rev(node.children, nodeId);
                }
            }
        }
        return arrRes;
    };
    arrRes = rev(data2, nodeId2);
    return arrRes;
}

export default {
    getAllParent,
}