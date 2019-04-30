<?php

namespace Backstage\Controller;
use Backstage\Controller\AdminBaseController;
use Org\Wechat\WechatApi;
/**
 * 图文管理控制器
 */
class MaterialNewsController extends AdminBaseController {
	/**
	 * 图文首页，从数据库读取数据
	 */
	public function index() {
		//判断是否编辑
		$map ['group_id'] = I ( 'group_id', 0, 'intval' );
		$weixin_material_news = M ( 'weixin_material_news' );
		if (! empty ( $map ['group_id'] )) {
			$list = $weixin_material_news ->where ( $map )->order ( 'id asc' )->select ();
			$count = count ( $list );

			$main = $list [0];
			unset ( $list [0] );
			if (! empty ( $list )) {
				$others = $list;
			}

			$this->assign ( 'main', $main );
			$this->assign ( 'others', $others );
			$this->assign ( 'group_id', $map ['group_id'] );
		}
		else{
			unset($map);
			$map = array();
			$page = I ( 'p', 1, 'intval' );
			$row = 10;
			$title = I ( 'title' );
			if (! empty ( $title )) {
				$map ['title'] = array (
						'like',
						"%$title%"
				);
			}
			
			$field = 'id,title,cover_id,intro,group_id,url';
			$list = $weixin_material_news->where ( $map )->field ( $field . ',count(id) as count' )->group ( 'group_id' )->order ( 'group_id desc' )->page ( $page, $row )->select ();
			foreach ( $list as &$vo ) {
				if ($vo ['count'] == 1)
					continue;

				$map2 ['group_id'] = $vo ['group_id'];
				$map2 ['id'] = array (
						'exp',
						'!=' . $vo ['id']
				);

				$vo ['child'] = $weixin_material_news->field ( $field )->where ( $map2 )->select ();
			}
			/* 查询记录总数 */
			$count = $weixin_material_news->where ( $map )->count ( 'distinct group_id' );
			// 分页
			if ($count > $row) {
				$page = new \Think\Page ( $count, $row );
				$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
				$this->assign ( '_page', $page->show () );
			}
			$this->assign ( 'list_data', $list );
		}
		$this->display ();
	}

	//新增
	public function doAdd() {
		$textArr = array (
				1 => '一',
				2 => '二',
				3 => '三',
				4 => '四',
				5 => '五',
				6 => '六',
				7 => '七',
				8 => '八',
				9 => '九',
				10 => '十'
		);
		$data = json_decode ( I("dataStr","",""), true );
		$ids = array ();
		$weixin_material_news = M ( 'weixin_material_news' );
		$PIC_FTP_SAVE = C("PIC_FTP_SAVE");
		foreach ( $data as $key => $vo ) {
			$save = array ();
			foreach ( $vo as $k => &$v ) {
				if ($v ['name'] == "intro") {
					$v ['value'] = json_encode($v ['value']);
				}
				$save [$v ['name']] = safe ( $v ['value'] );
			}
			if (empty ( $save ['title'] )) {
				$this->error ( '请填写第' . $textArr [$key + 1] . '篇文章的标题' );
			}
			if (empty ( $save ['cover_id'] )) {
				$this->error ( '请上传第' . $textArr [$key + 1] . '篇文章的封面图片' );
			}
			if (! empty ( $save ['id'] )) { // 更新数据
				$list = $weixin_material_news->field('media_id, thumb_media_id')->where("id=" . $save ['id'])->find();
				if(!empty($list)){
					if(empty($list["thumb_media_id"])){
						$save["media_id"] = md5($save["author"]);
					}
					$map2 ['id'] = $save ['id'];
					$res = $weixin_material_news->where ( $map2 )->save ( $save );
					if($res){
						$path = get_cover($save ['cover_id'], "path");
						if($PIC_FTP_SAVE){
			                //删除本服务器图片
			                ftpFile($path);
			                unlink($_SERVER['DOCUMENT_ROOT'] . $path);
			            }
			            S($list["media_id"], null);
					}
					
				}
				
			} else { // 新增加
				$save ['ctime'] = time();
				if(empty($save["media_id"]) || $save["media_id"] == 0){
					$save["media_id"] = md5($save["author"]);
				}
				$id = $weixin_material_news->add ( $save );
				if ($id) {
					$ids [] = $id;
					$path = get_cover($save ['cover_id'], "path");
					if($PIC_FTP_SAVE){
		                //删除本服务器图片
		                ftpFile($path);
		                unlink($_SERVER['DOCUMENT_ROOT'] . $path);
		            }
				} else {
					if (! empty ( $ids )) {
						$map ['id'] = array (
								'in',
								$ids
						);
						$weixin_material_news->where ( $map )->delete ();
					}
					$this->error ( '增加第' . $textArr [$key + 1] . '篇文章失败，请检查数据后重试' );
				}
			}
		}
		
		if (! empty ( $ids )) {
			$map ['id'] = array (
					'in',
					$ids
			);
			$group_id = I ( 'get.group_id', 0, 'intval' );
			if(empty ( $group_id )){
				$group_id = $ids [0];
			}
			else{
				$list = $weixin_material_news->distinct(true)->field('media_id')->where("group_id=" . $group_id)->find();
				if(!empty($list)){
					$weixin_material_news->where ( $map )->setField ( 'media_id', $list["media_id"] );
					S($list["media_id"], null);
				}
			}
			$weixin_material_news->where ( $map )->setField ( 'group_id', $group_id );
		}

		$this->success ( '操作成功', U ( 'index'));
	}
	//删除
	public function del_material_by_groupid() {
		$map ['group_id'] = I ( 'group_id' );
		$res =  M ( 'weixin_material_news' )->where ( $map )->delete ();
		if ($res) {
			$this->success ( '删除成功', U ( 'index'));
		} else {
			$this->error ( '删除失败' );
		}
	}
	public function material_data() {
		$field = 'id,title,cover_id,intro,group_id,media_id,ctime,group_id';
		$weixin_material_news = M ( 'weixin_material_news' );
		$map["thumb_media_id"] = array("neq", "");
		$list = $weixin_material_news->where ( $map )->field ( $field . ',count(id) as count' )->group ( 'group_id' )->order ( 'group_id desc' )->select ();

		foreach ( $list as &$vo ) {
			if ($vo ['count'] == 1)
				continue;

			$map2 ['group_id'] = $vo ['group_id'];
			$map2 ['id'] = array (
					'exp',
					'!=' . $vo ['id']
			);

			$vo ['child'] = $weixin_material_news->field ( $field )->where ( $map2 )->select ();
		}
		// dump ( $list );
		$this->assign ( 'list_data', $list );
		// 弹框数据
		$this->display ();
	}

	public function syc_news_from_wechat() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		$param ['type'] = 'news';
		$param ['offset'] = I ( 'offset', 0, 'intval' );
		$param ['count'] = 10;
		$list = WechatApi::materialBatchGet ($param ['type'], $param ['offset'], $param ['count']);
		if ($list ['status'] != 1) {
			$this->error ( $list["message"] );
		}
		if (empty ( $list["data"]['item'] )) {
			$this->success ( '下载素材完成', U ( 'index') );
			exit ();
		}
		$map ['media_id'] = array (
				'in',
				getSubByKey ( $list["data"]['item'], 'media_id' )
		);
		$weixin_material_news = M ( 'weixin_material_news' );
		$has = $weixin_material_news->getField ( 'DISTINCT media_id,id' );
		$PIC_FTP_SAVE = C("PIC_FTP_SAVE");
		$IMG_SITE_URL = C("IMG_SITE_URL");
		foreach ( $list["data"]['item'] as $j =>$item ) {
			$media_id = $item ['media_id'];
			if (isset ( $has [$media_id] ))
				continue;

			$ids = array ();
			foreach ( $item ['content'] ['news_item'] as $k => $vo ) {
				$data ['title'] = $vo ['title'];
				$data ['author'] = $vo ['author'];
				$data ['intro'] = json_encode($vo ['digest']);
				//$data ['content'] = $vo ['content'];
				$data ['thumb_media_id'] = $vo ['thumb_media_id'];
				$data ['media_id'] = $media_id;
				$coner = WechatApi::materialGet("image", $data ['thumb_media_id'], time() . $j . $k . ".jpg");
				$picdata = myGetImageSize($IMG_SITE_URL . $coner['data'], "curl", true);
				if(0 == $picdata["size"]){
					$coner = _download_imgage($vo["thumb_url"], time() . $j . $k . ".jpg");
				}
				if($PIC_FTP_SAVE){
					//删除本服务器图片
					ftpFile($coner['data']);
					unlink($_SERVER['DOCUMENT_ROOT'] . $coner['data']);
				}
				$data ['cover_id'] = $this->_get_img_coverid($coner['data']);
				$data ['url'] = $vo ['url'];
				$data ['ctime'] = time();
				$ids [] = $weixin_material_news->add ( $data );
			}

			if (! empty ( $ids )) {
				$map2 ['id'] = array (
						'in',
						$ids
				);
				$weixin_material_news->where ( $map2 )->setField ( 'group_id', $ids [0] );
			}
		}
		$url = U ( 'syc_news_from_wechat', array (
				'offset' =>  $param ['offset'] + $list["data"]['item_count']
		) );
		unset($list);
		$this->success ( '下载微信素材中，请勿关闭', $url , 6);
	}

	private function _get_img_coverid($picUrl = '') {
		if (!empty($picUrl)) {
			// 保存记录，添加到picture表里，获取coverid
			$data["path"] = $picUrl;
			$data["status"] = 1;
			$data["create_time"] = time();
			$info = D ( 'Picture' )->data($data)->add();
			$cover_id = $info;
		}
		return $cover_id;
	}

}