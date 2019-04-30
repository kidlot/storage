<?php

/**
 * 字典列表
 */
namespace Backstage\Controller;
use Backstage\Controller\AdminBaseController;

class OutboundController extends AdminBaseController {
    public function index() {
        $page = I ( 'p', 1, 'intval' );
		if($page < 1){
			$page = 1;
		}
		$row = 20;
    	$map = array();

		$Out = M( 'Out' );
        $list = $Out->where($map)->page ( $page, $row )->order("out_time desc")->select ();
		$count = $Out->where($map)->count();
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
        $id = I('get.id');
        $map = [
            'id' => $id,
        ];
		$res = M('Out')->where($map)->delete();
		$res = M('Out_detail')->where(['out_id'=>$id])->delete();
        $this->success('删除成功', U('index'));
	}
	
	public function get_sku(){
		$sku = I('post.sku');
		$sku_arr = explode("-",$sku);
		if(3 != count($sku_arr)){
			ajax_return("fail",-1);//数据输入有问题
		}

		$data = M('Goods_storage')->where(["goods_sn"=>trim($sku_arr[0]),"color"=>trim($sku_arr[1]),"size"=>trim($sku_arr[2])])->select();
		if(!empty($data)){
			ajax_return($data,"success",0);
		}else{
			ajax_return("fail",-2);//没有数据
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


	public function do_outbound(){
		$out_arr = I('post.out_arr');
		$data_out = array("out_time"=> time_format(),"sn"=>'N'.time());
		M('Out')->startTrans();
		$flag = 0;
		$id = M('Out')->add($data_out);
		foreach($out_arr as $arr){
			$data_out_detail = array("out_id"=>$id,"sku_id"=>$arr['id'],"out_num"=>$arr['out_num']);
			$res1 = M('Out_detail')->add($data_out_detail);//日志
			$map = [
				'id' => $arr['id'],
			];
			$res2 = M('Goods_storage')->where($map)->setDec('storage',$arr['out_num']); // 扣减库存
			if(!$res1||!$res2){
				$flag ++;
			}
		}
		if($flag>0){
			M('Out')->rollback();
			ajax_return("fail",-1);
		}else{
			M('Out')->commit();
			ajax_return("success",0);
		}
		
	}


	public function print(){
		$id = I('get.id');
		$map = [
			'id' => $id
		];		
		$data['info'] = M('Out')->where($map)->find();
		$map = [
			'out_id' => $id
		];				
		$data['detail'] = M('Out_detail')->alias('od')->join(' LEFT JOIN tp_goods_storage gs on od.sku_id=gs.id')->join('LEFT JOIN tp_goods g on g.goods_sn=gs.goods_sn')->where($map)->select();

		$this->assign ( 'data', $data );
		$this->display();
	}
}
