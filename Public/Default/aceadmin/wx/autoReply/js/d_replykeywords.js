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
}
function selectMnewsCallback(_this, objid){
	$("#Js_replyList_" + objid + " li").attr("data-type", "news");
	$("#Js_replyList_" + objid + " li").attr("data-content", $(_this).data('value'));
	$("#Js_replyList_"+objid+" .desc").html($(_this).html());
	$(".blockLeft .desc").css("margin", 0);
	$(".blockLeft .desc").css("padding", 0);
	$("#Js_replyList_" + objid + " li").find('.desc').css("width", "30%");
	$.Dialog.close();
}
function selectImageCallback(_this, objid){
	$("#Js_replyList_" + objid + " li").attr("data-type", "image");
	$("#Js_replyList_" + objid + " li").attr("data-content", $(_this).data('value'));
	$("#Js_replyList_"+objid+" .desc").html($(_this).html());
	$(".blockLeft1 .desc").css("margin", 0);
	$(".blockLeft1 .desc").css("padding", 0);
	$("#Js_replyList_" + objid + " li").find('.desc').css("width", "30%");
	$.Dialog.close();
}
//仅仅用于列表
function openKeywordMsg(dataUrl,callback,title, id){
	var $contentHtml = $('<div class="appmsg_dialog" style="padding:10px; max-height:560px;overflow-y:auto;overflow-x:hidden;"><ul class="mt_10"><center><br/><br/><br/><img src="'+IMG_PATH+'/loading.gif"/></center></ul></div>');
	$.Dialog.open(title?title:"选择素材",{width:1000,height:640},$contentHtml);
	$.ajax({
		url:dataUrl,
		data:{'type':'ajax'},
		dataType:'html',
		success:function(data){
			$data = $(data);
			$('ul',$contentHtml).html($data);
			$data.find('.material_list').masonry({
				// options
				itemSelector : '.appmsg_li'
				//columnWidth : 308
			  });
			$('li',$contentHtml).on('click',function(){
				callback(this,id);
			});
		}
	})
}
//仅仅用于列表图片
function openKeywordMsgImage(dataUrl,callback,title, id){
	var $contentHtml = $('<div class="appmsg_dialog" style="padding:10px; max-height:560px;overflow-y:auto;overflow-x:hidden;"><ul class="mt_10"><center><br/><br/><br/><img src="'+IMG_PATH+'/loading.gif"/></center></ul></div>');
	$.Dialog.open(title?title:"选择素材",{width:1000,height:640},$contentHtml);
	$.ajax({
		url:dataUrl,
		data:{'type':'ajax'},
		dataType:'html',
		success:function(data){
			$data = $(data);
			$('ul',$contentHtml).html($data);
			$data.find('.material_list_image').masonry({
				// options
				itemSelector : '.appmsg_li'
				//columnWidth : 308
			  });
			$('li',$contentHtml).on('click',function(){
				callback(this,id);
			});
		}
	})
}