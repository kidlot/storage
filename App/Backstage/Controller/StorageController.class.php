<?php

/**
 * 字典列表
 */
namespace Backstage\Controller;
use Backstage\Controller\AdminBaseController;

class StorageController extends AdminBaseController {
    public function index() {
        $page = I ( 'p', 1, 'intval' );
		if($page < 1){
			$page = 1;
		}
		$row = 20;
    	$goods_sn = I ( 'goods_sn' );
		$goods_name = I ( 'goods_name' );
    	$map = array();
		if (! empty ( $goods_sn )) {
			$map ['goods_sn'] = array("eq", $goods_sn);
		}
		$this->assign("goods_sn", $goods_sn);
		if (! empty ( $goods_name )) {
			$map ['goods_name'] = array("like", "%$goods_name%");
			$this->assign("goods_name", $goods_name);
		}
		$Goods = M( 'Goods' );
        $list = $Goods->where($map)->page ( $page, $row )->order("update_time desc")->select ();
		$count = $Goods->where($map)->count();
        // 分页
		if ($count > $row) {
			$page = new \Think\Page ( $count, $row );
			$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
			$this->assign ( '_page', $page->show () );
		}
		$this->assign ( '_count', $count );
		$this->assign("_list", $list);
		$this->display();
    }
	public function add() {
        $data = I('post.');
        unset($data['id']);
		$data['create_time'] = time_format();
		$id = M('Goods')->add($data);
        $this->success('添加成功', U('index'));
    }

    public function edit() {
		$data = I('post.');
        $map = [
            'id' => $data['id'],
		];
		$check = M('Goods')->where($map)->find();//原商品
		if($check['goods_sn'] != $data['goods_sn']){
			$res = M('Goods_storage')->where(['goods_sn'=>$check['goods_sn']])->data(['goods_sn'=>$data['goods_sn']])->save();
		}
		$data['update_time']=date("Y-m-d H:i:s",time());
		$res = M('Goods')->where($map)->data($data)->save();
		
        $this->success('修改成功', U('index'));
    }

    public function delete() {
        $goods_sn = I('get.goods_sn');
        $map = [
            'goods_sn' => $goods_sn,
        ];
		$res = M('Goods')->where($map)->delete();
		$res = M('Goods_storage')->where($map)->delete();
        $this->success('删除成功', U('index'));
	}
	
	public function get_sku(){
		$goods_sn = I('post.goods_sn');
        $map = [
            'goods_sn' => $goods_sn,
		];		
		if(!empty($goods_sn)){
			$res = M('Goods_storage')->where($map)->order("size")->select();
			ajax_return($res,"success",0);
		}

	}


	public function update_storage(){
		$goods_size_id = I('post.goods_size_id');
		$storage = I('post.storage');
		$size = I('post.size');
		$color = I('post.color');
		$goods_sn = I('post.goods_sn');

		if(empty($goods_size_id)){
			$check = M('Goods_storage')->where(["size"=>$size,"color"=>$color,"goods_sn"=>$goods_sn])->find();
			if($check){
				ajax_return($res,"fail",-2);
			}			
			$data = array("storage"=>$storage,"size"=>$size,"color"=>$color,"goods_sn"=>$goods_sn);
			$id = M('Goods_storage')->add($data);
			if($id){
				ajax_return($id,"success",0);
			}else{
				ajax_return($id,"fail",-1);
			}
		}else{
			$check = M('Goods_storage')->where(["size"=>$size,"color"=>$color,"goods_sn"=>$goods_sn,"id"=>array('neq', $goods_size_id)])->find();
	
			if($check){
				ajax_return($res,"fail",-2);
			}
			$map = [
				'id' => $goods_size_id,
			];
			$data = array("storage"=>$storage,"size"=>$size,"color"=>$color);
			$res = M('Goods_storage')->where($map)->data($data)->save();
			//echo M('Goods_storage')->getLastSql();
			if($res){
				ajax_return($res,"success",0);
			}else{
				ajax_return($res,"fail",-1);
			}
		}

	}



	public function del_storage(){
		$goods_size_id = I('post.goods_size_id');;
        $map = [
            'id' => $goods_size_id,
        ];
		$res = M('Goods_storage')->where($map)->delete();
		if($res){
			ajax_return($res,"success",0);
		}else{
			ajax_return($res,"fail",-1);
		}		
	}
}
