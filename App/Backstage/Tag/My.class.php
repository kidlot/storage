<?php

namespace Backstage\Tag;
use Think\Template\TagLib;

class My extends TagLib {
    // 定义标签
    protected $tags=array(
        'jquery'=>array('attr'=>'','close'=>0),
        'bootstrapcss'=>array('attr'=>'icheck','close'=>0),
        'bootstrapjs'=>array('attr'=>'icheck','close'=>0),
        'suicss'=>array('attr'=>'icheck','close'=>0),
        'suijs'=>array('attr'=>'icheck','close'=>0),
        'framework7css'=>array('attr'=>'icheck','close'=>0),
        'framework7js'=>array('attr'=>'icheck','close'=>0),
        'frozenuicss'=>array('attr'=>'icheck','close'=>0),
        'frozenuijs'=>array('attr'=>'icheck','close'=>0),
        'icheckcss'=>array('attr'=>'','close'=>0),
        'icheckjs'=>array('attr'=>'color','close'=>0),
        'datejs'=>array('attr'=>'id,color','close'=>0),
        'layer'=>array('attr'=>'id,color','close'=>0),
        'animate'=>array('attr'=>'','close'=>0),
        'ueditor'=>array('attr'=>'name,content,height','close'=>0),
        'umeditorcss'=>array('attr'=>'','close'=>0),
        'umeditorjs'=>array('attr'=>'','close'=>0),
        'umeditor'=>array('attr'=>'name,content,height','close'=>0),
        'webuploadercss'=>array('attr'=>'','close'=>0),
        'webuploader'=>array('attr'=>'name,url,word','close'=>0),
        'webuploaderjs'=>array('attr'=>'','close'=>0),
		'acejs'=>array('attr'=>'','close'=>0),
		'acecss'=>array('attr'=>'','close'=>0),
		'wxjs'=>array('attr'=>'','close'=>0),
		'wxcss'=>array('attr'=>'','close'=>0),
        'piccss'=>array('attr'=>'','close'=>0),
        'picjs'=>array('attr'=>'','close'=>0),
        'onepicjs'=>array('attr'=>'','close'=>0),
        'custommenujs'=>array('attr'=>'','close'=>0),
        'custommenucss'=>array('attr'=>'','close'=>0),
        'autoreplyjs'=>array('attr'=>'','close'=>0),
        'autoreplycss'=>array('attr'=>'','close'=>0),
        'keywordcss'=>array('attr'=>'','close'=>0),
        'keywordjs'=>array('attr'=>'','close'=>0),
        );

    /**
     * layer弹出层
     */
    public function _layer(){
        $str=<<<php
<script src="__PUBLIC__/statics/layer/layer.js"></script>
<script src="__PUBLIC__/statics/layer/extend/layer.ext.js"></script>        
php;
        return $str;
    }

    /**
     * jquery
     */
    public function _jquery(){
        $str=<<<php
<script src="//libs.useso.com/js/jquery/1.10.2/jquery.min.js"></script>     
php;
        return $str;
    }

    /**
    * 引入laydate的js部分
    * @param string $tag  颜色主题
    */
    public function _datejs($tag){
        $theme=isset($tag['theme']) ? $tag['theme'] : 'molv';
        $config='laydate({elem: ".xb-date",event: "click",format: "YYYY/MM/DD hh:mm:ss",istime: false,isclear: true,istoday: true,issure: true,festival: true,min: "2015-03-01 00:00:00",max: "2015-04-01 23:59:59",start: laydate.now(),fixed: false,zIndex: 99999999})';
        $link=<<<php
<script src="__PUBLIC__/statics/laydate-v1.1/laydate.js"></script>
<script>
    $('body').attr('id', 'xb-date');
    laydate.skin("$theme");
    var tody=laydate.now();
    laydate({
        elem: '#xb-date .xb-date',
        event: 'click',
        format: 'YYYY-MM-DD hh:mm:ss',
        istime: true,
        isclear: true,
        istoday: true,
        issure: true,
        festival: true,
        start: laydate.now(),
        fixed: false,
        zIndex: 99999999,
    })
</script>
php;
        return $link;
    }

    //引入animate
    public function _animate(){
        return '<link rel="stylesheet" href="__PUBLIC__/statics/css/animate.css">';
    }

    /**
    * 引入ickeck的css部分
    */
    public function _icheckcss(){
        $link=<<<php
    <link rel="stylesheet" href="__PUBLIC__/statics/iCheck-1.0.2/skins/all.css">
php;
        return $link;
    }

    /**
    * 引入ickeck的js部分
    * @param string $tag  颜色主题
    */
    public function _icheckjs($tag){
        $color=isset($tag['color']) ? $tag['color'] : 'green';
        $link=<<<php
<script src="__PUBLIC__/statics/iCheck-1.0.2/icheck.min.js"></script>
<script>
$(document).ready(function(){
    $('.xb-icheck').iCheck({
        checkboxClass: "icheckbox_minimal-$color",
        radioClass: "iradio_minimal-$color",
        increaseArea: "20%"
    });
});
</script>
php;
        return $link;
    }

    // bootstrapcss标签
    public function _bootstrapcss($tag,$content) {
        $link=<<<php
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="__PUBLIC__/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
	<link rel="stylesheet" href="__PUBLIC__/statics/css/base.css" />
    <link rel="stylesheet" href="__PUBLIC__/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="__PUBLIC__/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
php;
    return $link;
    }
	
  // 集合css
    public function _acecss($tag,$content) {
        $link=<<<php
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="__ADMIN_ACEADMIN__/css/bootstrap.css" />
	<link rel="stylesheet" href="__ADMIN_ACEADMIN__/css/font-awesome.css" />
	<link rel="stylesheet" href="__ADMIN_ACEADMIN__/css/ace-fonts.css" />
	<link rel="stylesheet" href="__ADMIN_ACEADMIN__/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
	<link rel="stylesheet" href="__ADMIN_ACEADMIN__/css/ace.min.css" />
php;
    return $link;
    }
	
	// 集合css
    public function _acejs($tag,$content) {
        $link=<<<php
		
	<script src="__ADMIN_ACEADMIN__/js/ace-extra.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/jquery.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/jquery.mobile.custom.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/bootstrap.js"></script>
	<script src="__ADMIN_ACEADMIN__/myjs/js/bootbox.js"></script>
    <script src="__ADMIN_ACEADMIN__/js/ace/elements.scroller.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/elements.colorpicker.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/elements.fileinput.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/elements.typeahead.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/elements.wysiwyg.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/elements.spinner.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/elements.treeview.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/elements.wizard.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/elements.aside.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.ajax-content.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.touch-drag.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.sidebar.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.sidebar-scroll-1.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.submenu-hover.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.widget-box.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.settings.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.settings-rtl.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.settings-skin.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.widget-on-reload.js"></script>
	<script src="__ADMIN_ACEADMIN__/js/ace/ace.searchbox-autocomplete.js"></script>
php;
    return $link;
    }
	
	
	
    // bootstrapjs标签
    public function _bootstrapjs($tag,$content) {
        // 是否登录
        $is_login=check_login() ? 1 : 0;
        if ($is_login) {
            // 获取用户id
            $uid=get_uid();
            // 获取用户名
            $username=session("user.username");
        }else{
            $uid='';
            $username='';
        }
        $link=<<<php
<!-- 引入bootstrjs部分开始 -->
<script src="__PUBLIC__/statics/js/jquery-1.10.2.min.js"></script>
<script src="__PUBLIC__/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script>
    var xbIsLogin=$is_login,
        xbCheckLoginUrl='{:U('Home/Public/ajax_check_login')}',
        fwbCheckLoginUrl ="{:U('User/Login/check_login')}",
        fwbLoginOutUrl="{:U('User/Login/ajax_logout')}",
        rongUserInfoUrl="{:U('Api/Rong/get_user_info')}",
        rongKey="",
        rongToken="",
        xbUserInfo = {
            id: "$uid",
            name: "$username",
            avatar: ""
        };
</script>
<script src="__PUBLIC__/statics/emoji/js/config.js"></script>
<script src="__PUBLIC__/statics/emoji/js/emoji-picker.js"></script>
<script src="__PUBLIC__/statics/emoji/js/jquery.emojiarea.js"></script>
php;
    return $link;
    }

    // bootstrapcss标签
    public function _suicss($tag,$content) {
        $link=<<<php
<link rel="stylesheet" href="__PUBLIC__/statics/sui-0.6.1/css/sm.min.css">
php;
    return $link;
    }

    // bootstrapjs标签
    public function _suijs($tag,$content) {
        $link=<<<php
<script src="__PUBLIC__/statics/js/zepto-1.1.6.min.js"></script>
<script src="__PUBLIC__/statics/sui-0.6.1/js/sm.min.js"></script>
<script>
    $.init();
</script>
php;
    return $link;
    }

    // framework7css标签
    public function _framework7css($tag,$content) {
        $link=<<<php
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="__PUBLIC__/statics/Framework7-1.2.0/css/framework7.ios.min.css" />
    <link rel="stylesheet" href="__PUBLIC__/statics/Framework7-1.2.0/css/framework7.ios.colors.min.css" />
php;
    return $link;
    }

    // framework7js标签
    public function _framework7js($tag,$content) {
        $link=<<<php
    <script src="__PUBLIC__/statics/Framework7-1.2.0/js/framework7.min.js"></script>
php;
    return $link;
    }

    // frozenuicss标签
    public function _frozenuicss($tag,$content) {
        $link=<<<php
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="__PUBLIC__/statics/frozenui-1.3.0/css/frozen.css" />
php;
    return $link;
    }

    // frozenuijs标签
    public function _frozenuijs($tag,$content) {
        $link=<<<php
<script src="__PUBLIC__/statics/frozenui-1.3.0/lib/zepto.min.js"></script>
<script src="__PUBLIC__/statics/frozenui-1.3.0/js/frozen.js"></script>
php;
    return $link;
    }

    /**
    * 引入umeidter的css部分
    */
   public function _umeditorcss(){
        $link=<<<php
<link rel="stylesheet" href="__PUBLIC__/statics/umeditor1_2_2/themes/default/css/umeditor.css">
php;
        return $link;
   }
    /**
    * 引入umeidter的js部分
    */
   public function _umeditorjs(){
        $link=<<<php
<script src="__PUBLIC__/statics/umeditor1_2_2/umeditor.config.js"></script>
<script src="__PUBLIC__/statics/umeditor1_2_2/umeditor.js"></script>
<script src="__PUBLIC__/statics/umeditor1_2_2/lang/zh-cn/zh-cn.js"></script>
php;
        return $link;
   }
    /**
    * 引入umeidter编辑器
    * @param string $tag  name:表单name content：编辑器初始化后 默认内容
    */
   public function _umeditor($tag){
        $name=isset($tag['name']) ? $tag['name'] : 'content';
        $content=isset($tag['content']) ? $tag['content'] : '';
        $height=isset($tag['height']) ? $tag['height'] : '320';
        $link=<<<php
<!-- 加载编辑器的容器 -->
<script id="container" name="$name" type="text/plain" >$content</script>
<!-- 实例化编辑器代码 -->
<script>
    $(function(){
        window.um = UM.getEditor('container',{
            initialFrameHeight:$height
        });
    });
</script>
php;
        return $link;
   }

    /**
    * 引入ueidter编辑器
    * @param string $tag  name:表单name content：编辑器初始化后 默认内容
    */
    public function _ueditor($tag){
        $name=isset($tag['name']) ? $tag['name'] : 'content';
        $content=isset($tag['content']) ? $tag['content'] : '';
        $height=isset($tag['height']) ? $tag['height'] : '300';
        $link=<<<php
<script id="container" name="$name" type="text/plain">
    $content
</script>
<script src="__PUBLIC__/statics/ueditor1_4_3/ueditor.config.js"></script>
<script src="__PUBLIC__/statics/ueditor1_4_3/ueditor.all.js"></script>
<script>
    var um = UE.getEditor('container',{
        initialFrameHeight:$height,
        toolbars: [[
            'fullscreen',  'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'emotion', 'scrawl', 'insertvideo', 'music', 'map',   'insertcode', 'template', '|',
            'horizontal', 'date', 'time', 'spechars', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
             'searchreplace', 'drafts'
        ]],
        autoHeightEnabled:false,
        catchRemoteImageEnable:true
    });
</script>
php;
        return $link;
    }

    // webuploader的css部分和jquery因为插件需要引在jquery后边；所以在头部引入了jquery
    public function _webuploadercss(){
        $str=<<<php
<link rel="stylesheet" href="__PUBLIC__/statics/webuploader-0.1.5/xb-webuploader.css">
<script src="//libs.useso.com/js/jquery/1.10.2/jquery.min.js"></script>
php;
        return $str;
    }

    // webuploader的js部分
    public function _webuploaderjs(){
        $str=<<<php
<script>
    var BASE_URL = '__PUBLIC__/statics/webuploader-0.1.5';
</script>
<script src="//cdn.staticfile.org/webuploader/0.1.5/webuploader.min.js"></script>
php;
        return $str;
    }

    /**
     * 上传标签
     * @param string $tag  url上传的图片处理的控制器 name 表单name
     */
    public function _webuploader($tag){
        $url=isset($tag['url'])?$tag['url']:U('Home/Index/upload');
        $name=isset($tag['name'])?$tag['name']:'file_name';
        $word=isset($tag['word'])?$tag['word']:'或将照片拖到这里，单次最多可选300张';
        $id_name='upload-'.uniqid();
            $str=<<<php
<div id="$id_name" class="xb-uploader">
    <input type="hidden" name="$name">
    <div class="queueList">
        <div class="placeholder">
            <div class="filePicker"></div>
            <p>$word</p>
        </div>
    </div>
    <div class="statusBar" style="display:none;">
        <div class="progress">
            <span class="text">0%</span>
            <span class="percentage"></span>
        </div>
        <div class="info"></div>
        <div class="btns">
            <div class="uploadBtn">开始上传</div>
        </div>
    </div>
</div>
<script>
jQuery(function() {
    var \$ = jQuery,    // just in case. Make sure it's not an other libaray.

        \$wrap = \$("#$id_name"),

        // 图片容器
        \$queue = \$('<ul class="filelist"></ul>')
            .appendTo( \$wrap.find('.queueList') ),

        // 状态栏，包括进度和控制按钮
        \$statusBar = \$wrap.find('.statusBar'),

        // 文件总体选择信息。
        \$info = \$statusBar.find('.info'),

        // 上传按钮
        \$upload = \$wrap.find('.uploadBtn'),

        // 没选择文件之前的内容。
        \$placeHolder = \$wrap.find('.placeholder'),

        // 总体进度条
        \$progress = \$statusBar.find('.progress').hide(),

        // 添加的文件数量
        fileCount = 0,

        // 添加的文件总大小
        fileSize = 0,

        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 110 * ratio,
        thumbnailHeight = 110 * ratio,

        // 可能有pedding, ready, uploading, confirm, done.
        state = 'pedding',

        // 所有文件的进度信息，key为file id
        percentages = {},

        supportTransition = (function(){
            var s = document.createElement('p').style,
                r = 'transition' in s ||
                      'WebkitTransition' in s ||
                      'MozTransition' in s ||
                      'msTransition' in s ||
                      'OTransition' in s;
            s = null;
            return r;
        })(),

        // WebUploader实例
        uploader;

    if ( !WebUploader.Uploader.support() ) {
        alert( 'Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
        throw new Error( 'WebUploader does not support the browser you are using.' );
    }

    // 实例化
    uploader = WebUploader.create({
        pick: {
            id: "#$id_name .filePicker",
            label: '点击选择文件',
            multiple : false
        },
        dnd: "#$id_name .queueList",
        paste: document.body,
        // accept: {
        //     title: 'Images',
        //     extensions: 'gif,jpg,jpeg,bmp,png',
        //     mimeTypes: 'image/*'
        // },

        // swf文件路径
        swf: BASE_URL + '/Uploader.swf',

        disableGlobalDnd: true,

        chunked: true,
        server: "$url",
        fileNumLimit: 300,
        fileSizeLimit: 5 * 1024 * 1024,    // 200 M
        fileSingleSizeLimit: 1 * 1024 * 1024    // 50 M
    });

    // 添加“添加文件”的按钮，
    // uploader.addButton({
    //    id: "#$id_name .filePicker2",
    //    label: '继续添加'
    // });

    // 当有文件添加进来时执行，负责view的创建
    function addFile( file ) {
        var \$li = \$( '<li id="' + file.id + '">' +
                '<p class="title">' + file.name + '</p>' +
                '<p class="imgWrap"></p>'+
                '<p class="progress"><span></span></p>' +
                '</li>' ),

            \$btns = \$('<div class="file-panel">' +
                '<span class="cancel">删除</span>' +
                '<span class="rotateRight">向右旋转</span>' +
                '<span class="rotateLeft">向左旋转</span></div>').appendTo( \$li ),
            \$prgress = \$li.find('p.progress span'),
            \$wrap = \$li.find( 'p.imgWrap' ),
            \$info = \$('<p class="error"></p>'),

            showError = function( code ) {
                switch( code ) {
                    case 'exceed_size':
                        text = '文件大小超出';
                        break;

                    case 'interrupt':
                        text = '上传暂停';
                        break;

                    default:
                        text = '上传失败，请重试';
                        break;
                }

                \$info.text( text ).appendTo( \$li );
            };

        if ( file.getStatus() === 'invalid' ) {
            showError( file.statusText );
        } else {
            // @todo lazyload
            \$wrap.text( '预览中' );
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    \$wrap.text( '不能预览' );
                    return;
                }

                var img = \$('<img src="'+src+'">');
                \$wrap.empty().append( img );
            }, thumbnailWidth, thumbnailHeight );

            percentages[ file.id ] = [ file.size, 0 ];
            file.rotation = 0;
        }

        file.on('statuschange', function( cur, prev ) {
            if ( prev === 'progress' ) {
                \$prgress.hide().width(0);
            } else if ( prev === 'queued' ) {
                \$li.off( 'mouseenter mouseleave' );
                \$btns.remove();
            }

            // 成功
            if ( cur === 'error' || cur === 'invalid' ) {
                console.log( file.statusText );
                showError( file.statusText );
                percentages[ file.id ][ 1 ] = 1;
            } else if ( cur === 'interrupt' ) {
                showError( 'interrupt' );
            } else if ( cur === 'queued' ) {
                percentages[ file.id ][ 1 ] = 0;
            } else if ( cur === 'progress' ) {
                \$info.remove();
                \$prgress.css('display', 'block');
            } else if ( cur === 'complete' ) {
                \$li.append( '<span class="success"></span>' );
            }

            \$li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
        });

        \$li.on( 'mouseenter', function() {
            \$btns.stop().animate({height: 30});
        });

        \$li.on( 'mouseleave', function() {
            \$btns.stop().animate({height: 0});
        });

        \$btns.on( 'click', 'span', function() {
            var index = \$(this).index(),
                deg;

            switch ( index ) {
                case 0:
                    uploader.removeFile( file );
                    return;

                case 1:
                    file.rotation += 90;
                    break;

                case 2:
                    file.rotation -= 90;
                    break;
            }

            if ( supportTransition ) {
                deg = 'rotate(' + file.rotation + 'deg)';
                \$wrap.css({
                    '-webkit-transform': deg,
                    '-mos-transform': deg,
                    '-o-transform': deg,
                    'transform': deg
                });
            } else {
                \$wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                // use jquery animate to rotation
                // \$({
                //     rotation: rotation
                // }).animate({
                //     rotation: file.rotation
                // }, {
                //     easing: 'linear',
                //     step: function( now ) {
                //         now = now * Math.PI / 180;

                //         var cos = Math.cos( now ),
                //             sin = Math.sin( now );

                //         \$wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                //     }
                // });
            }


        });

        \$li.appendTo( \$queue );
    }

    // 负责view的销毁
    function removeFile( file ) {
        var \$li = \$('#'+file.id);

        delete percentages[ file.id ];
        updateTotalProgress();
        \$li.off().find('.file-panel').off().end().remove();
    }

    function updateTotalProgress() {
        var loaded = 0,
            total = 0,
            spans = \$progress.children(),
            percent;

        \$.each( percentages, function( k, v ) {
            total += v[ 0 ];
            loaded += v[ 0 ] * v[ 1 ];
        } );

        percent = total ? loaded / total : 0;

        spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
        spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
        updateStatus();
    }

    function updateStatus() {
        var text = '', stats;

        if ( state === 'ready' ) {
            text = '选中' + fileCount + '个文件，共' +
                    WebUploader.formatSize( fileSize ) + '。';
        } else if ( state === 'confirm' ) {
            stats = uploader.getStats();
            if ( stats.uploadFailNum ) {
                text = '已成功上传' + stats.successNum+ '个文件，'+
                    stats.uploadFailNum + '个上传失败，<a class="retry" href="#">重新上传</a>失败文件或<a class="ignore" href="#">忽略</a>'
            }

        } else {
            stats = uploader.getStats();
            text = '共' + fileCount + '个（' +
                    WebUploader.formatSize( fileSize )  +
                    '），已上传' + stats.successNum + '个';

            if ( stats.uploadFailNum ) {
                text += '，失败' + stats.uploadFailNum + '个';
            }
        }

        \$info.html( text );
    }

    uploader.onUploadAccept=function(object ,ret){
        if(ret.error_info){
            fileError=ret.error_info;
            return false;
        }
    }

    uploader.onUploadSuccess=function(file ,response){
        fileName=response.name;
    }
    uploader.onUploadError=function(file){
        alert(fileError);
    }

    function setState( val ) {
        var file, stats;
        if ( val === state ) {
            return;
        }

        \$upload.removeClass( 'state-' + state );
        \$upload.addClass( 'state-' + val );
        state = val;

        switch ( state ) {
            case 'pedding':
                \$placeHolder.removeClass( 'element-invisible' );
                \$queue.parent().removeClass('filled');
                \$queue.hide();
                \$statusBar.addClass( 'element-invisible' );
                uploader.refresh();
                break;

            case 'ready':
                \$placeHolder.addClass( 'element-invisible' );
                \$( "#$id_name .filePicker2" ).removeClass( 'element-invisible');
                \$queue.parent().addClass('filled');
                \$queue.show();
                \$statusBar.removeClass('element-invisible');
                uploader.refresh();
                break;

            case 'uploading':
                \$( "#$id_name .filePicker2" ).addClass( 'element-invisible' );
                \$progress.show();
                \$upload.text( '暂停上传' );
                break;

            case 'paused':
                \$progress.show();
                \$upload.text( '继续上传' );
                break;

            case 'confirm':
                \$progress.hide();
                \$upload.text( '开始上传' ).addClass( 'disabled' );

                stats = uploader.getStats();
                if ( stats.successNum && !stats.uploadFailNum ) {
                    setState( 'finish' );
                    return;
                }
                break;
            case 'finish':
                stats = uploader.getStats();
                if ( stats.successNum ) {
                    \$("#$id_name input[name='$name']").val(fileName);
                } else {
                    // 没有成功的图片，重设
                    state = 'done';
                    location.reload();
                }
                break;
        }
        updateStatus();
    }

    uploader.onUploadProgress = function( file, percentage ) {
        var \$li = \$('#'+file.id),
            \$percent = \$li.find('.progress span');

        \$percent.css( 'width', percentage * 100 + '%' );
        percentages[ file.id ][ 1 ] = percentage;
        updateTotalProgress();
    };

    uploader.onFileQueued = function( file ) {
        fileCount++;
        fileSize += file.size;

        if ( fileCount === 1 ) {
            \$placeHolder.addClass( 'element-invisible' );
            \$statusBar.show();
        }

        addFile( file );
        setState( 'ready' );
        updateTotalProgress();
    };

    uploader.onFileDequeued = function( file ) {
        fileCount--;
        fileSize -= file.size;

        if ( !fileCount ) {
            setState( 'pedding' );
        }

        removeFile( file );
        updateTotalProgress();

    };

    uploader.on( 'all', function( type ) {
        var stats;
        switch( type ) {
            case 'uploadFinished':
                setState( 'confirm' );
                break;

            case 'startUpload':
                setState( 'uploading' );
                break;

            case 'stopUpload':
                setState( 'paused' );
                break;

        }
    });

    uploader.onError = function( code ) {
        alert( 'Eroor: ' + code );
    };

    \$upload.on('click', function() {
        if ( \$(this).hasClass( 'disabled' ) ) {
            return false;
        }

        if ( state === 'ready' ) {
            uploader.upload();
        } else if ( state === 'paused' ) {
            uploader.upload();
        } else if ( state === 'uploading' ) {
            uploader.stop();
        }
    });

    \$info.on( 'click', '.retry', function() {
        uploader.retry();
    } );

    \$info.on( 'click', '.ignore', function() {
        alert( 'todo' );
    } );

    \$upload.addClass( 'state-' + state );
    updateTotalProgress();
});
</script>
php;
        return $str;
    }
	
	
	//微信相关css标签
    public function _wxcss($tag,$content) {
        $link=<<<php
<link rel="stylesheet" href="__ADMIN_ACEADMIN_WX_CSS__/base.css">
<link rel="stylesheet" href="__ADMIN_ACEADMIN_WX_CSS__/module.css?v=0.2">
<link rel="stylesheet" href="__ADMIN_ACEADMIN_WX_CSS__/weiphp.css?v=1.1">
php;
        return $link;
    }

    //引入多图片上传css样式
    public function _piccss(){
 $link=<<<php
<link rel="stylesheet" href="__ADMIN_ACEADMIN__/css/upload/pic.css">
<link rel="stylesheet" href="__ADMIN_ACEADMIN__/css/upload/picupload.css">
<link rel="stylesheet" href="__PUBLIC__/statics/font-awesome-4.4.0/css/font-awesome.min.css">
php;
return $link;
    }
    //引入多图片上传js
 public function _picjs(){
        $str=<<<php
<script src="__ADMIN_ACEADMIN__/js/upload/pic.js?version=2.1"></script>
<script src="__ADMIN_ACEADMIN__/js/plupload/plupload.full.min.js"></script>
php;
        return $str;
    }
    //但图片上传weiphp
 public function _onepicjs(){
        $str=<<<php
<script src="__ADMIN_ACEADMIN__/js/jquery.uploadify.min.js"></script>
<script src="__ADMIN_ACEADMIN__/js/dialog.js"></script>
<script src="__ADMIN_ACEADMIN__/js/admin_common.js?v=0.1"></script>
<script src="__ADMIN_ACEADMIN__/js/admin_image.js"></script>
<script src="__ADMIN_ACEADMIN__/js/masonry.pkgd.min.js"></script>
<script src="__ADMIN_ACEADMIN__/js/jquery.dragsort-0.5.2.min.js"></script>
php;
        return $str;
    }
//微信自定义菜单需要。网上找的
    public function _custommenucss(){
 $link=<<<php
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/bootstrap.min.css" rel="stylesheet"/>
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/demo.css" rel="stylesheet"/>
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/font-awesome.min.css" rel="stylesheet"/>
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/meezao.css?v=1" rel="stylesheet"/>
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/base.css" rel="stylesheet"/>
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/d_menu.css" rel="stylesheet"/>
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/pic.css" rel="stylesheet"/>
php;
return $link;
    }
//微信自定义菜单需要。网上找的
 public function _custommenujs(){
        $str=<<<php
<script src="__ADMIN_ACEADMIN__/wx/customMenu/js/jquery-1.11.1.min.js"></script>
<script src="__ADMIN_ACEADMIN__/wx/customMenu/js/bootstrap.min.js"></script>
<script src="__ADMIN_ACEADMIN__/wx/customMenu/js/meezao.js"></script>
<script src="__ADMIN_ACEADMIN__/wx/customMenu/js/d_menu.js?v=3.7"></script>
php;
        return $str;
    }
    public function _autoreplycss(){
 $link=<<<php
 <link rel="stylesheet" href="__ADMIN_ACEADMIN_WX_CSS__/module.css?v=0.2">
 <link rel="stylesheet" href="__ADMIN_ACEADMIN_WX_CSS__/weiphp.css?v=1.1">
 <link href="__ADMIN_ACEADMIN__/wx/customMenu/css/bootstrap.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="__PUBLIC__/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="__PUBLIC__/statics/css/base.css" />
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/d_menu.css" rel="stylesheet"/>
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/pic.css" rel="stylesheet"/>

php;
return $link;
    }

 public function _autoreplyjs(){
        $str=<<<php
<script src="__ADMIN_ACEADMIN__/wx/customMenu/js/jquery-1.11.1.min.js"></script>
<script src="__ADMIN_ACEADMIN__/wx/customMenu/js/bootstrap.min.js"></script>
<script src="__ADMIN_ACEADMIN__/js/admin_common.js?v=0.1"></script>
<script src="__ADMIN_ACEADMIN__/wx/autoReply/js/d_reply.js?v=1.6"></script>
php;
        return $str;
    }
    public function _keywordcss(){
 $link=<<<php
 <link rel="stylesheet" href="__ADMIN_ACEADMIN_WX_CSS__/module.css?v=0.2">
 <link rel="stylesheet" href="__ADMIN_ACEADMIN_WX_CSS__/weiphp.css?v=1.1">
 <link href="__ADMIN_ACEADMIN__/wx/customMenu/css/bootstrap.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="__PUBLIC__/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="__PUBLIC__/statics/css/base.css" />
<link href="__ADMIN_ACEADMIN__/wx/customMenu/css/d_menu.css" rel="stylesheet"/>
<link href="__ADMIN_ACEADMIN__/wx/keyword/css/reply_keywords.css" rel="stylesheet"/>
<link href="__ADMIN_ACEADMIN__/wx/keyword/css/demo.css?v=1" rel="stylesheet"/>
php;
return $link;
    }

 public function _keywordjs(){
        $str=<<<php
<script src="__ADMIN_ACEADMIN__/wx/customMenu/js/jquery-1.11.1.min.js"></script>
<script src="__ADMIN_ACEADMIN__/wx/customMenu/js/bootstrap.min.js"></script>
<script src="__ADMIN_ACEADMIN__/js/admin_common.js"></script>
<script src="__ADMIN_ACEADMIN__/wx/autoReply/js/d_replykeywords.js?v=2"></script>
php;
        return $str;
    }

}

