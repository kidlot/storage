<?php

return [
    'FRAMEWORK_VERSION' => ' V0.7 ',
    'DOMAIN_NAME_URL' => 'http://127.0.0.1:8080/',
    //图片域名
    'IMG_SITE_URL' => 'http://127.0.0.1:8080',
    'LOAD_EXT_CONFIG' => 'wechat,db',   
//***********************************URL设置**************************************
    //'MODULE_ALLOW_LIST' => ['Home', 'Backstage', 'Login'], //允许访问列表
    'MODULE_DENY_LIST' => ['Common'], // 禁止访问的模块列表
    'URL_MODEL' => 2, //URL模式
    'VAR_URL_PARAMS' => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR' => '/', //PATHINFO URL分割符
 //************************************缓存设置*********************************如果不要使用redis，请把redis相关去除，如果不会，下面的全部删除
    'REDIS_HOST'                        => '127.0.0.1',         //redis服务器ip，多台用逗号隔开；读写分离开启时，第一台负责写，其它[随机]负责读；
    'REDIS_PORT'                        => 6379,
    'REDIS_DB'                          => 15,                  //session用
    'REDIS_DB_S'                        => 15,                   //全局缓存用S方法用
    'REDIS_RW_SEPARATE'                 => true,                //Redis读写分离 true 开启
    'DATA_CACHE_TYPE'                   => 'Redis',             //默认动态缓存为Redis
    'DATA_CACHE_PREFIX'                 => 'data_tp_',              //缓存前缀
    'DATA_CACHE_TIME'                   => 3600 * 24 * 7,
    'SESSION_TYPE'                      => 'Redis',
    'SESSION_PREFIX'                    => 'tp_',
    'REDIS_TIMEOUT'                     => '300',                //超时时间
    'REDIS_PERSISTENT'                  => false,                 //是否长连接 false=短连接
//***********************************FTP设置**********************************
    'FTP_CFG' => [
        'host' => '127.0.0.1',
        'username' => 'admin',
        'password' => '000000', //密码
        'port' => '21',
        'timeout' => '90',
    ],
];
