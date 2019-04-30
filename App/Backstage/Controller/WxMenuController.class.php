<?php

namespace Backstage\Controller;
use Backstage\Controller\AdminBaseController;

/**
 * 自定义菜单控制器
 */
class WxMenuController extends AdminBaseController {

    /**
     * 首页
     */
    public function index() {
        $list = M ( 'Type' )->order ( 'sort, updatetime' )->select ();
		$this->assign("data", $list);
		$this->display();
    }

	/**
	 * 添加模块
	 */
	public function add(){
		$Type = D('Type');
		$count = $Type->count();
		if($count > 4){
			$this->error('添加失败，类型不能超过5个');
		}
		$data=I('post.');
		$data["updatetime"] = time_format(time());
		unset($data['id']);
		$Type->addData($data);
		$this->success('添加成功',U('index'));
	}

	/**
	 * 修改
	 */
	public function edit(){
		$data=I('post.');
		$map=array(
			'id'=>$data['id']
			);
		$data["updatetime"] = time_format(time());
		D('Type')->editData($map,$data);
		$this->success('修改成功',U('index'));
	}

	/**
	 * 删除
	 */
	public function delete(){
		$id=I('get.id');
		$map=array(
			'id'=>$id
			);
		$result=D('Type')->deleteData($map);
		if($result){
			$this->success('删除成功',U('index'));
		}else{
			$this->error('删除失败');
		}
	}
}
