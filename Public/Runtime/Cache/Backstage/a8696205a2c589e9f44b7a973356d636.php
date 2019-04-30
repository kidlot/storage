<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>自定义菜单</title>
	<style>
	li{
		color: #000000;
	}
	</style>
	<script type="text/javascript">
        //下面用于图片上传预览功能
        function setImagePreview(avalue) {
            var docObj=document.getElementById("doc");
            var imgObjPreview=document.getElementById("preview");
            if(docObj.files &&docObj.files[0])
            {
//火狐下，直接设img属性
                imgObjPreview.style.display = 'inline-block';
                imgObjPreview.style.width = '80px';
                imgObjPreview.style.height = '80px';
//imgObjPreview.src = docObj.files[0].getAsDataURL();

//火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
                imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
                console.log(docObj.value);
                $(".MsgSend_media_box").eq(1).hide();
                $(".img_p_div").show();
            }
            else
            {
//IE下，使用滤镜
                docObj.select();
//var imgSrc = document.selection.createRange().text;
                var localImagId = document.getElementById("localImag");
//必须设置初始大小
                localImagId.style.width = "80px";
                localImagId.style.height = "80px";
//图片异常的捕捉，防止用户修改后缀来伪造图片
                try{
                    localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                    localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
                }
                catch(e)
                {
                    alert("您上传的图片格式不正确，请重新选择!");
                    return false;
                }
                imgObjPreview.style.display = 'none';
                document.selection.empty();
            }
            return true;
        }

    </script>
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
<link href="/Public/Default/aceadmin/wx/customMenu/css/bootstrap.min.css" rel="stylesheet"/>
<link href="/Public/Default/aceadmin/wx/customMenu/css/demo.css" rel="stylesheet"/>
<link href="/Public/Default/aceadmin/wx/customMenu/css/font-awesome.min.css" rel="stylesheet"/>
<link href="/Public/Default/aceadmin/wx/customMenu/css/meezao.css?v=1" rel="stylesheet"/>
<link href="/Public/Default/aceadmin/wx/customMenu/css/base.css" rel="stylesheet"/>
<link href="/Public/Default/aceadmin/wx/customMenu/css/d_menu.css" rel="stylesheet"/>
<link href="/Public/Default/aceadmin/wx/customMenu/css/pic.css" rel="stylesheet"/>
<link rel="stylesheet" href="/Public/Default/aceadmin/wx/css/base.css">
<link rel="stylesheet" href="/Public/Default/aceadmin/wx/css/module.css?v=0.2">
<link rel="stylesheet" href="/Public/Default/aceadmin/wx/css/weiphp.css?v=1.1">

<div class="clear"></div>

<div class="wrp">
    <div class="content">
        <div class="main_content">
            <div class="main_content_mb">
                <div class="menu_setting_box" style="background: #ffffff;">
				<div class="page_msg">
                        <p>菜单编辑中</p>
						 <p>可添加最多3个一级菜单，每个一级菜单可添加最多5个子菜单</p>
						<div class="c_s_box">菜单未发布，可点击同步到手机。
							<input id="getnewmenu" class="btn btn-success" style="background: #9a4e41;" type="button" value="获取当前菜单" />
							<input id="upload" class="btn btn-success" type="button" value="保存并发布" />
						</div>
						
                    </div>
                    <div class="menu_preview_area" style="background: #ffffff;">
                        <div class="mobile_menu_preview">
                            <div class="mobile_hd tc"><?php echo ($title); ?></div>
                            <div class="mobile_bd">
                                <ul class="pre_menu_list" id="menuList">
									<?php if(empty($_list)): ?><li class="js_addMenuBox pre_menu_item add_menu1 current">
											<a href="javascript:void(0);" class="pre_menu_link" title="添加菜单" draggable="false">
												<i class="icon16_common add_gray"></i><span>添加菜单</span>
											</a>
										</li>
									<?php else: ?> 
										<?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i; switch($_listcount): case "1": ?><li class="jsMenu pre_menu_item jslevel1 size1of2 " id="z_m_<?php echo ($list['uid']); ?>"><?php break;?>
												<?php default: ?><li class="jsMenu pre_menu_item jslevel1 size1of3 " id="z_m_<?php echo ($list['uid']); ?>"><?php endswitch;?>
											<a href="javascript:void(0);" class="pre_menu_link" draggable="false">
												<i class="icon_menu_dot js_icon_menu_dot dn" style="display: none;"></i>
												<i class="icon20_common sort_gray"></i>
												<span class="js_l1Title"><?php if(empty($list['zhu_name'])): ?>菜单名称<?php else: echo ($list['zhu_name']); endif; ?></span>
											</a>
											<div class="sub_pre_menu_box" style="display: none">
												<ul class="sub_pre_menu_list">
													<?php if(is_array($list['list'])): $i = 0; $__LIST__ = $list['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="jslevel2" id="j_m_<?php echo ($list['uid']); ?>_<?php echo ($vo['uid']); ?>">
															<a href="javascript:void(0);" class="jsSubView" draggable="false">
															 <span class="sub_pre_menu_inner js_sub_pre_menu_inner">
																<i class="icon20_common sort_gray"></i>
																<span class="js_l2Title"><?php if(empty($vo['zi_name'])): ?>子菜单名称<?php else: echo ($vo['zi_name']); endif; ?></span>
															</span>
															</a>
														</li><?php endforeach; endif; else: echo "" ;endif; ?>
													<li class="js_addMenuBox add_menu2">
														<a href="javascript:void(0);" class="jsSubView" title="添加子菜单" draggable="false"><span class="sub_pre_menu_inner js_sub_pre_menu_inner"><i class="icon16_common add_gray"></i></span></a>
													</li>
												</ul>
												<i class="arrow arrow_out"></i>
												<i class="arrow arrow_in"></i>
											</div>
										</li><?php endforeach; endif; else: echo "" ;endif; ?>
										<li class="js_addMenuBox pre_menu_item add_menu1">
											<a href="javascript:void(0);" class="pre_menu_link" title="添加菜单" draggable="false">
												<i class="icon16_common add_gray"></i>
											</a>
										</li><?php endif; ?> 
									
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="menu_form_area">
                        <!----------------删除菜单的时候显示--------------------->
                        <div id="js_none" class="menu_initial_tips tips_global" style="display: none;">点击左侧菜单进行编辑操作</div>
                        <div id="js_rightBox" class="portable_editor to_left">
                            <div class="editor_inner">
                                <div class="global_mod float_layout menu_form_hd js_second_title_bar">
                                    <h4 class="global_info">
                                        菜单名称
                                    </h4>
                                    <div class="global_extra">
                                        <a href="javascript:void(0);" id="jsDelBt" data-toggle="modal" data-target="#myModal_del">删除菜单</a>
                                    </div>
                                </div>
                                <div class="menu_form_bd" id="view">
                                    <div id="js_innerNone" style="display: none;padding-top:10px;" class="msg_sender_tips tips_global">已添加子菜单，仅可设置菜单名称。</div>
                                    <div class="frm_control_group js_setNameBox">
                                        <label for="" class="frm_label">
                                            <strong class="title js_menuTitle">菜单名称</strong>
                                        </label>
                                        <div class="frm_controls">
                                     <span class="frm_input_box with_counter counter_in append">
                                        <input type="text" class="frm_input js_menu_name">
                                     </span>
                                            <p class="frm_msg fail js_titleEorTips" style="display: none;">字数超过上限</p>
                                            <p class="frm_msg fail js_titlenoTips" style="display: none;">请输入菜单名称</p>
                                            <p class="frm_tips js_titleNolTips">字数不超过4个汉字或8个字母</p>
                                        </div>
                                    </div>
                                    <!---------------------子菜单----------------------->
                                    <div class="frm_control_group" style="display: block;">
                                        <label for="" class="frm_label">
                                            <strong class="title js_menuContent">菜单内容</strong>
                                        </label>
                                        <div class="frm_controls frm_vertical_pt">
                                            <label class="frm_radio_label js_radio_sendMsg selected js_radio" id="js_sendMsg" type="s_mess">
                                                <i class="icon_radio"></i>
                                                <span class="lbl_content">发送消息</span>
                                                <input type="radio" name="s_mess" class="frm_radio" checked="checked">
                                            </label>
                                            <label class="frm_radio_label js_radio_url js_radio" id="js_url" type="s_web">
                                                <i class="icon_radio"></i>
                                                <span class="lbl_content">跳转网页</span>
                                                <input type="radio" name="j_web" class="frm_radio">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="menu_content_container">
                                        <div  class="menu_content send jsMain" id="edit">
                                            <div class="msg_sender" id="editDiv">
                                                <div class="msg_tab">
                                                    <div class="tab_navs_panel">
                                                        <div class="tab_navs_wrp">
                                                            <ul class="tab_navs js_tab_navs">
                                                                <li class="tab_nav tab_appmsg selected" data-tooltip="图文消息">
                                                                    <a href="javascript:void(0);">&nbsp;<i class="icon_msg_sender"></i><span class="msg_tab_title">图文消息</span></a>
                                                                </li>
                                                                <li class="tab_nav tab_text " data-tooltip="文字">
                                                                    <a href="javascript:void(0);">&nbsp;<i class="icon_msg_sender"></i><span class="msg_tab_title">文字</span></a>
                                                                </li>
                                                                <li class="tab_nav tab_img tab_image"  data-tooltip="图片">
                                                                    <a href="javascript:void(0);">&nbsp;<i class="icon_msg_sender"></i><span class="msg_tab_title">图片</span></a>
                                                                </li>
                                                                <!--<li class="tab_nav tab_cardmsg" id="cardmsg" data-tooltip="卡券"  data-toggle="modal" data-target="#myModal">
                                                                    <a href="javascript:void(0);">&nbsp;<i class="icon_msg_sender"></i><span class="msg_tab_title">卡券</span></a>
                                                                </li>-->
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
																		  <span class="create_access">
																			 <a class="add_gray_wrp jsMsgSenderPopBt" href="javascript:;" data-toggle="modal" data-target="#myModal_sucai">
																				 <i class="icon36_common add_gray"></i>
																				 <strong>从素材库中选择</strong>
																			 </a>
																		  </span>
                                                                        </div>
                                                                        <div class="media_cover">
																		  <span class="create_access">
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
                                                                    <div class="edit_area js_editorArea" contenteditable="true"></div>
                                                                    <div class="editor_toolbar">
                                                                        <a href="javascript:;" class="btn btn-primary" style="float:right; margin-left:10px; margin-top:6px;" id="save_text">保存</a>
                                                                        <p class="editor_tip js_editorTip"><span style="color: red">这个是cilck事件的key，不是回复文字[文字中加入“[text]”可以回复文字]</span>还可以输入<em>600</em>字</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
														<div class="tab_content" style="display:none">
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
                                                        <!--<div class="tab_content" style="display: none;">
                                                            <div class="js_imgArea inner ">
                                                                <div class="tab_cont_cover jsMsgSendTab" >
                                                                    <div class="MsgSend_media_box">
                                                                        <div class="media_cover">
																		 <span class="create_access">
																			<a class="add_gray_wrp jsMsgSenderPopBt" href="javascript:;" data-toggle="modal" data-target="#myModal_sucai" onclick="getMorePic();">
																				<i class="icon36_common add_gray"></i>
																				<strong>从素材库中选择</strong>
																			</a>
																		  </span>
                                                                        </div>
                                                                        <div class="media_cover">
																			<span class="create_access webuploader-container">
																				<a class="add_gray_wrp webuploader-pick"  href="javascript:;">
																					<i class="icon36_common add_gray"></i>
																					<strong>上传图片</strong>
																				</a>
																			   <div style="position: absolute; top: 42px; left: 78.5px; width: 56px; height: 58px; overflow: hidden; bottom: auto; right: auto;"><input type="file" id="doc" style="opacity:0;" onchange="javascript:setImagePreview();">
																			   </div>
																			</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="MsgSend_box" style="display:none"><a href="#none" class="del_MsgSend">删除</a></div>
                                                                    <div class="img_p_div" style="display:none;"><img id="preview" src=""><a href="#none" class="del_img" style="vertical-align:bottom;margin-left:20px;">删除</a></div>
                                                                </div>

                                                            </div>
                                                        </div>-->
														
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu_content url jsMain" style="display:none;">
                                            <form action="#" id="urlForm" method="post">
                                                <p class="menu_content_tips tips_global">订阅者点击该子菜单会跳到以下链接</p>
                                                <div class="frm_control_group">
                                                    <label for="" class="frm_label">页面地址</label>
                                                    <div class="frm_controls">
                                                <span class="frm_input_box">
                                                    <input type="text" class="frm_input" id="urlText" name="urlText">
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="frm_control_group btn_appmsg_wrap">
                                                    <div class="frm_controls">
                                                        <p class="frm_msg fail dn" id="urlUnSelect" style="display: none;">
                                                            <span for="urlText" class="frm_msg_content" style="display: inline;">请选择一篇文章</span>
                                                        </p>
                                                        <!--<a href="javascript:;" id="js_appmsgPop">从公众号图文消息中选择</a>
                                                        <a href="javascript:void(0);" class="dn btn btn_default" id="js_reChangeAppmsg" style="display: none;">重新选择</a>-->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
										
                                    </div>
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
                    <p style="color:#8d8d8d">删除后"菜单名称"菜单下设置的内容将被删除</p>
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

<script src="/Public/Default/aceadmin/wx/customMenu/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Default/aceadmin/wx/customMenu/js/bootstrap.min.js"></script>
<script src="/Public/Default/aceadmin/wx/customMenu/js/meezao.js"></script>
<script src="/Public/Default/aceadmin/wx/customMenu/js/d_menu.js?v=3.7"></script>
<script>
	var IMG_PATH = "/Public/Default/aceadmin/wx/images";
	var STATIC = "/Public/Default/aceadmin/js";
	var ROOT = "";
	var go = 1;
</script>
<script src="/Public/Default/aceadmin/js/jquery.uploadify.min.js"></script>
<script src="/Public/Default/aceadmin/js/dialog.js"></script>
<script src="/Public/Default/aceadmin/js/admin_common.js?v=0.1"></script>
<script src="/Public/Default/aceadmin/js/admin_image.js"></script>
<script src="/Public/Default/aceadmin/js/masonry.pkgd.min.js"></script>
<script src="/Public/Default/aceadmin/js/jquery.dragsort-0.5.2.min.js"></script>

<script>
    $(document).ready(function(){
		//获取图文
		$(".MsgSend_media_box").delegate(".jsMsgSenderPopBt","click",function(){
			 $.WeiPHP.openSelectAppMsg('<?php echo U("MaterialNews/material_data");?>',selectMnewsCallback);
		});
		$(".MsgSend_media_box_image").delegate(".jsMsgSenderPopBt_image","click",function(){
			 $.WeiPHP.openSelectAppMsgImage('<?php echo U("MaterialOther/material_data",array("type"=>"image"));?>',selectImageCallback);
		});
        /*保存并发布*/
        $("#upload").click(function(){
            /*ajax发送相关数据*/
			var top_alert = $('#top-alert');
            $.ajax({
                type: "POST",
                url: "<?php echo U('createMenu');?>",
                data: {},
                dataType: "json",
                success: function (data){
					if(data.status == 1){
						updateAlert(data.info, 'alert-success');
					}
					else{
						updateAlert(data.info);
					}
					
                },
				error: function (data){console.log(data);
					updateAlert(data.info);
                },
            });
        });
		 /*保存并发布*/
        $("#getnewmenu").click(function(){
            /*ajax发送相关数据*/
			var top_alert = $('#top-alert');
            $.ajax({
                type: "POST",
                url: "<?php echo U('getNewMenu');?>",
                data: {},
                dataType: "json",
                success: function (data){
					if(data.status == 1){
						updateAlert(data.info, 'alert-success');
					}
					else{
						updateAlert(data.info);
					}
					window.location.reload();
                },
				error: function (data){console.log(data);
					updateAlert(data.info);
                },
            });
        });
    })
</script>

</html>