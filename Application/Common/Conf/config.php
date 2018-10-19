<?php
return array(
    #前台背景色
    'BG_COLOR' => '#40A0D4',
    #扩展配置文件
    'LOAD_EXT_CONFIG' => 'site',
    #数据库配置
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'sql489738',
    'DB_USER' => 'sql489738',
    //'DB_PWD' => 'v&RNjZ{Jto',
    'DB_PWD' => 'a13599bc',
    'DB_PORT' => 3306,
    'DB_PREFIX' => 'north_',
    'auth_code' => 'Ga29_f~*au',
    #登陆信息
    'ADMIN_INFO' => 'NorthCMS_AdminUser',
    'LOGIN_AUTH_KEY' => 'LOGIN_AUTH',
    'LOGIN_AUTH_VAL' => md5('A8_t^a9uI-+?2'),
    #URL配置
    'URL_MODEL' => 2,
    'TMPL_TEMPLATE_SUFFIX' => '.html',
    'URL_ROUTER_ON' => 'true',
    #文件上传参数配置
    'upload_extensions' => 'jpg,png,gif,zip,rar',
    'upload_maxsize' => '20480',
    #auth配置
    'AUTH_CONFIG' => array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'north_think_auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'north_think_auth_group_access', //用户组明细表
        'AUTH_RULE' => 'north_think_auth_rule', //权限规则表
        'AUTH_USER' => 'north_admin' //用户信息表
    ),
    #开启令牌验证
    'TOKEN_ON'=>    true,  // 是否开启令牌验证 默认关闭
    'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true

);
?>