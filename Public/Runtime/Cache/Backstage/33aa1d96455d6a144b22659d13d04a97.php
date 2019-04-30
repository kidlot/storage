<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>被添加回复</title>
</head>
<body class="d_menu">
<!-- #section:basics/面包屑导航 -->
	
<div class="breadcrumbs" id="breadcrumbs">
	<ul class="breadcrumb" style="margin-bottom: 2px;font-size: 12px;">
		<li>
			<i class="fa fa-home" style="font-size: 20px;margin-left: 2px;margin-right: 2px;"></i>
			首页
		</li>
		<?php if($breadcrumbs['title3'] != ''): ?><li><?php echo ($breadcrumbs['title3']); ?></li><?php endif; ?>
		<?php if($breadcrumbs['title2'] != ''): ?><li><?php echo ($breadcrumbs['title2']); ?></li><?php endif; ?>
		<?php if($breadcrumbs['title1'] != ''): ?><li><?php echo ($breadcrumbs['title1']); ?></li><?php endif; ?>
	</ul>

</div>
<!--提交信息-->
<div id="top-alert" class="top-alert-tips alert-error" style="display: none;">
  <a class="close" href="javascript:;"><b class="fa fa-times-circle"></b></a>
  <div class="alert-content"></div>
</div>
<!-- /section:basics/面包屑导航 -->
 <link rel="stylesheet" href="/Public/Default/aceadmin/wx/css/module.css?v=0.2">
 <link rel="stylesheet" href="/Public/Default/aceadmin/wx/css/weiphp.css?v=1.1">
 <link href="/Public/Default/aceadmin/wx/customMenu/css/bootstrap.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/Public/Default/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="/Public/Default/statics/css/base.css" />
<link href="/Public/Default/aceadmin/wx/customMenu/css/d_menu.css" rel="stylesheet"/>
<link href="/Public/Default/aceadmin/wx/customMenu/css/pic.css" rel="stylesheet"/>

<ul id="myTab" class="nav nav-tabs">
<li class="active"><a href="<?php echo U('index');?>">被添加回复</a></li>
<li><a href="<?php echo U('beadded');?>">自动回复</a></li>
<li><a href="<?php echo U('keywords');?>">关键字回复</a></li>
</ul>
<div class="c_s_box">
	<a href="javascript:void(0);" class="msg_show btn"></a>
	<input id="js_save" class="btn btn-success" type="button" value="保存">
	<input id="js_del" class="btn btn-default" type="button" value="删除回复" data-toggle="modal" data-target="#myModal_del">
</div>
<div class="main_content_mb">
	<div class="menu_form_area" style="width: 800px">
		<div class="msg_sender" id="editDiv">
			<div class="tab_navs_panel">
				<div class="tab_navs_wrp">
					<ul class="tab_navs js_tab_navs">
						<li class="tab_nav tab_appmsg selected" data-tooltip="图文消息" data-type="news">
							<a href="javascript:void(0);">&nbsp;<i class="icon_msg_sender"></i><span class="msg_tab_title">图文消息</span></a>
						</li>
						<li class="tab_nav tab_text " data-tooltip="文字" data-type="text">
							<a href="javascript:void(0);">&nbsp;<i class="icon_msg_sender"></i><span class="msg_tab_title">文字</span></a>
						</li>
						<li class="tab_nav tab_image tab_img" data-tooltip="图片" data-type="image">
							<a href="javascript:void(0);">&nbsp;<i class="icon_msg_sender"></i><span class="msg_tab_title">图片</span></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="tab_panel">
				<!-------------切换内容---------------->
				<div class="tab_content">
					<div class="js_appmsgArea inner ">
						<div class="tab_cont_cover jsMsgSendTab" style="padding: 5px;margin-top: -20px;">
							<div class="appmsg_wrap material_list" style="height:auto;display:none;"></div>
							 <a class="jsmsgSenderDelBt link_dele" href="javascript:;" style="display:none;" onclick="return false;">删除</a>
							<div class="MsgSend_media_box">
								<div class="media_cover" >
								  <span class="create_access" style="padding: 82px 0px;">
									 <a class="add_gray_wrp jsMsgSenderPopBt" href="javascript:;" data-toggle="modal" data-target="#myModal_sucai">
										 <i class="icon36_common add_gray"></i>
										 <strong>从素材库中选择</strong>
									 </a>
								  </span>
								</div>
								<div class="media_cover">
								  <span class="create_access" style="padding: 82px 0px;">
									  <a  class="add_gray_wrp" href="<?php echo U('MaterialNews/index');?>">
										  <i class="icon36_common add_gray"></i>
										  <strong>新建图文消息</strong>
									  </a>
								 </span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab_content" style="display:none">
					<div class="js_textArea inner no_extra">
						<div class="emotion_editor">
							<div class="edit_area js_editorArea" contenteditable="true" style="height: 210px;"></div>
							<div class="editor_toolbar">
								<p class="editor_tip js_editorTip">还可以输入<em>600</em>字</p>
							</div>
						</div>
					</div>
				</div>
				<div class="tab_content">
					<div class="js_appmsgArea inner ">
						<div class="tab_cont_cover jsMsgSendTab" style="padding: 5px;margin-top: -20px;">
							<div class="appmsg_wrap material_list_image appmsg_wrap_image material_list" style="height:auto;display:none;"></div>
							 <a class="jsmsgSenderDelBt link_dele_image" href="javascript:;" style="display:none;" onclick="return false;">删除</a>
							<div class="MsgSend_media_box_image">
								<div class="media_cover" >
								  <span class="create_access" style="padding: 82px 0px;">
									 <a class="add_gray_wrp jsMsgSenderPopBt_image" href="javascript:;" data-toggle="modal" data-target="#myModal_sucai">
										 <i class="icon36_common add_gray"></i>
										 <strong>从素材库中选择</strong>
									 </a>
								  </span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--------------删除菜单框------------------------>
<div class="modal fade" id="myModal_del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="left:47%;width:613px; display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="margin-top:5px;"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel" style="color:#333;margin:5px 0">
                    温馨提示
                </h4>
            </div>
            <div class="modal-body" style="color:#333;height:200px;font-size:14px">
                <div class="msg_icon_wrapper">
                </div>
                <div>
                    <p>删除确认</p>
					<br>
                    <p style="color:#8d8d8d">您将删除“被添加回复”的消息</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="js_confirm" data-dismiss="modal">
                    确定
                </button>
            </div>
        </div>
    </div>
</div>
</body>
<style>
.c_s_box{	
	width: 800px;
    text-align: right;
}
.c_s_box input{
	width: 100px;
	margin-left: 15px;
	margin-bottom: 10px;
}
.c_s_box a{
	margin-left: 15px;
	margin-bottom: 10px;
}
.msg_show{
	display: none;
}
</style>
<script src="/Public/Default/aceadmin/wx/customMenu/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Default/aceadmin/wx/customMenu/js/bootstrap.min.js"></script>
<script src="/Public/Default/aceadmin/js/admin_common.js?v=0.1"></script>
<script src="/Public/Default/aceadmin/wx/autoReply/js/d_reply.js?v=1.6"></script>
<script>
	var IMG_PATH = "/Public/Default/aceadmin/wx/images";
	var STATIC = "/Public/Default/aceadmin/js";
</script>
<script src="/Public/Default/aceadmin/js/jquery.uploadify.min.js"></script>
<script src="/Public/Default/aceadmin/js/dialog.js"></script>
<script src="/Public/Default/aceadmin/js/admin_common.js?v=0.1"></script>
<script src="/Public/Default/aceadmin/js/admin_image.js"></script>
<script src="/Public/Default/aceadmin/js/masonry.pkgd.min.js"></script>
<script src="/Public/Default/aceadmin/js/jquery.dragsort-0.5.2.min.js"></script>
<script>
	$(document).ready(function(e) {
		//获取图文
		$(".MsgSend_media_box").delegate(".jsMsgSenderPopBt","click",function(){
			 $.WeiPHP.openSelectAppMsg('<?php echo U("MaterialNews/material_data");?>',selectMnewsCallback);
		});
		$(".MsgSend_media_box_image").delegate(".jsMsgSenderPopBt_image","click",function(){
			 $.WeiPHP.openSelectAppMsgImage('<?php echo U("MaterialOther/material_data",array("type"=>"image"));?>',selectImageCallback);
		});
	});
</script>
</html>