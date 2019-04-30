<?php

namespace Backstage\Controller;
use Backstage\Controller\AdminBaseController;
use Org\Wechat\WechatApi;
/**
 * 自动回复控制器
 */
class AutoReplyController extends AdminBaseController {
	/**
	 * 这是三种回复1、被添加回复2、自动回复3、关键字回复
	 */
	public function index() {
		$this->display();
	}
	/**
	 * 这是三种回复2、自动回复3、关键字回复
	 */
	public function beadded() {
		$this->display();
	}
	/**
	 * 这是三种回复3、关键字回复
	 */
	public function keywords() {
		$page = I ( 'p', 1, 'intval' );
		$row = 20;
		$AutoReply = M("AutoReply");
		$map["msg_type"] = "keywords";
		$maplist["msg_type"] = "keywords";
		$weixin_material_news = M ( 'weixin_material_news' );
		$field = 'id,title,cover_id,intro,group_id, ctime, media_id';
		$list = $AutoReply->where ( $maplist )->order("sort desc, create_time desc")->page ( $page, $row )->select ();
		foreach ($list as &$value) {
			if($value["type"] == "news"){
				$map["type"] = "news";
				$map["media_id"] = $value["media_id"];
                $mdata = $weixin_material_news->where ( $map )->field ( $field . ',count(id) as count' )->group ( 'group_id' )->select ();
                foreach ( $mdata as &$vo ) {
                    $vo["ctime"] = time_format($vo["ctime"], "m月d日");
                    $vo["pic"] = get_cover_url($vo["cover_id"]);
                    $vo["intro"] = json_decode($vo["intro"]);
                    if ($vo ['count'] == 1)
                        continue;
                    $map2 ['group_id'] = $vo ['group_id'];
                    $map2 ['id'] = array (
                            'exp',
                            '!=' . $vo ['id']
                    );
                    $vo ['child'] = $weixin_material_news->field ( $field )->where ( $map2 )->select ();
                    foreach ( $vo ['child'] as $k => $item ) {
                        $vo ['child'][$k]["pic"] = get_cover_url($item["cover_id"]);
                    }
                }
                $value["data"] = $mdata;
			}elseif($value["type"] == "image"){
				$map["type"] = "image";
				$map["media_id"] = $value["media_id"];
				$weixin_material_other = M ( 'weixin_material_other' );
				$mdata = $weixin_material_other->where ( $map )->select ();
				$value["data"] = $mdata;
			}
			if(empty($value["type"]) || empty($value["title"]) || empty($value["keyword"])){
 				$value["isadd"] = 1;
			}
		}
		$countm = $AutoReply->where ( $maplist )->count ( 'distinct id' );
		// 分页
		if ($countm > $row) {
			$page = new \Think\Page ( $countm, $row );
			$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
			$this->assign ( '_page', $page->show () );
		}
		$this->assign("_list", $list);
		$this->display();
	}
	/**
	 * 更新自动回复
	 * type=news是保存图文=text保存文字
	 */
	public function edit() {
		$isadd = I("isadd");
		
		$type = I("type");
		$value = I("value");
		$page = I("page");
		$msg["status"] = -1;
		$msg["info"] = "数据不完整";
		if(empty($isadd)){
			if(empty($type) || empty($value)){
				$this->ajaxReturn($msg);
			}
		}
		
		$AutoReply = M("AutoReply");
		//被添加回复
		if(0 == $page && ("news" == $type || "image" == $type || "text" == $type)){
			$map["msg_type"] = "index";
			$map["keyword"] = "welcome";
			$count = $AutoReply->where($map)->count();
			if(0 == $count){
				$data["keyword"] = "welcome";
				$data["msg_type"] = "index";
				$data["type"] = $type;
				if("news" == $type || "image" == $type){
					$data["media_id"] = $value;
				}else{
					$data["content"] = $value;
				}
				$data['create_time'] = time();
				$res = $AutoReply->data($data)->add();
			}
			else{
				$data["type"] = $type;
				if("news" == $type || "image" == $type){
					$data["media_id"] = $value;
				}else{
					$data["content"] = $value;
				}
				$data['create_time'] = time();
				$res = $AutoReply->data($data)->where($map)->save();
			}
			if($res){
				$msg["status"] = 1;
				$msg["info"] = "保存成功";
				//清楚缓存
				S("auto_reply_welcome", null);
			}
			else{
				$msg["status"] = -1;
				$msg["info"] = "保存失败";
			}
			
		}else if(1 == $page && ("news" == $type || "image" == $type || "text" == $type)){
			$map["msg_type"] = "beadded";
			$map["keyword"] = "autoreply";
			$count = $AutoReply->where($map)->count();
			if(0 == $count){
				$data["keyword"] = "autoreply";
				$data["msg_type"] = "beadded";
				$data["type"] = $type;
				if("news" == $type || "image" == $type){
					$data["media_id"] = $value;
				}else{
					$data["content"] = $value;
				}
				$data['create_time'] = time();
				$res = $AutoReply->data($data)->add();
			}
			else{
				$data["type"] = $type;
				if("news" == $type || "image" == $type){
					$data["media_id"] = $value;
				}else{
					$data["content"] = $value;
				}
				$data['create_time'] = time();
				$res = $AutoReply->data($data)->where($map)->save();
			}
			if($res){
				$msg["status"] = 1;
				$msg["info"] = "保存成功";
				S("auto_reply_autoreply", null);
			}
			else{
				$msg["status"] = -1;
				$msg["info"] = "保存失败";
			}
		}else if(2 == $page && ("news" == $type || "image" == $type || "text" == $type)){
			if(empty($isadd)){
				$id = I("id");
				$title = I("title");
				$keyword = I("keyword");
				$mode = I("mode", 0);
				
				$map["msg_type"] = "keywords";
				$map["id"] = $id;
				$data["title"] = $title;
				$data["keyword"] = $keyword;
				$data["type"] = $type;
				$data["sort"] = 0;
				$data["mode"] = $mode;
				$data['create_time'] = time();

				if("news" == $type || "image" == $type){
					$data["media_id"] = $value;
				}else{
					$data["content"] = $value;
				}
				$rej = $AutoReply->where($map)->find();
				if(!empty($rej)){
					//关键字清除缓存
					if(!empty($rej["keyword"])){
						$keyarr = explode(",", $rej["keyword"]);
						foreach($keyarr as $item){
							S("auto_reply_keyword_" . md5($item), null);
						}
					}
					$res = $AutoReply->data($data)->where($map)->save();
				}
				else{
					$res = false;
				}
			}else{
				$data["msg_type"] = "keywords";
				$data['sort'] = 9999;
				$data['mode'] = 0;
				$count = $AutoReply->where($data)->count();
				if(0 == $count){
					$data['create_time'] = time();
					$res = $AutoReply->data($data)->add();
				}
				else{
					$msg["status"] = -2;
					$msg["info"] = "请先处理红色部分";
					$this->ajaxReturn($msg);
				}
				
			}
			$msg["url"] = U("keywords",array("p", I("p")));
			if($res){
				$msg["status"] = 1;
				$msg["info"] = "保存成功";
			}
			else{
				$msg["status"] = -1;
				$msg["info"] = "保存失败";
			}
		}
		$this->ajaxReturn($msg);
	}
	public function getdata() {
		$page = I("page", 0);
		$msg["status"] = -1;
		$msg["info"] = "无数据";
		$AutoReply = M("AutoReply");
		if(0 == $page || 1 == $page){
			if(0 == $page){
				$map["keyword"] = "welcome";
				$map["msg_type"] = "index";
			}else{
				$map["keyword"] = "autoreply";
				$map["msg_type"] = "beadded";
			}
			
			$list = $AutoReply->where($map)->select();
			$num = count($list);
			if($num > 0){
				if($list[0]["type"] == "news"){
					$map["type"] = "news";
					$map["media_id"] = $list[0]["media_id"];
					$weixin_material_news = M ( 'weixin_material_news' );
					$field = 'id,title,cover_id,intro,group_id, ctime, media_id';
	                $mdata = $weixin_material_news->where ( $map )->field ( $field . ',count(id) as count' )->group ( 'group_id' )->select ();
	                foreach ( $mdata as &$vo ) {
	                    $vo["ctime"] = time_format($vo["ctime"], "m月d日");
	                    $vo["pic"] = get_cover_url($vo["cover_id"]);
	                    $vo["intro"] = json_decode($vo["intro"]);
	                    if ($vo ['count'] == 1)
	                        continue;
	                    $map2 ['group_id'] = $vo ['group_id'];
	                    $map2 ['id'] = array (
	                            'exp',
	                            '!=' . $vo ['id']
	                    );
	                    $vo ['child'] = $weixin_material_news->field ( $field )->where ( $map2 )->select ();
	                    foreach ( $vo ['child'] as $k => $item ) {
	                        $vo ['child'][$k]["pic"] = get_cover_url($item["cover_id"]);
	                    }
	                }
	                $list[0]["data"] = $mdata;
				}elseif($list[0]["type"] == "image"){
					$map["type"] = "image";
					$map["media_id"] = $list[0]["media_id"];
					$weixin_material_other = M ( 'weixin_material_other' );
	                $mdata = $weixin_material_other->where ( $map )->select ();
					foreach ( $mdata as &$vo ) {
						$vo["update_time"] = time_format($vo["update_time"], "m月d日");
	                    $vo["url"] = get_cover_url($vo["cover_id"]);
	                    $vo["name"] = json_decode($vo["name"]);
					}
	                $list[0]["data"] = $mdata;
				}
				$msg["status"] = 1;
				$msg["data"] = $list;
				$msg["info"] = $num;
			}
		}
		else if(2 == $page){
			$map["keyword"] = "welcome";
			$list = $AutoReply->where($map)->select();
		}
		$this->ajaxReturn($msg);
	}

	public function delete() {
		$page = I("page", 0);
		$msg["status"] = -1;
		$msg["info"] = "删除失败";
		$AutoReply = M("AutoReply");
		if(0 == $page){
			$map["keyword"] = "welcome";
			$keyword = $map["keyword"];
			$map["msg_type"] = "index";
			$res = $AutoReply->where($map)->delete();
		}
		else if(1 == $page){
			$map["keyword"] = "autoreply";
			$keyword = $map["keyword"];
			$map["msg_type"] = "beadded";
			$res = $AutoReply->where($map)->delete();
		}
		else if(2 == $page){
			$id = I("id");
			if(empty($id)){
				$res = "";
			}
			else{
				$map["id"] = $id;
				$map["msg_type"] = "keywords";
				$rej = $AutoReply->where($map)->find();
				if(!empty($rej) && !empty($rej["keyword"])){
					$keyarr = explode(",", $rej["keyword"]);
					foreach($keyarr as $item){
						S("auto_reply_keyword_" . md5($item), null);
					}
					$res = $AutoReply->where($map)->delete();
				}
				else{
					$res = false;
				}
				
			}
		}

		if($res){
			$msg["status"] = 1;
			$msg["info"] = "删除成功";
			if(2 == $page){
				$msg["url"] = U("keywords",array("p", I("p")));
				//删除之后清楚对应缓存
			}
			else{
				//删除之后清楚对应缓存
				S("auto_reply_" . $keyword, null);
			}
		}
		else{
			$msg["status"] = -1;
			$msg["info"] = "删除失败";
		}

		$this->ajaxReturn($msg);
	}
}