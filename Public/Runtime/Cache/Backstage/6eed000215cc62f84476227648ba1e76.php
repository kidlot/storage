<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>用户组添加用户 - bjyadmin</title>
	<link rel="stylesheet" href="/Public/Default/aceadmin/wx/css/base.css">
<link rel="stylesheet" href="/Public/Default/aceadmin/wx/css/module.css?v=0.2">
<link rel="stylesheet" href="/Public/Default/aceadmin/wx/css/weiphp.css?v=1.1">
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/Default/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/Public/Default/statics/css/base.css" />
    <link rel="stylesheet" href="/Public/Default/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/Public/Default/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
	<!-- 引入bootstrjs部分开始 -->
<script src="/Public/Default/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/Default/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script>
    var xbIsLogin=1,
        xbCheckLoginUrl='<?php echo U('Home/Public/ajax_check_login');?>',
        fwbCheckLoginUrl ="<?php echo U('User/Login/check_login');?>",
        fwbLoginOutUrl="<?php echo U('User/Login/ajax_logout');?>",
        rongUserInfoUrl="<?php echo U('Api/Rong/get_user_info');?>",
        rongKey="",
        rongToken="",
        xbUserInfo = {
            id: "88",
            name: "admin",
            avatar: ""
        };
</script>
<script src="/Public/Default/statics/emoji/js/config.js"></script>
<script src="/Public/Default/statics/emoji/js/emoji-picker.js"></script>
<script src="/Public/Default/statics/emoji/js/jquery.emojiarea.js"></script>
	<script>
	var IMG_PATH = "/Public/Default/aceadmin/wx/images";
	var STATIC = "/Public/Default/aceadmin/js";
	var ROOT = "";
	</script>
</head>
<body>
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

<div class="vspace-6-sm"></div>
<div class="col-sm-12">
	<!-- #section:elements.tab.option -->
	<div class="tabbable">
		<ul class="nav nav-tabs padding-12" id="myTab4" class="fl">
			<li <?php if($_type == 'image'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('index',array('type'=>'image'));?>">图 片 列 表</a>
			</li>
			<li <?php if($_type == 'video'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('index',array('type'=>'video'));?>">视 频 列 表</a>
			</li>
			<li <?php if($_type == 'voice'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('index',array('type'=>'voice'));?>">语 音 列 表</a>
			</li>
			<li>
				<a href="<?php echo U('syc_other_from_wechat');?>">一键下载微信素材库到本地</a>
			</li>
			<!--暂时先不做-->
			<li class="search-form fr cf" style="    position: absolute;right: 4%;">
				<div class="sleft">
					<input type="text" name="title" class="search-input" value="" placeholder="请输入标题">
					<a class="sch-btn" href="javascript:;" id="search" url="<?php echo ($search_url); ?>">
					<i class="btn-search"></i></a>
				</div>
			</li>
		</ul>

		<div class="tab-content">
			<style>
			.appmsg_action a{
				color:black;
				text-decoration: none;
			}
			</style>
			<div class="table-striped">
				<ul class="material_list js-masonry" data-masonry-options='{ "itemSelector": ".appmsg_li", "columWidth": 308 }'>
				<?php if(is_array($list_data)): $i = 0; $__LIST__ = $list_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li class="appmsg_li">
						<div class="appmsg_item">
							<p class="title"><?php echo (time_format($list["update_time"])); ?></p>
							<div class="main_img" style="height: 100%">
								<a href="<?php echo ($list["url"]); ?>" target="_blank">
									<?php if($list["type"] == 'video'): elseif($list["type"] == 'voice'): ?>
										<audio src="" controls="controls">
									<?php else: ?>
										<img src="<?php echo (get_cover_url($list["cover_id"])); ?>"/><?php endif; ?>
								</a>
							</div>
							<p class="desc ellipsis"><?php echo (json_decode($list["name"])); ?></p>
						</div>
						<!--<div class="appmsg_action">
							<a href="#">编辑</a>
							<a href="javascript:if(confirm('确定删除？'))location=''">删除</a>
						</div>-->
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<div class="page"> <?php echo ((isset($_page) && ($_page !== ""))?($_page):''); ?> </div>
		</div>
	</div>

	<!-- /section:elements.tab.option -->
</div><!-- /.col -->
</body>
<script type="text/javascript">
	//搜索功能
    $("#search").click(function(){
        var url = $(this).attr('url');
        var str = $('.search-input').val()
        var query  = 'title='+str.replace(/(^\s*)|(\s*$)/g,"");
        if( url.indexOf('?')>0 ){
            url += '&' + query;
        }else{
            url += '?' + query;
        }
        window.location.href = url;
    });
$(function(){
    //回车自动提交
    $('.search-form').find('input').keyup(function(event){
        if(event.keyCode===13){
            $("#search").click();
        }
    });

})
</script>
</html>