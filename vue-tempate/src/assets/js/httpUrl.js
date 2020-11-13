//配置所有url列表接口
module.exports = {
    COMMON:{//公共模块控制器管理相关接口
        GET_CAPTCHA:'/common/captcha/get-captcha',//获取验证码
        USER_LOGIN : '/common/user/login',//用户登录
        QUICK_OPERATION:{//快捷操作相关接口
            GET_QUICK_OPERATION:'/common/quick-operation/get-quick-list',
            GET_USER_MENU_LIST : '/common/quick-operation/get-user-menu-list',
            ADD_QUICK : '/common/quick-operation/add-quick',
        },
        SYSTEMINFO:{//服务器信息相关接口列表
            SERVERINFO : '/common/system-info/server-info',
        },
        NOTICE:{//通知消息相关接口
            GET_USER_NOTICE_LIST:'/common/notice/get-user-notice-list',
            GET_NOTICE_INFO:'/common/notice/get-notice-info',
            GET_ADMIN_NOTICE_LIST:'/common/notice/get-admin-notice-list',
            ADD_NOTICE:'/common/notice/add-notice',
            DEL_NOTICE:'/common/notice/delete-notice',
            TOPPING_NOTICE:'/common/notice/topping-notice',
        },
        UPLOAD:{//上传模块文件相关接口
            UPLOAD_ONE_IMG:'/upload/upload/upload-one-img'//上传单图
        },
    },
    ACCOUNT:{//用户模块控制器管理相关接口
        GET_USER_INFO:'/account/user/get-user-info',//获取用户信息
        EDIT_USER_INFO:'/account/user/edit-user-info',//修改用户信息
        EDIT_USER_PASS:'/account/user/edit-user-pass',//修改用户密码
    },

    LOG:{//log日志相关接口列表
        LIST : '/api/log/list',
    },
    TODO:{//待办事项相关接口列表
        LIST : '/api/to-do/get-to-do-list',
        MONTH_LIST : '/api/to-do/get-month-to-do-list',
        ADDOREDIT : '/api/to-do/add-or-edit',
        DELETETODO : '/api/to-do/delete-todo',
    },

    MENU:{//菜单相关接口列表
        LIST : '/rabc/menu/list',//全部菜单列表
        GET_ROLE_MENU_LIST : '/rabc/menu/get-role-menu-list',//整站权限菜单列表
        ADD : '/rabc/menu/add-menu',
        ADD_OR_EDIT : '/rabc/menu/add-or-edit',
        GET_LEVEL_LMANU : '/rabc/menu/get-level-menu',
        GET_ONLY_LMANU : '/rabc/menu/get-only-menu',
        DELETE_MENU : '/rabc/menu/delete-menu',//删除菜单
        SORT_MENU : '/rabc/menu/sort-menu',//排序菜单
        ADD_PAGE_PERMISSION : '/rabc/menu/add-page-permission',//添加页面权限
        GET_PAGE_PERMISSION_ITEM : '/rabc/menu/get-page-permission-list',//获取页面权限
        GET_ROLE_PAGE_PERMISSION_ITEM : '/rabc/menu/get-role-page-permission-list',
    },

    MANAGER:{//管理员管理相关接口
        ADD_MANAGER:'/rabc/rabc/add-manager',
        GET_USER_LIST:'/rabc/rabc/get-user-list',
        EDIT_MANAGER:'/rabc/rabc/edit-manager',
    },
    ROLE:{//管理员角色管理相关接口
        ADD_ROLE:'/rabc/role/add-role',
        GET_ROLE_INFO:'/rabc/role/get-role-info',
        GET_ROLE_LIST:'/rabc/role/get-role-list',
        DELETE_ROLE:'/rabc/role/delete-role',
        ADD_ROLE_PERMISSION:'/rabc/role/add-role-permission',
    },

};