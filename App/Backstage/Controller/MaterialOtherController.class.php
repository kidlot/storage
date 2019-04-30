<?php

namespace Backstage\Controller;
use Backstage\Controller\AdminBaseController;
use Org\Wechat\WechatApi;
/**
 * 其它素材
 */
class MaterialOtherController extends AdminBaseController {
	public function index() {
		$weixin_material_other = M ( 'weixin_material_other' );
		$map = array();
		$page = I ( 'p', 1, 'intval' );
		$row = 10;
		$title = I ( 'title' );
		if (! empty ( $title )) {
			$map ['name'] = array (
					'like',
					"%$title%"
			);
		}
		$type = I ( 'type' );
		if(!in_array($type, ['image','video','voice'])){
			$type = 'image';
		}
		$map ['type'] = array (
				'eq',
				$type
		);
		$list = $weixin_material_other->where ( $map )->order ( 'update_time desc' )->page ( $page, $row )->select ();
		/* 查询记录总数 */
		$count = $weixin_material_other->where ( $map )->count ();
		// 分页
		if ($count > $row) {
			$page = new \Think\Page ( $count, $row );
			$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
			$this->assign ( '_page', $page->show () );
		}
		$this->assign ( 'list_data', $list );
		$this->assign ( '_type', $type );
		$this->display ();
	}
	public function material_data() {
		$weixin_material_other = M ( 'weixin_material_other' );
		$type = I ( 'type' );
		if(!in_array($type, ['image','video','voice'])){
			$type = 'image';
		}
		$map ['type'] = array (
				'eq',
				$type
		);
		$list = $weixin_material_other->where ( $map )->order ( 'update_time desc' )->select ();
		// dump ( $list );
		$this->assign ( 'list_data', $list );
		// 弹框数据
		$this->display ();
	}

	public function syc_other_from_wechat() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		$type = I('type');
		if($type == 2){
			$type1 = 'video';
			$typename = "下载微信素材【视频】中，请勿关闭";
		}elseif($type == 3){
			$type1 = 'voice';
			$typename = "下载微信素材【语音】中，请勿关闭";
		}else{
			$type = 1;
			$type1 = 'image';
			$typename = "下载微信素材【图片】中，请勿关闭";
		}
		$param ['type'] = $type1;
		$param ['offset'] = I ( 'offset', 0, 'intval' );
		$param ['count'] = 10;
		$list = WechatApi::materialBatchGet ($param ['type'], $param ['offset'], $param ['count']);
		if ($list ['status'] != 1) {
			$this->error ( $list["message"] );
		}
		if (empty ( $list["data"]['item'] )) {
			if($type == 1){
				$url = U ( 'syc_other_from_wechat', array (
						'type' =>  2
				) );
				unset($list);
				$this->success ( $typename, $url , 6);
			}elseif($type == 2){
				$url = U ( 'syc_other_from_wechat', array (
						'type' =>  3
				) );
				unset($list);
				$this->success ( $typename, $url , 6);
			}else{
				$this->success ( '下载素材完成', U ( 'index') );
				exit ();
			}
		}
		$weixin_material_other = M ( 'weixin_material_other' );
		$has = $weixin_material_other->getField ( 'DISTINCT media_id,id' );
		$IMG_SITE_URL = C("IMG_SITE_URL");
		$arr = [];
		foreach ( $list["data"]['item'] as $j =>$item ) {
			$media_id = $item ['media_id'];
			if (isset ( $has [$media_id] ))
				continue;
			$item ['type'] = $type1;
			$item ['name'] = json_encode($item ['name']);
			if ($type1 == 'image') {
				$coner = WechatApi::materialGet($type1, $media_id, time() . $j . ".jpg");
				$picdata = myGetImageSize($IMG_SITE_URL . $coner['data'], "curl", true);
				if(0 == $picdata["size"]){
					$coner = _download_imgage($vo["thumb_url"], time() . $j . ".jpg");
				}
				$item ['cover_id'] = $this->_get_img_coverid($coner['data']);
			}else{
				$item ['cover_id'] = 0;
			}
			$arr[] = $item;
		}
		if(!empty($arr)){
			$weixin_material_other->addAll($arr);
		}
		$url = U ( 'syc_other_from_wechat', array (
				'offset' =>  $param ['offset'] + $list["data"]['item_count'],
				'type' =>  $type
		) );
		unset($list);
		$this->success ( $typename, $url , 6);
	}
	private function _get_img_coverid($picUrl = '') {
		$cover_id = 0;
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