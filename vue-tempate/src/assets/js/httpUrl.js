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
            UPLOAD_ONE_IMG:'/common/upload/upload-one-img'//上传单图
        },
        TODO:{//待办事项相关接口列表
            LIST : '/common/to-do/get-to-do-list',
            MONTH_LIST : '/common/to-do/get-month-to-do-list',
            ADDOREDIT : '/common/to-do/add-or-edit',
            DELETETODO : '/common/to-do/delete-todo',
            VIEWTODO : '/common/to-do/view-todo',//查看待办事项
        },
    },
    ACCOUNT:{//用户模块控制器管理相关接口
        GET_USER_INFO:'/account/user/get-user-info',//获取用户信息
        EDIT_USER_INFO:'/account/user/edit-user-info',//修改用户信息
        EDIT_USER_PASS:'/account/user/edit-user-pass',//修改用户密码
    },
    MENU:{//菜单模块相关接口列表
        LIST : '/menu/menu/list',//全部菜单列表
        GET_ROLE_MENU_LIST : '/menu/menu/get-role-menu-list',//整站权限菜单列表
        ADD : '/menu/menu/add-menu',
        ADD_OR_EDIT : '/menu/menu/add-or-edit',
        GET_LEVEL_LMANU : '/menu/menu/get-level-menu',
        GET_ONLY_LMANU : '/menu/menu/get-only-menu',
        DELETE_MENU : '/menu/menu/delete-menu',//删除菜单
        SORT_MENU : '/menu/menu/sort-menu',//排序菜单
        ADD_PAGE_PERMISSION : '/menu/menu/add-page-permission',//添加页面权限
        GET_PAGE_PERMISSION_ITEM : '/menu/menu/get-page-permission-list',//获取页面权限
        GET_ROLE_PAGE_PERMISSION_ITEM : '/menu/menu/get-role-page-permission-list',
    },
    RBAC:{//rbac模块相关接口
        MANAGER:{//管理员管理相关接口
            ADD_MANAGER:'/rbac/manager/add-manager',
            GET_USER_LIST:'/rbac/manager/get-manager-list',
            EDIT_MANAGER:'/rbac/manager/edit-manager',
        },
        ROLE:{//管理员角色管理相关接口
            ADD_ROLE:'/rbac/role/add-role',
            GET_ROLE_INFO:'/rbac/role/get-role-info',
            GET_ROLE_LIST:'/rbac/role/get-role-list',
            DELETE_ROLE:'/rbac/role/delete-role',
            ADD_ROLE_PERMISSION:'/rbac/role/add-role-permission',
        },
    },
    LOG:{//日志模块相关接口列表
        LIST : '/log/login-log/list',
    },



};