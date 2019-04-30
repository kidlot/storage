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
	var UPLOAD_PICTURE = "<?php echo U('File/uploadPicture');?>";
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
			<li <?php if(empty($main)): ?>class="active"<?php endif; ?> >
				<a href="#list" data-toggle="tab">列 表</a>
			</li>
			<li <?php if(!empty($main)): ?>class="active"<?php endif; ?> >
				<a href="#add" data-toggle="tab">新 增</a>
			</li>
			<li>
				<a href="<?php echo U('syc_news_from_wechat');?>">一键下载微信素材库到本地</a>
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
			<div id="list" class="tab-pane <?php if(empty($main)): ?>in active<?php endif; ?>" style="float: none">
				<!-- 数据列表 -->
<style>
.appmsg_action a{
	color:black;
	text-decoration: none;
}
</style>
<div class="table-striped">
	<ul class="material_list js-masonry" data-masonry-options='{ "itemSelector": ".appmsg_li", "columWidth": 308 }'>
	<?php if(is_array($list_data)): $i = 0; $__LIST__ = $list_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i; if($list['count']==1): ?><!-- 单图文 -->
			<li class="appmsg_li">
				<div class="appmsg_item">
					<h6 class="ellipsis"><?php echo ($list["title"]); ?></h6>
					<p class="title"><?php echo (time_format($list["cTime"])); ?></p>
					<div class="main_img">
						<a href="<?php echo ($list["url"]); ?>" target="_blank"><img src="<?php echo (get_cover_url($list["cover_id"])); ?>"/></a>
					</div>
					<p class="desc ellipsis"><?php echo (json_decode($list["intro"])); ?></p>
				</div>
				<div class="appmsg_action">
					<a href="<?php echo U('index', array('group_id'=>$list[group_id]));?>">编辑</a>
					<a href="javascript:if(confirm('确定删除？'))location='<?php echo U('del_material_by_groupid', array('group_id'=>$list[group_id]));?>'">删除</a>
				</div>
			</li>
		<?php else: ?>
			<!-- 多图文 -->
			<li class="appmsg_li">
				<div class="appmsg_item">
					<p class="title"><?php echo (time_format($list["cTime"])); ?></p>
					<div class="main_img">
						<a href="<?php echo ($list["url"]); ?>" target="_blank"><img src="<?php echo (get_cover_url($list["cover_id"])); ?>"/></a>
						<h6><?php echo ($list["title"]); ?></h6>
					</div>
					<p class="desc ellipsis"><?php echo (json_decode($list["intro"])); ?></p>
				</div>
				<?php if(is_array($list["child"])): $i = 0; $__LIST__ = $list["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><div class="appmsg_sub_item">
					<p class="title ellipsis"><?php echo ($vv["title"]); ?></p>
					<div class="main_img">
						<a href="<?php echo ($vv["url"]); ?>" target="_blank"><img src="<?php echo (get_cover_url($vv["cover_id"])); ?>"/></a>
					</div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="appmsg_action">
					<a href="<?php echo U('index', array('group_id'=>$list['group_id']));?>">编辑</a>
					<a href="javascript:if(confirm('确定删除？'))location='<?php echo U('del_material_by_groupid', array('group_id'=>$list[group_id]));?>'">删除</a>
				</div>
			</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>
<div class="page"> <?php echo ((isset($_page) && ($_page !== ""))?($_page):''); ?> </div>

			</div>
			<div id="add" class="tab-pane <?php if(!empty($main)): ?>in active<?php endif; ?>">
				<div class="tab-content"> 
  <h3>新建图文消息</h3>
  <!-- 表单 -->
  <div id="form" action="<?php echo U('doAdd', array('group_id'=>$group_id));?>" class="form-horizontal form-center">
	<div class="material_form">
		<div class="preview_area">
			<?php if(empty($main)): ?><form data-index='0' class="appmsg_item edit_item editing">
					<p class="time">时间</p>
					<div class="main_img">
						<img src="/Public/Default/aceadmin/wx/images/no_cover_pic.png" data-coverid="0"/>
						<h6 class="title">这是标题</h6>
					</div>
					<p class="intro"></p>
					 <input type="hidden" name="title" placeholder="这是标题" />
					  <input type="hidden" name="cover_id" value="0"/>
					<input type="hidden" name="intro" placeholder="这是摘要描述"/>
					<input type="hidden" name="author" placeholder="作者"/>
					<input type="hidden" name="link" placeholder="外链"/>
					<textarea style="display:none" name="content"></textarea>
					<div class="hover_area"><a href="javascript:;" onClick="editItem(this)">编辑</a></div>
				</form>
				<?php else: ?>
				  <form data-index='0' class="appmsg_item edit_item editing">
					<p class="time"><?php echo (time_format($main["cTime"])); ?></p>
					<div class="main_img">
						<img src="<?php echo (get_cover_url($main["cover_id"])); ?>" data-coverid="<?php echo (intval($main["cover_id"])); ?>"/>
						<h6 class="title"><?php echo ($main["title"]); ?></h6>
					</div>
					<p class="intro"><?php echo (json_decode($main["intro"])); ?></p>
					<input type="hidden" name="id" value="<?php echo ($main["id"]); ?>"/>
					 <input type="hidden" name="title" value="<?php echo ($main["title"]); ?>" />
					  <input type="hidden" name="cover_id" value="<?php echo ($main["cover_id"]); ?>"/>
					<input type="hidden" name="intro" value="<?php echo (json_decode($main["intro"])); ?>"/>
					<input type="hidden" name="author" value="<?php echo ($main["author"]); ?>"/>
					<input type="hidden" name="link" value="<?php echo ($main["link"]); ?>"/>
					<div class="hover_area"><a href="javascript:;" onClick="editItem(this)">编辑</a></div>
				</form>
				<?php if(is_array($others)): $i = 0; $__LIST__ = $others;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><form data-index='<?php echo ($key); ?>' class="appmsg_sub_item edit_item">
					<p class="title"><?php echo ($vo["title"]); ?></p>
					<div class="main_img">
						<img src="<?php echo (get_cover_url($vo["cover_id"])); ?>" data-coverid="<?php echo (get_cover_url($vo["cover_id"])); ?>"/>
					</div>
					<input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>"/>
					 <input type="hidden" name="title" value="<?php echo ($vo["title"]); ?>"/>
					<input type="hidden" name="cover_id" value="<?php echo ($vo["cover_id"]); ?>"/>
					<input type="hidden" name="intro" value="<?php echo (json_decode($vo["intro"])); ?>"/>
					<input type="hidden" name="author" value="<?php echo ($vo["author"]); ?>"/>
					<input type="hidden" name="link" value="<?php echo ($vo["link"]); ?>"/>
					<div class="hover_area"><a href="javascript:;" onClick="editItem(this)">编辑</a><a href="javascript:;" onClick="deleteItem(this)">删除</a></div>
				</form><?php endforeach; endif; else: echo "" ;endif; endif; ?>
			<div class="appmsg_edit_action">
				<a href="javascript:;" onClick="addMsg();">添加</a>
			</div>
		</div>
		<div class="edit_area">
			<em class="area_arrow"></em>
			<div class="">
				<ul class="tab-pane in appmsg_edit_group">
					<li class="form-item cf">
						<label class="item-label"><span class="need_flag">*</span>标题<span class="check-tips"></span></label>
						<div class="controls">
						  <input type="text" class="text input-large" name="p_title" value="">
						</div>
					  </li>  
					  <li class="form-item cf">
						<label class="item-label">作者<span class="check-tips"></span></label>
						<div class="controls">
						  <input type="text" class="text input-large" name="p_author" value="">
						</div>
					  </li>  
					  <li class="form-item cf">
							<label class="item-label"><span class="need_flag">*</span>封面图片<span class="check-tips">图片<span class="picSize">900X500</span></span></label>
							<div class="controls uploadrow2" data-max="1" title="点击修改图片" rel="p_cover">
								<input type="file" id="upload_picture_p_cover">
								<input type="hidden" name="p_cover" id="cover_id_p_cover" data-callback="uploadImgCallback" value=""/>
								<div class="upload-img-box" rel="img" style="display:none">
								  <div class="upload-pre-item2"><img width="100" height="100" src=""/></div>
									<em class="edit_img_icon">&nbsp;</em>
								</div>
						  </div>
					  </li>
					  <li class="form-item cf">
							<label class="item-label">摘要<span class="check-tips"></span></label>
							<div class="controls">
							  <label class="textarea input-large">
							  <textarea class="text input-large" name="p_intro" ></textarea>
							  </label>
							</div>
					   </li>   
						<li class="form-item cf">
						<label class="item-label">外链<span class="check-tips"></span></label>
						<div class="controls">
						  <input type="text" class="text input-large" name="p_link" value="">
						</div>
					  </li>  
			  </ul>
			</div>
		</div>
	</div>
	<div class="form-item form_bh">
	  <button class="btn submit-btn ajax-post" id="submit" type="button"><?php echo ((isset($submit_name) && ($submit_name !== ""))?($submit_name):'确 定'); ?></button>
	</div>
  </div>
</div>
    
  </section>
  <script src="/Public/Default/aceadmin/js/jquery.uploadify.min.js"></script>
<script src="/Public/Default/aceadmin/js/dialog.js"></script>
<script src="/Public/Default/aceadmin/js/admin_common.js?v=0.1"></script>
<script src="/Public/Default/aceadmin/js/admin_image.js"></script>
<script src="/Public/Default/aceadmin/js/masonry.pkgd.min.js"></script>
<script src="/Public/Default/aceadmin/js/jquery.dragsort-0.5.2.min.js"></script>
<script type="text/javascript">
$('#submit').click(function(){
    var postUrl = $('#form').attr('action');
	var dataJson = [];
	$('.edit_item').each(function(index, element) {
        dataJson.push($(this).serializeArray());
    });
	$(this).addClass('disabled');
	//console.log(dataJson);
	//console.log(JSON.stringify(dataJson));
	//提交数组字符串 php解析后进行保存
	$.post(postUrl,{'dataStr':JSON.stringify(dataJson)},function(data){
		$('#submit').removeClass('disabled');
		if(data.status==1){
			updateAlert(data.info,'success');
			setTimeout(function(){
				  location.href=data.url;
			},1500);
		}else{
			updateAlert(data.info);
		}
	})
	return false;
});
$(function(){
	//初始化上传图片插件
	initUploadImg();

    showTab();
	
	$('.toggle-data').each(function(){
		var data = $(this).attr('toggle-data');
		if(data=='') return true;		
		
	     if($(this).is(":selected") || $(this).is(":checked")){
			 change_event(this)
		 }
	});
	
	$('select').change(function(){
		$('.toggle-data').each(function(){
			var data = $(this).attr('toggle-data');
			if(data=='') return true;		
			
			 if($(this).is(":selected") || $(this).is(":checked")){
				 change_event(this)
			 }
		});
	});
	
	//动态预览
	$('input[name="p_title"]').keyup(function(){
		$('.editing').find('.title').text($(this).val());
		$('.editing').find('input[name="title"]').val($(this).val());
	});
	$('input[name="p_author"]').keyup(function(){
		$('.editing').find('.author').text($(this).val());
		$('.editing').find('input[name="author"]').val($(this).val());
	});
	$('input[name="p_link"]').keyup(function(){
		$('.editing').find('.link').text($(this).val());
		$('.editing').find('input[name="link"]').val($(this).val());
	});
	$('textarea[name="p_intro"]').keyup(function(){
		$('.editing').find('.intro').text($(this).val());
		$('.editing').find('input[name="intro"]').val($(this).val());
	});
	
	
	 initForm($('.edit_item').eq(0));
	
	
});
function addMsg(){
	var curCount = $('.edit_item').size();
	if(curCount>=8){
		updateAlert('你最多只可以增加8条图文信息');
		return false;
	}
	$('.picSize').text('200X200');
	//console.log(curCount);
	var addHtml = $('<form data-index="'+curCount+'" class="appmsg_sub_item edit_item">'+
                    '<p class="title"></p>'+
                    '<div class="main_img">'+
                        '<img src="/Public/Default/aceadmin/wx/images/no_cover_pic_s.png" data-coverid="0"/>'+
                    '</div>'+
                    '<input type="hidden" name="title" placeholder="这是标题"/>'+
                    '<input type="hidden" name="cover_id" value="0"/>'+
                    '<input type="hidden" name="intro" placeholder="这是摘要描述"/>'+
                    '<input type="hidden" name="author" placeholder="作者"/>'+
                    '<input type="hidden" name="link" placeholder="外链"/>'+
                    '<div class="hover_area"><a href="javascript:;" onClick="editItem(this)">编辑</a><a href="javascript:;" onClick="deleteItem(this)">删除</a></div>'+
                '</form>');
	addHtml.insertBefore($('.appmsg_edit_action'));
}
function editItem(_this){
	$(_this).parents('.edit_item').addClass('editing');
	$(_this).parents('.edit_item').siblings().removeClass('editing');
	var index = $(_this).parents('.edit_item').data('index');
	if(index==0){
		$('.picSize').text('900X500');
		$('.edit_area').css('margin-top',0);
	}else{
		$('.picSize').text('200X200');
		$('.edit_area').css('margin-top',index*110+120);
	}
	initForm($(_this).parents('.edit_item'));
}
function deleteItem(_this){
	if(!confirm('确认删除？')) return false;
	
	var item_id = $(_this).parents('.edit_item').find('input[name="id"]').val();
	if(item_id){
		$.post("<?php echo U('del_material_by_id');?>",{id:item_id});
	}
	
	$(_this).parents('.edit_item').remove();
	var curCount = $('.edit_item').size();
	if(curCount==1){
		$('.edit_area').css('margin-top',0);
	}else{
		$('.edit_area').css('margin-top',(curCount-1)*110+120);
	}
	initForm($('.edit_item').eq(curCount-1));
}
function uploadImgCallback(name,id,src){
	$('.editing img').attr('src',src);
	$('.editing input[name="cover_id"]').val(id);
}
function initForm(_item){
	var title = $(_item).find('input[name="title"]').val();
	var author = $(_item).find('input[name="author"]').val();
	var link = $(_item).find('input[name="link"]').val();
	var intro = $(_item).find('input[name="intro"]').val();
	var src = $(_item).find('img').attr('src');
	$('input[name="p_title"]').val(title);
	$('input[name="p_author"]').val(author);
	$('input[name="p_link"]').val(link);
	$('textarea[name="p_intro"]').val(intro);
	$('.upload-img-box').show().find('img').attr('src',src);
}
</script> 
			</div>
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