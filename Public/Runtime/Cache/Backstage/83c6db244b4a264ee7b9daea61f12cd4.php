<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<title>商品列表</title>
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
		<a href="#home" data-toggle="tab">商品列表</a>
	</li>
	 <li>
		<a href="javascript:;" onclick="add()">添加商品</a>
	</li>
</ul>
<div class="panel panel-default">
    <br />
    <form class="form-inline" method="POST" id="form" action="/" >
        <div class="form-group">
            <label >商品名称</label>
            <input class="input-sm form-control" id="goods_name" value="<?php echo ((isset($goods_name) && ($goods_name !== ""))?($goods_name):''); ?>">
            
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
            <label >商品货号</label>
			<input class="input-sm form-control" id="goods_sn" value="<?php echo ((isset($goods_sn) && ($goods_sn !== ""))?($goods_sn):''); ?>">		
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;				
            <!--<label >启用状态</label>
            <select class="input-sm form-control" id="status">
                <option value="">请选择</option>
				<option value="0" <?php if($_status === '0'): ?>selected<?php endif; ?>>禁用</option>
				<option value="1" <?php if($_status == 1): ?>selected<?php endif; ?>>启用</option>
			</select>-->
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
				<th>货号</th>
				<th>商品名称</th>
				<th>价格</th>
				<th>创建时间</th>
				<th>更新时间</th>
				<th>操作</th>
			</tr>
			<?php if(is_array($_list)): foreach($_list as $key=>$v): ?><tr>
					<td><?php echo ($v['id']); ?></td>
					<td><?php echo ($v['goods_sn']); ?></td>
					<td><?php echo ($v['goods_name']); ?></td>
					<td><?php echo ($v['price']); ?></td>
					<td><?php echo ($v['create_time']); ?></td>
					<td><?php echo ($v['update_time']); ?></td>
					<td>
						<a href="javascript:;" dataid="<?php echo ($v['id']); ?>" datagoods_sn="<?php echo ($v['goods_sn']); ?>" dataprice="<?php echo ($v['price']); ?>" datagoods_name="<?php echo ($v['goods_name']); ?>"  onclick="edit(this)">修改</a> |
						<a href="javascript:if(confirm('确定删除？'))location='<?php echo U('delete',array('goods_sn'=>$v['goods_sn']));?>'">删除</a>
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
					添加商品
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('add');?>" method="post">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<tr>
							<th width="15%">货号：</th>
							<td>
								<input class="form-control" type="text" name="goods_sn">
							</td>
						</tr>
						<tr>
							<th width="15%">商品名称：</th>
							<td>
								<input class="form-control" type="text" name="goods_name">
							</td>
						</tr>						
						<tr>
							<th width="15%">价格：</th>
							<td>
								<input class="form-control" type="text" name="price">
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
					修改库存
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('edit');?>" method="post">
					<input type="hidden" name="id">
					<table class="table table-striped table-bordered table-hover table-condensed">
						
						
						<tr>
							<th width="15%">商品货号：</th>
							<td>
								<input class="form-control" type="text" name="goods_sn">
							</td>
						</tr>
						<tr>
							<th width="15%">商品名称：</th>
							<td>
								<input class="form-control" type="text" name="goods_name">
							</td>
						</tr>
						
						<tr>
							<th width="15%">价格：</th>
							<td>
								<input class="form-control" type="text" name="price">
							</td>
						</tr>
						<tr>

								<td>
									<input class="btn btn-primary" type="submit" value="保存" >
								</td>
						</tr>
						<tr style="height:50px">
							

						</tr>
						<tr>
							<th width="15%">规格</th>
							<th width="10%">颜色</th>
							<th width="15%">库存</th>
							<th width="20%">操作</th>
						</tr>					
							
						<!--<tr>
							<th width="20%">是否启用：</th>
							<td>
								<select class="input-sm form-control" name="status">
									<option value="1">启用</option>
									<option value="0">禁用</option>
								</select>
							</td>
						</tr>-->

					</table>
					<tr>
						<th></th>
						<td>
							<input class="btn btn-primary" type="button" value="添加规格" onclick="add_storage()">
						</td>
					</tr>
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
	var goods_name = $('#goods_name').val();
	var goods_sn = $('#goods_sn').val();
	var url  = "<?php echo U('index');?>?md=1";
	if(goods_name != undefined || goods_name != ""){
		url +="&goods_name=" + goods_name;
	}
	if(goods_sn != undefined || goods_sn != ""){
		url +="&goods_sn=" + goods_sn;
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
	$.ajax({
		"url":"get_sku",
		"type":"post",
		"data":{"goods_sn":$(obj).attr('datagoods_sn')},
		"dataType":"json",
		"success":function(data){
			if(0 == data.error_code){
				$("#bjy-edit input[name='goods_sn']").val($(obj).attr('datagoods_sn'));
				$("#bjy-edit input[name='price']").val($(obj).attr('dataprice'));
				$("#bjy-edit input[name='goods_name']").val($(obj).attr('datagoods_name'));
				$("#bjy-edit input[name='id']").val($(obj).attr('dataid'));
				var goods_str = "";
				for (var i = 0 ;i<data.data.length;i++){
					var str = '<tr name = "goods_size_storage"><td style="vertical-align: inherit">'+
						'<span name="block_size">'+data.data[i].size+'</span><input style="display:none;width: 100%;" class="form-control" type="text" name="size" value="'+data.data[i].size+'">'+
						'</td>'+
						'<td style="vertical-align: inherit">'+
						'<span name="block_color">'+data.data[i].color+'</span><input style="display:none;width: 100%;" class="form-control" type="text" name="color" value="'+data.data[i].color+'">'+
						'</td>'+						
						'<td style="vertical-align: inherit">'+
						'<span name="block_storage">'+data.data[i].storage+'</span><input style="display:none;width: 100%;" class="form-control" type="text" name="storage" value="'+data.data[i].storage+'">'+
						'</td>"'+
						'<td style="vertical-align: inherit">'+
						'<input name = "goods_size_id" style="display:none" value="'+data.data[i].id+'"></input><input class="btn btn-success" type="button"  value="修改" onclick="onedit(this)" name="edit_storage"> <input style="display:none" class="btn btn-success" type="button"  value="保存" onclick="save(this)" name="save_storage">|<input class="btn btn-danger" type="button" value="删除" onclick="del(this)" name="del_storage">'+
						'</td><tr>';

					goods_str += str;
				
				}
				$("tr[name='goods_size_storage']").remove();
				$("#bjy-edit form table").append(goods_str);
			}
		}
	})


	

	$('#bjy-edit').modal('show');
}




function onedit(obj){
	$(obj).parents().siblings().children("span[name='block_size']").hide();
	$(obj).parents().siblings().children("span[name='block_color']").hide();
	$(obj).parents().siblings().children("span[name='block_storage']").hide();
	$(obj).parents().siblings().children("input[name='size']").show();
	$(obj).parents().siblings().children("input[name='color']").show();
	$(obj).parents().siblings().children("input[name='storage']").show();
	$(obj).hide();
	$(obj).parents().children("input[name='save_storage']").show();
}



function save(obj){
	$(obj).parents().siblings().children("span[name='block_size']").show();
	$(obj).parents().siblings().children("span[name='block_color']").show();
	$(obj).parents().siblings().children("span[name='block_storage']").show();
	$(obj).parents().siblings().children("input[name='size']").hide();
	$(obj).parents().siblings().children("input[name='color']").hide();
	$(obj).parents().siblings().children("input[name='storage']").hide();
	$(obj).hide();
	$(obj).parents().children("input[name='edit_storage']").show();
	var size = $(obj).parents().siblings().children("input[name='size']").val();
	var color = $(obj).parents().siblings().children("input[name='color']").hide().val();
	var storage = $(obj).parents().siblings().children("input[name='storage']").hide().val();
	var goods_size_id = $(obj).parents().children("input[name='goods_size_id']").val();
	var goods_sn = $("#bjy-edit input[name='goods_sn']").val();
	$.ajax({
		"url":"update_storage",
		"data":{"size":size,"color":color,"storage":storage,"goods_size_id":goods_size_id,"goods_sn":goods_sn},
		"type":"post",
		"dataType":"json",
		"success":function(data){
			if(-2 == data.error_code){
				alert("存在相同的规格，保存失败");
			}else if(-1 == data.error_code){
				alert("保存失败");
			}else{
				console.log(goods_size_id);
				if(goods_size_id.length == 0 ){
					$(obj).parents().children("input[name='goods_size_id']").val(data.data);
				}
				$(obj).parents().siblings().children("span[name='block_size']").html(size);
				$(obj).parents().siblings().children("span[name='block_color']").html(color);	
				$(obj).parents().siblings().children("span[name='block_storage']").html(storage);
			}

		}


	})

}


	function del(obj){
		var r=confirm("确认删除吗？");
		if (r==false){
			return false;
		}
		var goods_size_id = $(obj).parents().children("input[name='goods_size_id']").val();
		$.ajax({
		"url":"del_storage",
		"data":{"goods_size_id":goods_size_id},
		"type":"post",
		"dataType":"json",
		"success":function(data){
			if(0 == data.error_code){
				$(obj).parents().parents(("tr[name='goods_size_storage']")).remove();
			}else{
				alert("删除失败");
			}

		}


	})		
		
	}



	function add_storage(){
		var str = '<tr name = "goods_size_storage"><td style="vertical-align: inherit">'+
						'<span name="block_size">'+''+'</span><input style="display:none;width: 100%;" class="form-control" type="text" name="size" value="'+''+'">'+
						'</td>'+
						'<td style="vertical-align: inherit">'+
						'<span name="block_color">'+''+'</span><input style="display:none;width: 100%;" class="form-control" type="text" name="color" value="'+''+'">'+
						'</td>'+						
						'<td style="vertical-align: inherit">'+
						'<span name="block_storage">'+''+'</span><input style="display:none;width: 100%;" class="form-control" type="text" name="storage" value="'+''+'">'+
						'</td>"'+
						'<td style="vertical-align: inherit">'+
						'<input name = "goods_size_id" style="display:none" value="'+''+'"></input><input class="btn btn-success" type="button"  value="修改" onclick="onedit(this)" name="edit_storage"> <input style="display:none" class="btn btn-success" type="button"  value="保存" onclick="save(this)" name="save_storage">|<input class="btn btn-danger" type="button" value="删除" onclick="del(this)" name="del_storage">'+
						'</td><tr>';
		$("#bjy-edit form table").append(str);				

	}
</script>
<style>
		th,td,input{
			vertical-align: inherit;
			text-align: center;
		 }
		
		
</style>
</html>