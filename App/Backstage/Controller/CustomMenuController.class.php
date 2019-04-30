<?php
namespace Backstage\Controller;

use Org\Wechat\WechatApi;

class CustomMenuController extends AdminBaseController {
    public function index() {
        /*
         * 需要显示的信息
         * 1、公众号名称应为动态加载
         * 2、已创建过的菜单，应即时显示
         * 3、
         */
        //页面基本信息
        $title = c("WECHAT_CFG.title");
        $this->assign('title', $title);
        //获取菜单数据
        $menu = M('weixin_menu');
        //先找出所有一级菜单数据
        $map["pid"] = array("eq", 0);
        $list = $menu->field('uid, zhu_name')->where($map)->order('uid asc')->select();
        //子菜单查询
        $map["pid"] = array("neq", 0);
        $zi_list = $menu->field('uid, pid, zi_name')->where($map)->select();
        foreach ($list as $key => $value) {
            foreach ($zi_list as $zkey => $item) {
                if ($item["pid"] == $value["uid"]) {
                    $list[$key]["list"][] = $item;
                    unset($zi_list[$zkey]);
                }
            }
        }
        $this->assign('_list', $list);
        $this->assign('_listcount', count($list));
        $this->display();
    }

    //接受ajax传送的数据，进行组织、存储和显示
    public function ajaxData() {
        //接收ajax的传值
        $id = I("id");              //创建菜单时间判断（第一个字母为j则为子菜单，完整形式为j_m_1_0；第一个字母假如为z则为主菜单，完整形式为z_m_1）
        $pid = I("pid");             //主菜单id值
        $name = I("name");            //主菜单名称
        $menu_name = I("menu_name");       //子菜单名称
        $menu_type = I("menu_type");       //菜单响应类型（s_mess为发送消息；j_web为跳转网页）
        $type = I("type");            //菜单响应相关信息（图文消息（view_limited、media_id）、文字（click、key）、图片（media_id、media_id））
        $url = I("url");             //url响应（）
        $key = I("key");             //key响应（）
        $media_id = I("media_id");        //media_id响应（）
		$new_select = I("new_select");//用于图文跳转链接还是发送图文
        //事件类型判断
        /*
         * 条件一：通过传过来的id值的首字母进行判断，假如为j，则为创建子菜单；假如为z，则为创建主菜单；
         * 条件二：假如其为创建子菜单，保留其中的最后一个数字作为子菜单的顺序保存到id中，同时将其的对应主菜单的id值保存到pid中
         * 条件三：假如其为创建主菜单，保留其中的主菜单的id值得最后一个数字保存到id中，同时将pid保存为0
         * 条件四：判断事件的响应类型，根据menu_type字段，s_mess为发送消息；j_web为跳转网页（view，url）
         * 条件五：菜单响应相关信息（图文消息view_limited、文字key、图片media_id）
         * 条件六：
         */
        //主要用于更新操作
        $isedit = I("isedit");
        //实例化自定义菜单表
        $menu = M('weixin_menu');
        $tip = substr($id, 0, 1);
        $data['create_time'] = date('Y-m-d', time());        //创建时间
        if (empty($isedit)) {
            if ($tip == 'j') {  //子菜单创建事件
                $data['uid'] = substr($id, 6);
                $data['pid'] = substr($id, 4, 1);
                $data['zi_name'] = !empty($menu_name) ? $menu_name : "子菜单名称";
                $data['zhu_name'] = $name;
                $data['menu_type'] = 'sub_button';
            } else {  //主菜单创建事件
                $data['uid'] = substr($id, 4);
                $data['pid'] = 0;
                $data['zi_name'] = $name;
                $data['zhu_name'] = !empty($menu_name) ? $menu_name : "菜单名称";
                $data['menu_type'] = 'button';
            }
            //菜单事件类型组织
            if ($menu_type == 's_mess') {   //发送消息事件
                switch ($type) {
                    case '图文消息':
						if($new_select == 1){
							$data['type'] = 'view_limited';
						}else{
							$data['type'] = 'media_id';
						}
                        $data['type_media_id'] = $media_id;
                        break;
                    case '文字':
                        $data['type'] = 'click';
                        $data['type_key'] = $key;
                        break;
					case '图片':
                        $data['type'] = 'media_id';
                        $data['type_media_id'] = $media_id;
                        break;
                }
            } else if ($menu_type == 'j_web') {  //跳转网页事件
                $data['type'] = 'view';
                $data['type_url'] = $url;
            }
            $res = $menu->data($data)->add();
            if ($res) {
                $msg["status"] = 1;
                $msg["info"] = "菜单新增成功";
            } else {
                $msg["status"] = -1;
                $msg["info"] = "菜单新增失败";
            }
            //如果是子菜单进行清空上机菜单的内容
            if ($tip == 'j') {
                unset($data);
                $map['uid'] = substr($id, 4, 1);
                $map['pid'] = 0;
                $data["zi_name"] = "";
                $data["menu_type"] = "button";
                $data["type"] = "";
                $data["type_key"] = "";
                $data["type_url"] = "";
                $data["type_media_id"] = "";
                $menu->data($data)->where($map)->save();
            }

        } else if ("editname" == $isedit) {
            if ($tip == 'j') {  //子菜单修改事件
                $map['pid'] = substr($id, 4, 1);
                $map['uid'] = substr($id, 6);
                $data['zi_name'] = $menu_name;
            } else {  //主菜单修改事件
                $map['pid'] = 0;
                $map['uid'] = substr($id, 4);
                $data['zhu_name'] = $menu_name;
            }
            $res = $menu->data($data)->where($map)->save();
            if ($res) {
                $msg["status"] = 1;
                $msg["info"] = "菜单保存成功";
            } else {
                $msg["status"] = -1;
                $msg["info"] = "菜单保存失败";
            }
        } else if ("edit_menu_type" == $isedit) {
            if ($tip == 'j') {  //子菜单修改事件
                $map['pid'] = substr($id, 4, 1);
                $map['uid'] = substr($id, 6);
                $data['zi_name'] = $menu_name;
            } else {  //主菜单修改事件
                $map['pid'] = 0;
                $map['uid'] = substr($id, 4);
                $data['zhu_name'] = $menu_name;
            }
            //发送消息事件
            if ($menu_type == 's_mess') {
                switch ($type) {
                    case '图文消息':
                        if($new_select == 1){
							$data['type'] = 'view_limited';
						}else{
							$data['type'] = 'media_id';
						}
                        $data['type_media_id'] = $media_id;
                        break;
                    case '文字':
                        $data['type'] = 'click';
                        $data['type_key'] = $key;
                        break;
					case '图片':
                        $data['type'] = 'media_id';
                        $data['type_media_id'] = $media_id;
                        break;
                }
            } else if ($menu_type == 'j_web') {  //跳转网页事件
                $data['type'] = 'view';
                $data['type_url'] = $url;
            }

            $res = $menu->data($data)->where($map)->save();
            if ($res) {
                $msg["status"] = 1;
                $msg["info"] = "菜单保存成功";
            } else {
                $msg["status"] = -1;
                $msg["info"] = "菜单保存失败";
            }
        }
        $this->ajaxReturn($msg);
    }


    //创建自定义菜单
    public function createMenu() {
        /*
         * 自定义菜单创建逻辑
         * 1、首先判断创建的为主菜单还是子菜单。
         * 2、假如为主菜单，判断其是否已经创建过子菜单，假如有，则只能修改菜单名字，否则，等同于子菜单的创建；假如为子菜单，则需要选择创建类型
         * 3、创建类型判断：发送消息（图文消息、文字、图片、卡券）、跳转网页
         * 4、对于发送消息的类型，需要进行相关信息的收集
         */
        //对数据库中处理数据表进行处理的逻辑。
        /*
         * 1、根据数据库中的信息，选择最新的一天的信息作为创建自定义菜单的选择,将这部分数据作为选择的原始数据
         * 2、查询主菜单信息，组成数组，用到去重。
         * 3、查询子菜单信息，组成数组
         * 4、组织数据
         */

        //实例化menu表
        $menu = M('weixin_menu');
        //$create_time = $menu->order('create_time desc')->limit(1)->getField('create_time');
        //查询主菜单信息，组成数组，用到去重，排序
        $zhu_name = $menu->distinct(true)->where("pid=0")->field('zhu_name')->select();
        //dump($zhu_name);
        //根据查询到的对应的主菜单的名称，去数据库中找到数据表对应的pid；假如pid为0，则直接取其uid
        //主菜单数据名称组织

        $menu_data = array();
        foreach ($zhu_name as $key => $value) {
            $tip = $value['zhu_name'];
            //数组查询条件
            //$data['create_time'] = $create_time;
            $data['zhu_name'] = $tip;
            $pid = $menu->where($data)->getField('pid');
            if ($pid == 0) {
                $pid = $menu->where($data)->getField('uid');
            }
            $menu_data[$pid] = array();
            //此处直接进行数据的组织 根据pid找到对应的子菜单
            $zi_data['pid'] = $pid;
            //$zi_data['create_time'] = $create_time;
            $zi_menu_data = $menu->where($zi_data)->order('uid')->select();    //假如此数据为空，则证明没有子菜单；否则组织子菜单的信息
            if (!empty($zi_menu_data)) {          //组织子菜单数据
                $menu_data[$pid]['name'] = $tip;
                foreach ($zi_menu_data as $key => $value) {
                    //菜单的相应类型判断
                    switch ($value['type']) {
                        case 'view_limited':
                            $type = 'media_id';
                            $type_data = $value['type_media_id'];
                            break;
                        case 'media_id':
                            $type = 'media_id';
                            $type_data = $value['type_media_id'];
                            break;
                        case 'click':
                            $type = 'key';
                            $type_data = $value['type_key'];
                            break;
                        case 'view':
                            $type = 'url';
                            $type_data = $value['type_url'];
                            break;
                    }
                    $menu_data[$pid]['sub_button'][$key] = array(
                        'type' => $value['type'],
                        'name' => $value['zi_name'],
                        $type => $type_data
                    );
                }
            } else {                              //组织主菜单数据
                $zhu_data['uid'] = $pid;
                $zhu_data['pid'] = 0;
                //$zhu_data['create_time'] = $create_time;
                $zhu_menu_data = $menu->where($zhu_data)->find();
                $menu_data[$pid]['name'] = $tip;
                //菜单的相应类型判断
                switch ($zhu_menu_data['type']) {
                    case 'view_limited':
                        $z_type = 'media_id';
                        $z_type_data = $zhu_menu_data['type_media_id'];
                        break;
                    case 'media_id':
                        $z_type = 'media_id';
                        $z_type_data = $zhu_menu_data['type_media_id'];
                        break;
                    case 'click':
                        $z_type = 'key';
                        $z_type_data = $zhu_menu_data['type_key'];
                        break;
                    case 'view':
                        $z_type = 'url';
                        $z_type_data = $zhu_menu_data['type_url'];
                        break;
                }
                $menu_data[$pid]['type'] = $zhu_menu_data['type'];
                $menu_data[$pid][$z_type] = $z_type_data;

            }


        }

        ksort($menu_data);
        $menu_data = array_values($menu_data);
        //sort($menu_data);

        $zong_menu_data = array(
            'button' => $menu_data
        );
        //dump($zong_menu_data);

        $type = 'create';
        $res = WechatApi::menuCreate($zong_menu_data);
        if (1 == $res["status"] && 0 == $res["data"]["errcode"]) {
            $rej["status"] = 1;
            $rej["info"] = "发布成功";
        } else {
            $rej["status"] = -1;
            $rej["info"] = "发布失败" . $res["data"]["errmsg"];
        }
        $this->ajaxReturn($rej);

    }

    //删除自定义菜单（自定义菜单的删除接口会删除所有的自定义菜单）
    public function deleteMenu() {
        $id = I("id");
        $menu = M('weixin_menu');
        $tip = substr($id, 0, 1);
        if ($tip == 'j') {  //删除子菜单
            $map['uid'] = substr($id, 6);
            $map['pid'] = substr($id, 4, 1);
        } else {  //删除主菜单
            //先删除子菜单
            $map['pid'] = substr($id, 4);
            $menu->where($map)->delete();
            $map['uid'] = $map['pid'];
            $map['pid'] = 0;
            $data["tip"] = "z";
        }
        $res = $menu->where($map)->delete();

        if ($res) {
            $data["status"] = 1;
            $data["info"] = "菜单删除成功";
            $this->ajaxReturn($data);
        } else {
            $data["status"] = -1;
            $data["info"] = "菜单删除失败";
        }
        $this->ajaxReturn($data);
    }

    //查询自定义菜单（接收ajax发送的数据，进行数据回填）
    public function getMenu() {
        //接收ajax发送的数据
        $id = I("id");     //根据首字母判断 z为主菜单，j为子菜单
        $tip = substr($id, 0, 1);
        //实例化menu表
        $menu = M('weixin_menu');
        //$create_time = $menu->order('create_time desc')->limit(1)->getField('create_time');
        //根据时间查询最新的记录(查询条件:创建时间、pid、uid)
        if ($tip == 'z') {  //主菜单
            //$data['create_time'] = $create_time;
            $data['uid'] = substr($id, 4);
            $data['pid'] = 0;
            $list = $menu->where($data)->find();
        } else {  //子菜单
            //$map['create_time'] = $create_time;
            $map['uid'] = substr($id, 6);
            $map['pid'] = substr($id, 4, 1);
            $list = $menu->where($map)->find();
        }
        //加载菜单之后加载相关的素材
        switch ($list['type']) {
            case 'view_limited':
                $weixin_material_news = M('weixin_material_news');
                $map["media_id"] = $list["type_media_id"];
                $map["thumb_media_id"] = array("neq", "");
                $field = 'id,title,cover_id,intro,group_id, ctime';
                $mdata = $weixin_material_news->where($map)->field($field . ',count(id) as count')->group('group_id')->select();
                foreach ($mdata as &$vo) {
                    $vo["ctime"] = time_format($vo["ctime"], "m月d日");
                    $vo["pic"] = get_cover_url($vo["cover_id"]);
                    $vo["intro"] = json_decode($vo["intro"]);
                    if ($vo ['count'] == 1)
                        continue;
                    $map2 ['group_id'] = $vo ['group_id'];
                    $map2 ['id'] = array(
                        'exp',
                        '!=' . $vo ['id']
                    );
                    $vo ['child'] = $weixin_material_news->field($field)->where($map2)->select();
                    foreach ($vo ['child'] as $k => $item) {
                        $vo ['child'][$k]["pic"] = get_cover_url($item["cover_id"]);
                    }
                }
                break;
            case 'view':
                $mdata = !empty($list["type_url"]) ? $list["type_url"] : "";
                break;
			case 'media_id':
                $map["type"] = "image";
				$map["media_id"] = $list["type_media_id"];
				$weixin_material_other = M ( 'weixin_material_other' );
				$mdata = $weixin_material_other->where ( $map )->select ();
				foreach ( $mdata as &$vo ) {
					$vo["update_time"] = time_format($vo["update_time"], "m月d日");
					$vo["url"] = get_cover_url($vo["cover_id"]);
					$vo["name"] = json_decode($vo["name"]);
				}
                break;
            case 'click':
                $mdata = !empty($list["type_key"]) ? $list["type_key"] : "";
                break;
        }
        $list["data"] = $mdata;
        $this->ajaxReturn($list);
    }

    //从微信那边直接获取菜单
    public function getNewMenu() {
        $res = WechatApi::menuGet();
        if (1 == $res["status"] && 0 == $res["data"]["errcode"]) {
            $menu = $res["data"]['menu']['button'];
            unset($res);
            $weixin_menu = M('weixin_menu');
			$weixin_menu->where('1')->delete();
			$list = [];
			$zlist = [];
            foreach ($menu as $key => $value) {
                //如果不为空则有子菜单
				$list = $this->do_new_menu($key+1, $value, 1);
				$weixin_menu->data($list)->add();
                if (!empty($value['sub_button'])) {
					 foreach ($value['sub_button'] as $zkey => $zvalue) {
						 $zlist = $this->do_new_menu($zkey+1, $zvalue, 2);
						 $zlist['pid'] = $key+1;
						 $weixin_menu->data($zlist)->add();
						 unset($zlist);
					 }
                }
				unset($list);
            }
            $data["status"] = 1;
            $data["info"] = "获取成功";
        } else {
            $data["status"] = -1;
            $data["info"] = "获取菜单失败" . $res["data"]["errmsg"];
        }
        $this->ajaxReturn($data);
    }
    //处理菜单的数据，并且开始添加
    //$key处理第几个菜单，$dara是数据，$type是主还是子
    public function do_new_menu($key = 1, $dara = [], $type = 1) {
        $list['uid'] = $key;
        if ($type == 1) {
            $list['pid'] = 0;
            $list['menu_type'] = 'button';
            $list['zhu_name'] = $dara['name'];
            $list['zi_name'] = '';
        } else {
            $list['pid'] = $dara['pid'];
            $list['menu_type'] = 'sub_button';
            $list['zhu_name'] = '';
            $list['zi_name'] = $dara['name'];
        }
        $list['type'] = $dara['type'];
        $list['create_time'] = time_format();
        if ($list['type'] == 'media_id' || $list['type'] == 'view_limited') {
            $list['type_media_id'] = $dara['media_id'];
        }elseif ($list['type'] == 'view') {
            $list['type_url'] = $dara['url'];
        }elseif ($list['type'] == 'click') {
            $list['type_key'] = $dara['key'];
        }
        return $list;
    }
}