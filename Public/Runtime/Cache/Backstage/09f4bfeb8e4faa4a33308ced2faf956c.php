<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>debug</title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/Default/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/Public/Default/statics/css/base.css" />
    <link rel="stylesheet" href="/Public/Default/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/Public/Default/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="/Public/Default/statics/iCheck-1.0.2/skins/all.css">
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
<ul id="myTab" class="nav nav-tabs">
   <li>
		<a href="<?php echo U('index');?>">debug</a>
   </li>
</ul>
<div style='color: #282de8;font-size: 30px;margin-left: 400px;'>模式【<?php if($_level == 1): ?>请求链接自定义<?php elseif($_level == 2): ?>微信接口<?php else: ?>CRM接口<?php endif; ?>】</div>
<form class="form-inline" method="post" id="form">
    <table class="table table-striped table-bordered table-hover table-condensed">
		<tr>
			<th>请求方法</th>
			<td>
			<?php if(($_level == 2) OR ($_level == 3)): ?><select name="method">
					<?php if(is_array($_data)): $i = 0; $__LIST__ = $_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><option value="<?php echo ($data['method']); ?>"><?php echo ($data['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			<?php else: ?>
				<textarea class="form-control" name="method" rows="3" cols="150"></textarea><?php endif; ?>
			</td>
		</tr>
		<tr>
            <th>参数json</th>
			<td>
			   <textarea class="form-control" name="parameter" rows="20" cols="170"></textarea><a href="https://www.bejson.com" target="_blank">验证json</a>
			</td>
		</tr>
		<tr>
            <th>结果</th>
			<td>
			   <div class='jg'>这边显示结果</div>
			</td>
		</tr>
        <tr>
            <th></th>
            <td>
                <input class="btn btn-success" type="button" value="执行" id='curl'>
            </td>
        </tr>
    </table>
</form>
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
</body>
<script>
$("#curl").click(function () {
	$.ajax({
		type: "POST",
		url: "<?php echo U('curl');?>",
		data: $("#form").serialize(),
		dataType:'json',
		success: function (data){
			console.log(data);
			if(isJsonString(data)){
				$(".jg").html(data);
			}else{
				$(".jg").html(JSON.stringify(data));
			}
		},
		error: function (data){
			alert('系统出小差啦');
		}
	});
})
function isJsonString(str) {  
	try {  
		if (typeof JSON.parse(str) == "object") {  
			return true;  
		}  
	} catch(e) {  
	}  
	return false;  
}  
</script>
</html>