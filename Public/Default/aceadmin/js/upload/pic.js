$(function(){
	// 显示移动图片和删除图片按钮
	$(document).on("mouseover mouseout", "ul li .jsImg", function(e){		
		if(e.type == "mouseover"){
			$(this).children(".divMask").show();
		 }else if(e.type == "mouseout"){
			$(this).children(".divMask").hide();
		 }
	});
	
	// 删除上传图片
	$(document).on('click', ".imgDelete", function(){
		var a = $(this).parent("div").parent(".jsImg").children("img").attr("src");
		if(confirm('删除图片将立即生效？')){
			$(this).parent("div").parent(".jsImg").parent("li").remove();
			$.ajax({
				type: "post",
				url: delurl,
				data:"path=" + a,
				dataType: "json",
				success: function(data){
					console.log(data);
				},
				error: function(data){
					console.log(data);
				}
			});
		}
		
	});
	// 修改图片上面的链接
	$(document).on('click', ".imgEdit", function(){
		var obj = $(this).parent("div").parent(".jsImg").parent("li");
		if(showtype == "fm"){
			var a = obj.find(".data1 input").attr("value");
			$("#bjy-edit input[name='picexplanation']").val(a);
		}
		var b = obj.find(".data2 input").attr("value");
		$("#bjy-edit input[name='picurl']").val(b);
		var c = $(this).parent("div").parent(".jsImg").parent("li").attr("id");
		$("#bjy-edit input[name='id']").val(c);
		$('#bjy-edit').modal('show');
	});
	
	
	// 向左移动图片位置
	$(document).on("click", ".imgLeft", function(){
		var $this = $(this);
		var n = $this.parent().parent().parent('li').nextAll().length	//获取剩下li的个数
		var m = $this.parent().parent().parent('li').parent('ul').children('li').length;			//获取总的li的数量
		if(m == 1){
			return;
		}
		else if(m > 1){ 
			if(n == 0){	// 末尾
				var pre = $this.parent().parent().parent('li').prev();
				$this.parent().parent().parent('li').after(pre);
			}else if(n == m){	//首位
				return;
			}else{	// 中间
				var pre = $this.parent().parent().parent('li').prev();
				$this.parent().parent().parent('li').after(pre);
			}
		}
	});
	
	// 向右移动图片位置
	$(document).on("click", ".imgRight", function(){
		var $this = $(this);
		var n = $this.parent().parent().parent('li').nextAll().length	//获取剩下li的个数
		var m = $this.parent().parent().parent('li').parent('ul').children('li').length;	//获取总的li的数量

		if(m == 1){
			return;
		}
		else if(m > 1){ 
			if(n == 0){	// 末尾
				return;
			}else if(n == m){	//首位
				$this.parent().parent().parent('li').next().after($this.parent().parent().parent('li'));
			}else{	// 中间
				$this.parent().parent().parent('li').next().after($this.parent().parent().parent('li'));
			}
		}
	});
	
	// 向上移动图片位置
	$(document).on("click", ".btnImgUp", function(){
		var $this = $(this);
		var n = $this.parent().parent('.upfileImg').nextAll().length	//获取剩下li的个数
		var m = $("#goodsImg").children('div').length;			//获取总的li的数量

		if(m == 1){
			return;
		}
		else if(m > 1){ 
			if(n == 0){	// 末尾
				var pre = $this.parent().parent('.upfileImg').prev();
				$this.parent().parent('.upfileImg').after(pre);
			}else if(n == m){	//首位
				return;
			}else{	// 中间
				var pre = $this.parent().parent('.upfileImg').prev();
				$this.parent().parent('.upfileImg').after(pre);
			}
		}
	});
	
	// 向下移动图片位置
	$(document).on("click", ".btnImgDown", function(){
		var $this = $(this);
		var n = $this.parent().parent('.upfileImg').nextAll().length	//获取剩下li的个数
		var m = $("#goodsImg").children('div').length;			//获取总的li的数量

		if(m == 1){
			return;
		}
		else if(m > 1){ 
			if(n == 0){	// 末尾
				return;
			}else if(n == m){	//首位
				$this.parent().parent('.upfileImg').next().after($this.parent().parent('.upfileImg'));
			}else{	// 中间
				$this.parent().parent('.upfileImg').next().after($this.parent().parent('.upfileImg'));
			}
		}
	});
	
	_init();
	// 页面初始化
	function _init(){
		var b = new Array();	//保存上传图片id
		var h = "";
		var mid = $("input[name='fid']").val();
		var a = "<span name=\"\" class=\"fl ml10 h36 lh36\"></span><a class=\"btn btn-success btnImg fl ml10\" id=\"btnImg" + mid + "\" value=\"" + mid + "\">上传图片</a><span class=\"fl ml10 h36 lh36\">最大500KB，支持jpg，gif，png格式。</span>";
		var u = "<ul id=\"ul_pics" + mid + "\" class=\"ul_pics mt15 fl wp100 clearfix\"></ul>";

		h += "<div class=\"wp100 p10 upfileImg upfileImg clearfix\">" + a + u + "</div>";
		b.push("btnImg" + mid);
		$("#goodsImg").append(h);
		_initUploadsImg(b);
		//展现图片
		$.ajax({
			type: "post",
			url: showpicurl,
			data: "mid=" + mid,
			dataType: "json",
			success: function(data){
				if(data['code'] == 0){
					var rej = data['msg'];
					var liHtml = "";
					var g = "<a href=\"javascript:void(0);\" class=\"imgEdit h40 lh40 wp100 fl ta_c\"><i class=\"icon-edit fs18 col-222\"></i></a>"
					var l = "<a href=\"javascript:void(0);\" class=\"imgLeft h40 lh40 wp50 fl ta_c\"><i class=\"icon-arrow-left fs18 col-222\"></i></a>";
					var r = "<a href=\"javascript:void(0);\" class=\"imgRight h40 lh40 wp50 fl ta_c\"><i class=\"icon-arrow-right fs18 col-222\"></i></a>";
					var e = "<a href=\"javascript:void(0);\" class=\"imgDelete h40 lh40 wp100 fl ta_c\"><i class=\"icon-trash fs18 col-222\"></i></a>"
					var d = "<div class=\"pa t0 l0 opacity70 dis-n bg-c-eee pt20 divMask\" style=\"width:154px;height:155px\">" + g + l + r + e + "</div>";
					for (i = 0; i < data['msg'].length; i++) {
						var c = rej[i]['pic'];
						var a = "<input type=\"hidden\" name=\"fileImg[]\" value=\"" + c + "\">";
						var f = "<div class='data1'><input type=\"hidden\" name='explanation[]' value='"+rej[i]['explanation']+"'/></div>";
						var h = "<div class='data2'><input type=\"hidden\" name='url[]' value='"+rej[i]['url']+"'/></div>";
						var j = "<div class='img pr jsImg'><img src='" + img_site_url + c + "'/>" + a + d + "</div>" + f + h;
						liHtml += '<li id="o_' + rej[i]["id"] + '">' + j +'</li>';
					}
					$("#ul_pics" + mid).html(liHtml);
					$mainColor = $(".upfileImg");
					$mainColor.remove();
					$mainColor.prependTo("#goodsImg");
				}
				else{
					
				}
				
			}
		});
	}


	// 初始化上传图片
	function _initUploadsImg(a){
		var uploader = new plupload.Uploader({//创建实例的构造方法
		    runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
		    browse_button: a, // 上传按钮
		    url: uploadurl, //远程上传地址
		    flash_swf_url: '/Public/Default/aceadmin/js/plupload/Moxie.swf', //flash文件地址
		    silverlight_xap_url: '/Public/Default/aceadmin/js/plupload/Moxie.xap', //silverlight文件地址
		    filters: {
		        max_file_size: '5mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
		        mime_types: [{
		        		title: "files", 
		        		extensions: "jpg,png,gif"
		        	}]
		    },
		    multi_selection: true, //true:ctrl多文件上传, false 单文件上传
		    init: {
		        FilesAdded: function(up, files) { //文件上传前
		            if ($("#ul_pics").children("li").length > 30) {
		                alert("您上传的图片太多了！");
		                uploader.destroy();
		            } else {
		                var li = '';
		                plupload.each(files, function(file) { //遍历文件
		                    li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
		                });
		                var id = $("input[name='fid']").attr("value");
		                $("#ul_pics" + id).append(li);
		                uploader.start();
		            }
		        },
		        UploadProgress: function(up, file) { //上传中，显示进度条 
		        	var percent = file.percent;
		            $("#" + file.id).find('.bar').css({"width": percent + "%"});
		            $("#" + file.id).find(".percent").text(percent + "%");
		        },
		        FileUploaded: function(up, file, info) { //文件上传成功的时候触发
		            var data = JSON.parse(info.response);
		            var b = data['name'];	//上传图片的名称
					var fname = $("input[name='fname']").attr("value");
		            var c = data['pic_path']//"/Uploads/gimg/" + b;		//上传图片的相对路径
		            var a = "<input type=\"hidden\" name=\"fileImg[]\" value=\"" + c + "\">";
					var g = "<a href=\"javascript:void(0);\" class=\"imgEdit h40 lh40 wp100 fl ta_c\"><i class=\"icon-edit fs18 col-222\"></i></a>"
		            var l = "<a href=\"javascript:void(0);\" class=\"imgLeft h40 lh40 wp50 fl ta_c\"><i class=\"icon-arrow-left fs18 col-222\"></i></a>";
		            var r = "<a href=\"javascript:void(0);\" class=\"imgRight h40 lh40 wp50 fl ta_c\"><i class=\"icon-arrow-right fs18 col-222\"></i></a>";
		            var e = "<a href=\"javascript:void(0);\" class=\"imgDelete h40 lh40 wp100 fl ta_c\"><i class=\"icon-trash fs18 col-222\"></i></a>"
		            var d = "<div class=\"pa t0 l0 opacity70 dis-n bg-c-eee pt20 divMask\" style=\"width:154px;height:155px\">" + g + l + r + e + "</div>";
		            var f = "<div class='data1'><input type=\"hidden\" name='explanation[]' value='"+fname+"'/></div>";
					var h = "<div class='data2'><input type=\"hidden\" name='url[]' value=''/></div>";
					$("#" + file.id).html("<div class='img pr jsImg'><img src='" + c + "'/>" + a + d + "</div>" + f + h);
		        },
		        Error: function(up, err) { //上传出错的时候触发
		            alert(err.message);
		        }
		    },
		});

		uploader.init();
	}
	
});