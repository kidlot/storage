<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<title>字典列表</title>
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
	<li class="active">
		<a href="#home" data-toggle="tab">字典列表</a>
	</li>
	 <li>
		<a href="javascript:;" onclick="add()">添加字典</a>
	</li>
</ul>
<div class="panel panel-default">
    <br />
    <form class="form-inline" method="POST" id="form" action="" >
        <div class="form-group">
            <label >名称</label>
            <input class="input-sm form-control" id="name" value="<?php echo ((isset($_name) && ($_name !== ""))?($_name):''); ?>">
            
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
            <label >类型</label>
            <select class="input-sm form-control" id="type">
                <option value="">请选择</option>
				<?php if(is_array($_typelist)): $i = 0; $__LIST__ = $_typelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["type"]); ?>" <?php if($vo["type"] == $_type): ?>selected<?php endif; ?>><?php echo ($vo["type"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
            <label >启用状态</label>
            <select class="input-sm form-control" id="status">
                <option value="">请选择</option>
				<option value="0" <?php if($_status === '0'): ?>selected<?php endif; ?>>禁用</option>
				<option value="1" <?php if($_status == 1): ?>selected<?php endif; ?>>启用</option>
            </select>
            <button type="button" id="query" class="btn btn-purple btn-sm">
                <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                搜索
            </button>
        </div>
    </form>
    <br />
    <div id="content"></div>
</div>
<div id="myTabContent" class="tab-content">
   <div class="tab-pane fade in active">
		<div class="page"> <?php echo ((isset($_page) && ($_page !== ""))?($_page):''); ?> </div>
		<table class="table table-striped table-bordered table-hover table-condensed">
			<tr>
				<th>id</th>
				<th>类型</th>
				<th>参数</th>
				<th>名称</th>
				<th>额外的参数值</th>
				<th>启用状态</th>
				<th>更新时间</th>
				<th>操作</th>
			</tr>
			<?php if(is_array($_list)): foreach($_list as $key=>$v): ?><tr>
					<td><?php echo ($v['id']); ?></td>
					<td><?php echo ($v['type']); ?></td>
					<td><?php echo ($v['code']); ?></td>
					<td><?php echo ($v['name']); ?></td>
					<td><?php echo ($v['value']); ?></td>
					<td><?php if($v['status'] == 1): ?>启用<?php else: ?>禁用<?php endif; ?></td>
					<td><?php echo ($v['utime']); ?></td>
					<td>
						<a href="javascript:;" dataid="<?php echo ($v['id']); ?>" datatype="<?php echo ($v['type']); ?>" datacode="<?php echo ($v['code']); ?>" dataname="<?php echo ($v['name']); ?>" datavalue="<?php echo ($v['value']); ?>" datastatus="<?php echo ($v['status']); ?>" onclick="edit(this)">修改</a> |
						<a href="javascript:if(confirm('确定删除？'))location='<?php echo U('delete',array('id'=>$v['id']));?>'">删除</a>
					</td>
				</tr><?php endforeach; endif; ?>
		</table>
		<div class="page"> <?php echo ((isset($_page) && ($_page !== ""))?($_page):''); ?> </div>
   </div>
</div>
<!-- 添加菜单模态框开始 -->
<div class="modal fade" id="bjy-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		 <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					添加字典
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('add');?>" method="post">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<tr>
							<th width="15%">类型：</th>
							<td>
								<input class="form-control" type="text" name="type">
							</td>
						</tr>
						<tr>
							<th width="15%">参数：</th>
							<td>
								<input class="form-control" type="text" name="code">
							</td>
						</tr>
						<tr>
							<th width="15%">名称：</th>
							<td>
								<input class="form-control" type="text" name="name">
							</td>
						</tr>
						<tr>
							<th width="20%">额外的参数值：</th>
							<td>
								<input class="form-control" style="width:300px;" type="text" name="value">
							</td>
						</tr>
						<tr>
							<th width="20%">是否启用：</th>
							<td>
								<select class="input-sm form-control" name="status">
									<option value="1">启用</option>
									<option value="0">禁用</option>
								</select>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<input class="btn btn-success" type="submit" value="添加">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- 添加菜单模态框结束 -->
<!-- 修改菜单模态框开始 -->
<div class="modal fade" id="bjy-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		 <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					修改字典
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('edit');?>" method="post">
					<input type="hidden" name="id">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<tr>
							<th width="15%">类型：</th>
							<td>
								<input class="form-control" type="text" name="type">
							</td>
						</tr>
						<tr>
							<th width="15%">参数：</th>
							<td>
								<input class="form-control" type="text" name="code">
							</td>
						</tr>
						<tr>
							<th width="15%">名称：</th>
							<td>
								<input class="form-control" type="text" name="name">
							</td>
						</tr>
						<tr>
							<th width="20%">额外的参数值：</th>
							<td>
								<input class="form-control" style="width:300px;" type="text" name="value">
							</td>
						</tr>
						<tr>
							<th width="20%">是否启用：</th>
							<td>
								<select class="input-sm form-control" name="status">
									<option value="1">启用</option>
									<option value="0">禁用</option>
								</select>
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
			</div>
		</div>
	</div>
</div>
<!-- 修改菜单模态框结束 -->
</body>
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
<script type="text/javascript">
//搜索功能
$("#query").click(function(){
	var name = $('#name').val();
	var status = $('#status').val();
	var type = $('#type').val();
	var url  = "<?php echo U('index');?>?md=1";
	if(name != undefined || name != ""){
		url +="&name=" + name;
	}
	if(status != undefined || status != ""){
		url +="&status=" + status;
	}
	if(type != undefined || type != ""){
		url +="&type=" + type;
	}
	window.location.href = url;
});
function add(){
	$("#bjy-add input[name='type']").val('');
	$("#bjy-add input[name='code']").val('');
	$("#bjy-add input[name='name']").val('');
	$("#bjy-add input[name='value']").val('');
	//$("#bjy-add select[name='status']").val('启用');
	$('#bjy-add').modal('show');
}
function edit(obj){
	$("#bjy-edit input[name='id']").val($(obj).attr('dataid'));
	$("#bjy-edit input[name='type']").val($(obj).attr('datatype'));
	$("#bjy-edit input[name='code']").val($(obj).attr('datacode'));
	$("#bjy-edit input[name='name']").val($(obj).attr('dataname'));
	$("#bjy-edit input[name='value']").val($(obj).attr('datavalue'));
	$("#bjy-edit select[name='status']").val($(obj).attr('datastatus'));
	$('#bjy-edit').modal('show');
}
</script>
</html>