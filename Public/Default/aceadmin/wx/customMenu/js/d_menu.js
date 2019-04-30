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
   function input_count(t){
		var menu_text=$(t).val();
		var len = 0;
		var text_len=menu_text.length;
		for(var i=0;i<text_len;i++){
			if( menu_text.charCodeAt(i)>256){
				//$(this).attr('maxlength','9');
				len += 1;  
			}else {  
				//$(this).attr('maxlength','18');
				len +=0.5;
			}  
		}
	if(len > 8){
		$(".frm_msg.fail").eq(0).show();
		$(".frm_msg.fail").eq(1).hide();
		$(".js_titleNolTips").eq(0).hide();
	}
	else if(len <= 8 && len > 0){
		$(".frm_msg.fail").eq(1).hide();
		$(".frm_msg.fail").eq(0).hide();
		$(".js_titleNolTips").eq(0).show();
	}
	else if(len <= 0){
		$(".frm_msg.fail").eq(0).hide();
		$(".frm_msg.fail").eq(1).show();
		$(".js_titleNolTips").eq(0).hide();
	}
	return len;
   }
   
	function second_id(){
		for(var i=0;i<$(".jsMenu").length;i++){
			    console.log($(".jsMenu").length)
				var z_id=$(".jsMenu").eq(i).attr("id");
				var z_id_index=z_id.split("_")[2];
				for(var j=0;j<$(".jsMenu").eq(i).find(".jslevel2").length;j++){
					$(".jsMenu").eq(i).find(".jslevel2").eq(j).attr("id","j_m_"+z_id_index+"_"+j);
				}
				
		}
		//var i=$(".jslevel2").parents(".jsMenu").attr("id");
	
		
	}
	//菜单有子菜单的显示
	function dot_show(){
		var len=$(".jslevel1").length;
		
		for(var i=0;i<len;i++){
			var len_2 = $(".jslevel1").eq(i).find(".jslevel2").length;
			if(len_2 > 0){
				$(".jslevel1").eq(i).find(".js_icon_menu_dot").show();
			}
			else{
				$(".jslevel1").eq(i).find(".js_icon_menu_dot").hide();
			}
		}
	}
	function add_id(t){
		var t=t;
		
	    var class_name=$(t).attr("class");
		//alert(class_name);
		//主菜单
		if(class_name.indexOf("add_menu1")!=-1)
		{var menu_len=$(".jslevel1").length;
		var max=0;
		for(var i=0;i<menu_len;i++){
			var id_index=Number($(".jslevel1").eq(i).attr("id").split("_")[2]);
			if(max<id_index){
				max=id_index;
			}
		}
		return "z_m_"+(max+1);}
		if(class_name.indexOf("add_menu2")!=-1)
		{var menu_len=$(t).parents(".jslevel1").find(".jslevel2").length;
		var max=0;
		var z_index=$(t).parents(".jslevel1").attr("id").split("_")[2];
		for(var i=0;i<menu_len;i++){
			var id_index=Number($(t).parent().find(".jslevel2").eq(i).attr("id").split("_")[3]);
			//alert(id_index)
			if(max<id_index){
				max=id_index;
			}
		}
		return "j_m_"+z_index+"_"+(max+1);}
		
		
	}
	//判断菜单的位置,选中情况
	function restore(){
		var menu2_len = $(".jslevel1:eq(0)").find(".sub_pre_menu_list").children().length;
		$(".current").removeClass("current");
		if(0 == menu2_len){
			//没有任何菜单，选中初始
			$(".js_addMenuBox").addClass("current");
			$("#js_none").show();//一级菜单右侧
			$("#js_rightBox").hide();//一级菜单右侧
		}
		else if(1 == menu2_len){
			//没有子菜单菜单，至少有一个一级菜单
			$(".jslevel1:eq(0)").trigger("click");
		}
		else {
			for(var i=0;i<$(".jsMenu").length;i++){
				if(0 == i){
					$(".jsMenu").eq(i).find(".sub_pre_menu_box").show();
				}
				else{
					$(".jsMenu").eq(i).find(".sub_pre_menu_box").hide();
				}
			}
			$(".jslevel1:eq(0)").find(".sub_pre_menu_list").children().eq(0).trigger("click");
		}
	}
	function selectMnewsCallback(_this){
		$(".MsgSend_media_box").eq(0).hide();
		$(".appmsg_wrap").eq(0).show().prepend("<li class='blockLeft'>"+$(_this).html()+"</li>");
		$(".appmsg_wrap").eq(0).find("div.hover_area").css("display", "none");
		$(".link_dele").show();
		$.Dialog.close();
		
		var id=$(".menu_form_area").attr("data-id");//与菜单相对应的内容
		var menu_name=$(".js_menu_name").val();//子菜单名称
		var menu_type=$(".js_radio").find(":checked").attr("name");
		var type=$("#editDiv").find(".selected").attr("data-tooltip");
		var media_id = $(_this).data('value');
		var pid=$("#"+id).parents(".jslevel1").attr("id");
		var name=$("#"+id).parents(".jslevel1").find(".js_l1Title").text();
		/*ajax发送相关数据*/
		$.ajax({
			type: "POST",
			url: "ajaxData",
			data: {"id": id, "menu_name": menu_name,"menu_type":menu_type,"type":type,"media_id":media_id,"pid":pid,"name":name,"isedit":"edit_menu_type","menu_type":"s_mess","new_select":$(_this).parent().parent().parent().find('.new_select').val()},
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
	}
	function selectImageCallback(_this){
		$(".MsgSend_media_box_image").eq(0).hide();
		$(".appmsg_wrap_image").eq(0).show().prepend("<li class='blockLeft1'>"+$(_this).html()+"</li>");
		$(".appmsg_wrap_image").eq(0).find("div.hover_area").css("display", "none");
		$(".link_dele_image").show();
		$.Dialog.close();
		
		var id=$(".menu_form_area").attr("data-id");//与菜单相对应的内容
		var menu_name=$(".js_menu_name").val();//子菜单名称
		var menu_type=$(".js_radio").find(":checked").attr("name");
		var type=$("#editDiv").find(".selected").attr("data-tooltip");
		var media_id = $(_this).data('value');
		var pid=$("#"+id).parents(".jslevel1").attr("id");
		var name=$("#"+id).parents(".jslevel1").find(".js_l1Title").text();
		
		/*ajax发送相关数据*/
		$.ajax({
			type: "POST",
			url: "ajaxData",
			data: {"id": id, "menu_name": menu_name,"menu_type":menu_type,"type":type,"media_id":media_id,"pid":pid,"name":name,"isedit":"edit_menu_type","menu_type":"s_mess"},
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
	}
	function clear(){
		$(".edit_area.js_editorArea").text("");
		$(".blockLeft").remove();
		$(".blockLeft1").remove();
		$(".link_dele").hide();
		$(".link_dele_image").hide();
		$("#urlText").attr("value", "");
		$("#urlText").val("");
	}
	function newsdata(id_name, type){
		$.ajax({
			type: "POST",
			url: "getMenu",
			data: {"id": id_name},
			dataType: "json",
			success: function (data){
				if(data.data != null){
					var daralist = data.data[0];
					var str = "";
					//图文素材
					if(data.type == "media_id" || data.type == "click" || data.type == "view_limited"){
						clear();
						$(".js_radio:eq(0)").click();
						if(data.type == "view_limited"){
							$(".tab_appmsg").click();
							$(".MsgSend_media_box").eq(0).hide();
							$(".MsgSend_media_box_image").eq(0).show();
							var count = daralist.count;
							if(count > 1){
								str+= '<li class="blockLeft">';
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
								str+= '<li class="blockLeft">';
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
						}else if(data.type == "media_id"){
							$(".tab_image").click();
							$(".MsgSend_media_box").eq(0).show();
							$(".MsgSend_media_box_image").eq(0).hide();
							str+= '<li class="blockLeft1">';
							str+= '<div class="appmsg_content">';
							str+= '<div class="appmsg_item cover_appmsg_item">';
							str+= '<div class="main_img" style="height:100%">';
							str+= '<img src="'+daralist["url"]+'" width="100%" height="100%"/>';
							str+= '<h6>'+daralist["name"]+'<br>'+daralist["update_time"]+'</h6>';
							str+= '</div>';
							str+= '</div>';
							str+= '</div>';
							str+= '</li>';
							$(".blockLeft1").remove();
							$(".appmsg_wrap_image").eq(0).show().prepend(str);
							$(".link_dele_image").show();
						}else if(data.type == "click"){
							$(".tab_text").click();
							$(".edit_area.js_editorArea").text(data.data);
						}else{
							
						}
					}else if(data.type == "view"){
						//跳转链接
						$(".js_radio:eq(1)").click();
						clear();
						$("#urlText").val(data.data);
					}
				}else{
					$(".js_radio:eq(0)").click();
					$(".tab_appmsg").click();
					clear();
					$(".MsgSend_media_box").eq(0).show();
					$(".MsgSend_media_box_image").eq(0).show();
				}
				$("#js_rightBox").show();
			}
		});
	}
	function _init(){
		//右侧
		dot_show();
		$(".js_editorArea").on("keyup",count);
		restore();
	}
$(document).ready(function(e) {
	$(".menu_form_area .frm_radio_label").click(function(e) {
        $(".menu_form_area .frm_radio_label").removeClass("selected");
		$(this).addClass("selected");
	    $(".menu_form_area .frm_radio_label").find(".frm_radio").removeAttr("checked")
		$(this).find(".frm_radio").attr("checked","true");
		var index=$(this).index();
		$(".menu_content").hide();
		$(".menu_content").eq(index).show();
    });
	$(".table").delegate(".frm_radio_label","click",function(){
		 $(".table .frm_radio_label").removeClass("selected");
		 $(this).addClass("selected");
		 $(".table .frm_radio_label").find(".frm_radio").removeAttr("checked")
		 $(this).find(".frm_radio").attr("checked","true");
	});
	$(".tab_nav").click(function(e) {
        $(".tab_nav").removeClass("selected");
		$(this).addClass("selected");
		var index=$(this).index();
		$(".tab_content").hide();
		$(".tab_content").eq(index).show();
		if(index==2){
			
		}
    });
        /*文字发送*/
        $("#save_text").click(function(){
            var id=$(".menu_form_area").attr("data-id");//与菜单相对应的内容
            var menu_name=$(".js_menu_name").val();//子菜单名称
            var menu_type=$(".js_radio").find(":checked").attr("name");
            var type=$("#editDiv").find(".selected").attr("data-tooltip");
            var pid=$("#"+id).parents(".jslevel1").attr("id");
            var key=$(".edit_area.js_editorArea").text();
            var name=$("#"+id).parents(".jslevel1").find(".js_l1Title").text();

            /*ajax发送相关数据*/
			if(1 == go){
				go = 0;
				$.ajax({
					type: "POST",
					url: "ajaxData",
					data: {"id": id, "menu_name": menu_name,"menu_type":menu_type,"type":type,"key":key,"pid":pid,"name":name,"isedit":"edit_menu_type","menu_type":"s_mess"},
					dataType: "json",
					success: function (data){
						go = 1;
						if(data.status == 1){
							updateAlert(data.info, 'alert-success');
						}
						else{
							updateAlert(data.info);
						}
						
					},
					error: function (data){
						go = 1;
						updateAlert(data.info);
					}
				});
			}
			else{
				updateAlert("操作过快");
			}
           

        });
        /*跳转网页*/
        $("#urlText").blur(function(){
            var id=$(".menu_form_area").attr("data-id");//与菜单相对应的内容
            var menu_name=$(".js_menu_name").val();//子菜单名称
            var menu_type=$(".js_radio").find(":checked").attr("name");
            var type=$("#editDiv").find(".selected").attr("data-tooltip");
            var pid=$("#"+id).parents(".jslevel1").attr("id");
            var url=$(this).val();
            var name=$("#"+id).parents(".jslevel1").find(".js_l1Title").text();
			if(1 == go){
				go = 0;
				/*ajax发送相关数据*/
				$.ajax({
					type: "POST",
					url: "ajaxData",
					data: {"id": id, "menu_name": menu_name,"menu_type":menu_type,"type":type,"url":url,"pid":pid,"name":name,"isedit":"edit_menu_type","menu_type":"j_web"},
					dataType: "json",
					success: function (data){
						go = 1;
						if(data.status == 1){
							updateAlert(data.info, 'alert-success');
						}
						else{
							updateAlert(data.info);
						}
					},
					error: function (data){
						go = 1;
						updateAlert(data.info);
					}
				});
			}
			else{
				updateAlert("操作过快");
			}

        });
	//左侧菜单的切换
  //一级菜单
  $("#menuList").delegate(".jsMenu","click",function(e) {
	  //此处从后台要id值;
	   var id_name=$(this).attr("id");
	   $(".menu_form_area").attr("data-id",id_name);//右侧的值和左侧的点击菜单一致
       $(".current").removeClass("current");
	   $(".jsMenu").children(".sub_pre_menu_box").hide();//初始化
	   $(this).addClass("current").children(".sub_pre_menu_box").show();//当前的一级菜单高亮一级菜单的框
	  // $(this).find(".jslevel2").removeClass("current");//二级菜单移除框
	   var menu2_len=$(this).find(".sub_pre_menu_list").children().length;//二级菜单的个数
	    var menu_name=$(this).find(".js_l1Title").text().trim();
	   $(".menu_form_area .global_info").text(menu_name);
	   $(".js_menu_name").val(menu_name);//初始化菜单名称
	   $(".js_menuTitle").text("菜单名称")
	   $("#jsDelBt").text("删除菜单");
	   $(".title.js_menuContent").text("菜单内容");
	   $(".js_titleNolTips").text("字数不超过4个汉字或8个字母")
	   $("#js_none").hide();//一级菜单右侧
	   if(menu2_len==1){
		    $(".menu_form_bd .menu_content_container").show();
		    $(".frm_control_group").eq(1).show();
		    $("#js_innerNone").hide();
			dot_show();
			$(".menu_form_area .frm_control_group").show();
		    $(".menu_form_area .menu_content_container").show();
	   }
	   if(menu2_len>=2){
		   $(".menu_form_bd .menu_content_container").hide();
		   $(".frm_control_group").eq(1).hide();
		   $("#js_innerNone").show();
		   $(".menu_form_area .frm_control_group").eq(1).hide();
		   $(".menu_form_area .menu_content_container").hide();
	   }
	   newsdata(id_name, "z");
   });
   
   
   
	//要传给后台的值
	$(".js_menu_name").blur(function(e) {
		var id_name=$(".menu_form_area").attr("data-id");
		var menu_name=$(this).val();
		var len = input_count($(".js_menu_name"));
		if(len > 8 || len <= 0){
			return false;
		}
		//要传给后台的值
		$.ajax({
			type: "POST",
			url: "ajaxData",
			data: {"id": id_name, "menu_name": menu_name, "isedit": "editname"},
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
		
		//console.log(menu_name)
		var len=menu_name.trim().length;
		var c_menu_box=$(this).parents(".menu_form_area").attr("data-id");
		if(len>0){
			if($(".frm_msg.fail").is(":hidden")){
			  $(".menu_form_area").find(".global_info").text(menu_name);
			  var class_name=$("#"+c_menu_box).attr("class");
			  console.log(class_name);
			  if(class_name.indexOf("jslevel2")!=-1){
				  $("#"+c_menu_box).find(".js_l2Title").text(menu_name);
			  }
			 if(class_name.indexOf("jslevel1")!=-1){
				  $("#"+c_menu_box).find(".js_l1Title").text(menu_name);
			  }
			  /*if($(".current").hasClass("jslevel2"))
				 {
					 $(".current").find(".js_l2Title").text(menu_name);
				 }
			 else{
						
					   $(".current").find(".js_l1Title").text(menu_name);
				}*/
			
			}
		}
	});
	//菜单名称的字数计数
	$(".js_menu_name").keyup(function(){
		var t=$(this)
		input_count(t);
	})
	//二级菜单添加
	$("#menuList").delegate(".add_menu2","click",function(e){
		//右侧菜单
		e.stopImmediatePropagation();
		$("#js_none").hide();
		$("#js_rightBox").show();
		//一级菜单的处理
		$(".menu_form_area #js_innerNone").hide();//子菜单个数不能0;
		$(".frm_msg.fail").eq(0).hide();
		$(".current").removeClass("current");//删除所有高亮样式；
		//后台调去id值;
		var id_menu2=add_id($(this));
		if($(this).parents(".jsMenu").find(".jslevel2").length<5){
			$.ajax({
				type: "POST",
				url: "ajaxData",
				data: {"id": id_menu2},
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
			$(this).before('<li  class="jslevel2" id='+id_menu2+'>'+'<a href="javascript:void(0);" class="jsSubView"><span class="sub_pre_menu_inner js_sub_pre_menu_inner"><i class="icon20_common sort_gray"></i><span class="js_l2Title">子菜单名称</span></span></a></li>')
		   // console.log($(".jsMenu").attr("class"));
			//$(this).parents(".jsMenu").removeClass("current");//二级菜单的颜色框
			$(this).parents(".jslevel1").find(".icon_menu_dot").show();//可以单写一个函数
			//二级菜单的编辑框
			clear();
			$(".js_radio:eq(0)").click();
			var menu2_text=$(this).siblings(".current").text().trim();
			$(".menu_form_area").find(".global_info").text(menu2_text);
			$(".menu_form_area").find(".js_menuTitle").text(menu2_text);
			$(".menu_form_area").find(".js_menu_name").val(menu2_text);
			$(".menu_form_area").find(".js_titleNolTips").text("字数不超过8个汉字或16个字母");
			$("#jsDelBt").text("删除子菜单");
			$(".title.js_menuContent").text("子菜单内容");
			$(".menu_form_area .frm_control_group").show();
			$(".menu_form_area .menu_content_container").show();
			var len=$(this).parents(".jsMenu").find(".jslevel2").length;
			$(this).parents(".jsMenu").find(".jslevel2").eq(len-1).click();//新添加的子菜单被点击
		}
		else{
		     var len=$(this).parents(".jsMenu").find(".jslevel2").length;
		     $(this).parents(".jsMenu").find(".jslevel2").eq(len-1).click();
			 updateAlert("最多添加5个子菜单");
		}
		//second_id();
		
		
	})
	//删除确定菜单框
   $("#js_confirm").click(function(e) {
	  var menu_1_len=$(".jslevel1").length;//一级菜单的个数
	  var id_name=$(".menu_form_area").attr("data-id");
	  $.ajax({
		type: "POST",
		url: "deleteMenu",
		data: {"id": id_name},
		dataType: "json",
		success: function (data){
			if(1 == data.status){
				updateAlert(data.info, 'alert-success');
				$("#"+id_name).remove();//编辑菜单被删除;
				dot_show();
				$("#js_none").show();//一级菜单右侧
				$("#js_rightBox").hide();//一级菜单右侧
				menu_1_len--;
				if("z" == data.tip){
					if(menu_1_len == 2){
						
					}
					else if(menu_1_len == 1){
					   $(".jslevel1").removeClass("size1of3").addClass("size1of2");
					}
					else if(menu_1_len == 0){
					  $("#menuList").html("<li class='js_addMenuBox pre_menu_item size1of3 add_menu1'>"+"<a href='javascript:void(0);' class='pre_menu_link' title='添加菜单'>"+'<i class="icon16_common add_gray"></i>'+"<span>添加菜单</span></a>"+"</li>")
					}
				}
				restore();
			}
			else{
				updateAlert(data.info);
			}
		},
		error: function (data){
			updateAlert(data.info);
		}
	  });
	  $("#myModal_del").hide();
	  $(".modal-backdrop").hide();
    });
	
	//一级菜单添加
	$("#menuList").delegate(".add_menu1","click",function(){
		$("#js_rightBox").show();
		$("#js_none").hide();
		$(".current").removeClass("current");
		var menu1_len=$("#menuList").children().length;
		//console.log(menu1_len);
		//后台调取的id
		var id_menu=add_id($(this));
		if(1 == menu1_len || 2 == menu1_len || 3 == menu1_len){
			$.ajax({
				type: "POST",
				url: "ajaxData",
				data: {"id": id_menu},
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
		}
		
		//add_id();
		if(menu1_len==1){
		  $(this).find("span").html("");
		  $(this).before('<li class="jsMenu pre_menu_item jslevel1 size1of2" id='+id_menu+ '>'+
                        '<a href="javascript:void(0);" class="pre_menu_link" draggable="false">'+
                           ' <i class="icon_menu_dot js_icon_menu_dot dn" style="display: none;"></i>'+
                           ' <i class="icon20_common sort_gray"></i>'+
                           ' <span class="js_l1Title">菜单名称</span>'+
                        '</a>'+
                       ' <div class="sub_pre_menu_box" style="">'+
                           ' <ul class="sub_pre_menu_list">'+
                                
                               ' <li class="js_addMenuBox add_menu2"><a href="javascript:void(0);" class="jsSubView js_addL2Btn" title="添加子菜单" draggable="false"><span class="sub_pre_menu_inner js_sub_pre_menu_inner"><i class="icon16_common add_gray"></i></span></a></li>'+
                           ' </ul>'+
                           ' <i class="arrow arrow_out"></i>'+
                            '<i class="arrow arrow_in"></i>'+
                        '</div>'+
                    '</li>');
					
		   $(this).find(".js_addMenuTips").remove();
		   $("#js_none").hide();//一级菜单右侧
	       $("#js_rightBox").show();//一级菜单右侧	
		   $(".menu_form_area .frm_control_group").show();
		   $(".menu_form_area .menu_content_container").show();	
		   $(".menu_form_area #js_innerNone").hide();
		   for(var i=0;i<$(".jsMenu").length-1;i++){
		       $(".jsMenu").eq(i).find(".sub_pre_menu_box").hide();
		       //$(".jsMenu").eq(i).removeClass("current");
		   }
		}
		if(menu1_len==2){
			$(".jslevel1").removeClass("size1of2").addClass("size1of3");
			$(this).before('<li class="jsMenu pre_menu_item grid_item jslevel1 size1of3" id='+id_menu+'>'+
                        '<a href="javascript:void(0);" class="pre_menu_link" draggable="false">'+
                            
                           ' <i class="icon_menu_dot js_icon_menu_dot" style="display: none;"></i>'+
                            '<i class="icon20_common sort_gray"></i>'+
                            '<span class="js_l1Title">菜单名称</span>'+
                        '</a>'+
                       ' <div class="sub_pre_menu_box js" style="">'+
                           ' <ul class="sub_pre_menu_list">'+
                                
                                '<li class="js_addMenuBox add_menu2"><a href="javascript:void(0);" class="jsSubView js_addL2Btn" title="添加子菜单" draggable="false"><span class="sub_pre_menu_inner js_sub_pre_menu_inner"><i class="icon16_common add_gray"></i></span></a></li>'+
                           ' </ul>'+
                            '<i class="arrow arrow_out"></i>'+
                            '<i class="arrow arrow_in"></i>'+
                        '</div>'+
                    '</li>');
		    $("#js_none").hide();//一级菜单右侧
	        $("#js_rightBox").show();//一级菜单右侧
			$(".menu_form_area .frm_control_group").show();
		    $(".menu_form_area .menu_content_container").show();
		    $(".menu_form_area #js_innerNone").hide();
			for(var i=0;i<$(".jsMenu").length-1;i++){
		       $(".jsMenu").eq(i).find(".sub_pre_menu_box").hide();
		      // $(".jsMenu").eq(i).removeClass("current");
		   }
		}
	  if(menu1_len==3){
		  $(this).before('<li class="jsMenu pre_menu_item grid_item jslevel1 size1of3" id='+id_menu+'>'+
                        '<a href="javascript:void(0);" class="pre_menu_link" draggable="false">'+
                            
                           ' <i class="icon_menu_dot js_icon_menu_dot" style="display: none;"></i>'+
                            '<i class="icon20_common sort_gray"></i>'+
                            '<span class="js_l1Title">菜单名称</span>'+
                        '</a>'+
                       ' <div class="sub_pre_menu_box" style="">'+
                           ' <ul class="sub_pre_menu_list">'+
                                
                                '<li class="js_addMenuBox add_menu2"><a href="javascript:void(0);" class="jsSubView js_addL2Btn" title="添加子菜单" draggable="false"><span class="sub_pre_menu_inner js_sub_pre_menu_inner"><i class="icon16_common add_gray"></i></span></a></li>'+
                           ' </ul>'+
                            '<i class="arrow arrow_out"></i>'+
                            '<i class="arrow arrow_in"></i>'+
                        '</div>'+
                    '</li>');
		 $("#js_none").hide();//一级菜单右侧
	     $("#js_rightBox").show();//一级菜单右侧
		 $(".menu_form_area .frm_control_group").show();
		 $(".menu_form_area .menu_content_container").show();	
		 $(".menu_form_area #js_innerNone").hide();
		 for(var i=0;i<$(".jsMenu").length-1;i++){
		   $(".jsMenu").eq(i).find(".sub_pre_menu_box").hide();
		   //$(".jsMenu").eq(i).removeClass("current");
		 }
	  }
	 $(this).prev().click();
	})
	//二级菜单点击
	$("#menuList").delegate(".jslevel2","click",function(e){
		e.stopImmediatePropagation();
	    var id_name=$(this).attr("id");
	    $(".menu_form_area").attr("data-id",id_name);//右侧的值和左侧的点击菜单一致
		$(".menu_form_area #js_innerNone").hide();
		$(".current").removeClass("current");
		$(this).addClass("current");
		$(".jslevel1").removeClass("current");
	    var menu2_text=$(this).text().trim();
		$(".menu_form_area").find(".global_info").text(menu2_text);
		$(".menu_form_area").find(".js_menuTitle").text("子菜单名称");
		$(".menu_form_area").find(".js_menu_name").val(menu2_text);
		$(".menu_form_area").find(".js_titleNolTips").text("字数不超过8个汉字或16个字母");
		$("#jsDelBt").text("删除子菜单");
		$(".title.js_menuContent").text("子菜单内容");
		$(".frm_control_group").eq(1).show();
		$(".menu_content_container").show();
		$("#js_none").hide();
		newsdata(id_name, "j");
	})
	//增加或者减少
	$(".popover_k .frm_radio_label").click(function(e) {
		$(".popover_k .frm_radio_label").removeClass("selected");
        $(this).addClass("selected");
    });
	$(".link_dele").click(function(e) {
        $(this).prev().find(".blockLeft").remove();
		$(this).hide();
		var index=$(".tab_navs .selected").index();
		if(index==0){
			$(".MsgSend_media_box").eq(0).show();
		}
    });
	$(".link_dele_image").click(function(e) {
        $(this).prev().find(".blockLeft1").remove();
		$(this).hide();
		var index=$(".tab_navs .selected").index();
		if(index==2){
			$(".MsgSend_media_box_image").eq(0).show();
		}
    });
	//素材搜索删除
	$("#searchCloseBt").click(function(e) {
        $("#msgSearchInput").val("");
    });
	_init();
});