<?php

return [
    /*     * ***********************************附加设置********************************** */
    'SHOW_PAGE_TRACE' => false, // 是否显示调试面板
    'URL_CASE_INSENSITIVE' => false, // url区分大小写
    'TAGLIB_BUILD_IN' => 'Cx,Backstage\Tag\My', // 加载自定义标签
    'TMPL_PARSE_STRING' => [// 定义常用路径
        '__PUBLIC__' => __ROOT__ . '/Public/Default',
        '__ADMIN_ACEADMIN__' => __ROOT__ . '/Public/Default/aceadmin',
        '__ADMIN_ACEADMIN_WX_CSS__' => __ROOT__ . '/Public/Default/aceadmin/wx/css',
        '__ADMIN_ACEADMIN_WX_IMG__' => __ROOT__ . '/Public/Default/aceadmin/wx/images',
    ],
    /*     * *********************************auth设置********************************* */
    'AUTH_CONFIG' => [
        'AUTH_USER' => 'admin_users'                         //用户信息表
    ],
    /*     * *********************************邮件服务器********************************* */
    'EMAIL_FROM_NAME' => '', // 发件人
    'EMAIL_SMTP' => '', // smtp
    'EMAIL_USERNAME' => '', // 账号
    'EMAIL_PASSWORD' => '', //密码
    /*     * *********************************其他配置********************************* */
    'NEED_UPLOAD_OSS' => [ // 需要上传的目录
        '/Public/Upload/avatar',
        '/Public/Upload/cover',
        '/Public/Upload/image/webuploader',
        '/Public/Upload/video',
    ],
    'VERIFY_CONFLATION' => 'tp',
    'DEFAULT_PAGE_SIZE' => 20,
    'PICTURE_UPLOAD_DRIVER' => 'Local',
    'UPLOAD_LOCAL_CONFIG' => array (),
    /* 图片上传相关配置 */
    'PICTURE_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Public/Upload/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
	'LANG_SWITCH_ON' => true,   // 开启语言包功能
    /************************************微信调用接口配置********************************* */
];
