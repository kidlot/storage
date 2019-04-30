<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>修改管理员 - bjyadmin</title>
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
         <a href="<?php echo U('AdminUser/index');?>">管理员列表</a>
   </li>
   <li class="active">
        <a href="<?php echo U('AdminUser/edit');?>">修改管理员</a>
    </li>
</ul>
<form class="form-inline" method="post">
    <input type="hidden" name="id" value="<?php echo ($user_data['id']); ?>">
    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
            <th>管理组</th>
            <td>
                <?php if(is_array($data)): foreach($data as $key=>$v): echo ($v['title']); ?>
                    <input class="xb-icheck" type="checkbox" name="group_ids[]" value="<?php echo ($v['id']); ?>" <?php if(in_array(($v['id']), is_array($group_data)?$group_data:explode(',',$group_data))): ?>checked="checked"<?php endif; ?> >
                    &emsp;<?php endforeach; endif; ?>
            </td>
        </tr>
        <tr>
            <th>用户名</th>
            <td>
                <?php echo ($user_data['username']); ?>
            </td>
        </tr>
        <tr>
            <th>手机号</th>
            <td>
                <input class="form-control" type="text" name="phone" value="<?php echo ($user_data['phone']); ?>">
            </td>
        </tr>
        <tr>
            <th>邮箱</th>
            <td>
                <input class="form-control" type="text" name="email" value="<?php echo ($user_data['email']); ?>">
            </td>
        </tr>
        <tr>
            <th>密码</th>
            <td>
                <input class="form-control" type="text" name="password">如不改密码；留空即可
            </td>
        </tr>
        <tr>
            <th>状态</th>
            <td>
                <span class="inputword">允许登录</span>
                <input class="xb-icheck" type="radio" name="status" value="1" <?php if(($user_data['status']) == "1"): ?>checked="checked"<?php endif; ?> >
                &emsp;
                <span class="inputword">禁止登录</span>
                <input class="xb-icheck" type="radio" name="status" value="0" <?php if(($user_data['status']) == "0"): ?>checked="checked"<?php endif; ?> >
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <input class="btn btn-success" type="submit" value="修改">
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
<script src="/Public/Default/statics/iCheck-1.0.2/icheck.min.js"></script>
<script>
$(document).ready(function(){
    $('.xb-icheck').iCheck({
        checkboxClass: "icheckbox_minimal-blue",
        radioClass: "iradio_minimal-blue",
        increaseArea: "20%"
    });
});
</script>
</body>
</html>