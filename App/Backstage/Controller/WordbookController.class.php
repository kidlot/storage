<?php

/**
 * 字典列表
 */
namespace Backstage\Controller;
use Backstage\Controller\AdminBaseController;

class WordbookController extends AdminBaseController {
    public function index() {
        $page = I ( 'p', 1, 'intval' );
		if($page < 1){
			$page = 1;
		}
		$row = 20;
    	$type = I ( 'type' );
    	$name = I ( 'name' );
    	$status = I ( 'status' );
    	$map = array();
		if (! empty ( $type )) {
			$map ['type'] = array("eq", $type);
		}
		$this->assign("_type", $type);
		if (! empty ( $name )) {
			$map ['name'] = array("like", "%$name%");
			$this->assign("_name", $name);
		}
		if ($status !== '') {
			$map ['status'] = array("eq", $status);
		}
		$this->assign("_status", $status);
		$sys_wordbook = M( 'sys_wordbook' );
        $list = $sys_wordbook->where($map)->page ( $page, $row )->order("utime desc")->select ();
		$count = $sys_wordbook->where($map)->count();
        // 分页
		if ($count > $row) {
			$page = new \Think\Page ( $count, $row );
			$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
			$this->assign ( '_page', $page->show () );
		}
		$this->assign ( '_count', $count );
		$this->assign("_list", $list);
		$this->assign("_typelist", $sys_wordbook->distinct(true)->field('type')->select());
		$this->display();
    }
	public function add() {
        $data = I('post.');
        unset($data['id']);
		$data['utime'] = time_format();
        D('sys_wordbook')->addData($data);
        $this->success('添加成功', U('index'));
    }

    public function edit() {
        $data = I('post.');
        $map = [
            'id' => $data['id'],
        ];
        D('sys_wordbook')->updateData($map, $data);
        $this->success('修改成功', U('index'));
    }

    public function delete() {
        $id = I('get.id');
        $map = [
            'id' => $id,
        ];
        D('sys_wordbook')->removeData($map);
        $this->success('删除成功', U('index'));
    }
}
