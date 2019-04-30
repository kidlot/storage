function count(){
	var val=$(".js_editorArea").text();
	
	var val_len=val.length;
	if(val_len<=600)
	{
	  var s_len=600-val_len;
	  $(".editor_tip.js_editorTip").html("还可以输入"+"<em>"+s_len+"</em>"+"字");
	}
	else{
		var c_len=val_len-600;
	   $(".editor_tip.js_editorTip").html("已超出"+"<em style='color:red'>"+c_len+"</em>"+"字");
	}
}
function _init(){
	
	$(".js_editorArea").on("keyup",count);
	var page = $("#myTab").find(".active").index();
	//进行初始化显示
	$.ajax({
		type: "POST",
		url: "getdata",
		data: {"page": page},
		dataType: "json",
		beforeSend:function(){
			$(".msg_show").html('数据加载中...');
			$(".msg_show").show();
		},
		success: function (data){
			var str = "";
			if(data.status == 1){
				var rej = data.data[0];
				if(rej["type"] == "text"){
					$(".tab_text").click();
				}
				else if(rej["type"] == "news"){
					$(".tab_appmsg").click();
				}
				else if(rej["type"] == "image"){
					$(".tab_image").click();
				}
				if(rej["content"] != "" && rej["content"] != undefined){
					$(".edit_area.js_editorArea").text(rej["content"]);
				}
				if(rej["type"] == 'news'){
					$(".MsgSend_media_box").hide();
					var daralist = rej.data[0];
					var count = daralist.count;
					if(count > 1){
						str+= '<li class="blockLeft" value="'+rej["media_id"]+'">';
						str+= '<div class="appmsg_content">';
						str+= '<div class="appmsg_info">';
						str+= '<em class="appmsg_date">'+daralist["ctime"]+'</em>';
						str+= '</div>';
						str+= '<div class="appmsg_item cover_appmsg_item">';
						str+= '<div class="main_img">';
						str+= '<img src="'+daralist["pic"]+'"/>';
						str+= '<h6>'+daralist["title"]+'</h6>';
						str+= '</div>';
						str+= '<p class="desc">'+daralist["intro"]+'</p>';
						str+= '</div>';
						for(var j = 0;j < daralist["child"].length;j++){
							str+= '<div class="appmsg_sub_item">';
							str+= '<p class="title">'+daralist["child"][j]["title"]+'</p>';
							str+= '<div class="main_img">';
							str+= '<img src="'+daralist["child"][j]["pic"]+'"/>';
							str+= '</div>';
							str+= '</div>';
						}
						str+= '</div>';
						str+= '</li>';
					}else if(count == 1){
						str+= '<li class="blockLeft" value="'+rej["media_id"]+'">';
						str+= '<div class="appmsg_content">';
						str+= '<div class="appmsg_info">';
						str+= '<em class="appmsg_date">'+daralist["ctime"]+'</em>';
						str+= '</div>';
						str+= '<div class="appmsg_item cover_appmsg_item">';
						str+= '<div class="main_img">';
						str+= '<img src="'+daralist["pic"]+'"/>';
						str+= '<h6>'+daralist["title"]+'</h6>';
						str+= '</div>';
						str+= '<p class="desc">'+daralist["intro"]+'</p>';
						str+= '</div>';
						str+= '</div>';
						str+= '</li>';
					}
					$(".blockLeft").remove();
					$(".appmsg_wrap").eq(0).show().prepend(str);
					$(".link_dele").show();
					$(".link_dele_image").hide();
				}if(rej["type"] == 'image'){
					$(".MsgSend_media_box_image").hide();
					var daralist = rej.data[0];
					str+= '<li class="blockLeft1" value="'+rej["media_id"]+'">';
					str+= '<div class="appmsg_content">';
					str+= '<div class="appmsg_item cover_appmsg_item">';
					str+= '<div class="main_img" style="height:100%">';
					str+= '<img src="'+daralist["url"]+'" width="100%" height="100%"/>';
					str+= '<h6>'+daralist["name"]+'<br></h6>';
					str+= '</div>';
					str+= '</div>';
					str+= '</div>';
					str+= '</li>';
					$(".blockLeft1").remove();
					$(".appmsg_wrap_image").eq(0).show().prepend(str);
					$(".link_dele").hide();
					$(".link_dele_image").show();
				}
				
			}
		},
		complete: function(){
			$(".msg_show").html('加载完成');
			$(".msg_show").hide();
		},
		error: function (data){
			
		}
	});
}
function selectMnewsCallback(_this){
	$(".appmsg_wrap").eq(0).show().prepend("<li class='blockLeft' value='"+$(_this).data('value')+"'>"+$(_this).html()+"</li>");
	$(".link_dele").show();
	$.Dialog.close();
	$(".MsgSend_media_box").hide();
	$(".hover_area").hide();
}
function selectImageCallback(_this){
	$(".appmsg_wrap_image").eq(0).show().prepend("<li class='blockLeft1' value='"+$(_this).data('value')+"'>"+$(_this).html()+"</li>");
	$(".link_dele_image").show();
	$.Dialog.close();
	$(".MsgSend_media_box_image").hide();
	$(".hover_area").hide();
}
function clear(){
	$(".edit_area.js_editorArea").text("");
	$(".blockLeft").remove();
	$(".blockLeft1").remove();
	$(".link_dele").hide();
	$(".link_dele_image").hide();
	$(".tab_appmsg").click();
	$(".MsgSend_media_box").show();
}
$(document).ready(function(e) {
	_init();
	$(".tab_nav").click(function(e) {
        $(".tab_nav").removeClass("selected");
		$(this).addClass("selected");
		var index=$(this).index();
		$(".tab_content").hide();
		$(".tab_content").eq(index).show();
		if(index==2){
			
		}
    });
	$(".link_dele").click(function(e) {
        $(this).prev().find(".blockLeft").remove();
		$(this).hide();
		$(".MsgSend_media_box").show();
    });
	$(".link_dele_image").click(function(e) {
        $(this).prev().find(".blockLeft1").remove();
		$(this).hide();
		$(".MsgSend_media_box_image").show();
    });	
	$("#js_save").click(function(e) {
		var page = $("#myTab").find(".active").index();
		var type = $("#editDiv").find(".selected").attr("data-type");
		if(type == "news"){
			var value = $(".blockLeft").attr("value");
		}else if(type == "image"){
			var value = $(".blockLeft1").attr("value");
		}else if(type == "text"){
			var value = $(".edit_area.js_editorArea").text();
		}
		else{
			updateAlert("内容为空");
			return false;
		}
		$.ajax({
			type: "POST",
			url: "edit",
			data: {"type": type, "value": value, "page": page},
			dataType: "json",
			success: function (data){
				if(data.status == 1){
					updateAlert(data.info, 'alert-success');
				}
				else{
					updateAlert(data.info);
				}
			},
			error: function (data){
				updateAlert(data.info);
			}
		});
		
    });
	$('#js_confirm').click(function(){
		var page = $("#myTab").find(".active").index();
		$.ajax({
			type: "POST",
			url: "delete",
			data: {"page": page},
			dataType: "json",
			success: function (data){
				if(1 == data.status){
					clear();
					updateAlert(data.info, 'alert-success');
				}
				else{
					updateAlert(data.info);
				}
			},
			error: function (data){
				updateAlert(data.info);
			}
		});
	})
	
	
});