<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------
namespace Backstage\Model;
use Think\Model;

/**
 * 行为模型
 */
class SysWordbookModel extends Model {

    /**
     * 新增一个
     * @return boolean fasle 失败 ， int  成功 返回完整的数据
     */
    public function addData($data) {
        if (count($data) == 0) {
            return 0;
        }
        $id = $this->add($data);
        //内容添加完成
        return $id;
    }

    /**
     * 更新
     * @return boolean fasle 失败 ， int  成功 返回完整的数据
     */
    public function updateData($map, $data) {
        if (count($data) == 0) {
            return false;
        }
        $res = $this->where($map)->data($data)->save();
        //内容添加完成
        return $res;
    }

    /**
     * 删除数据
     * @return boolean fasle 失败 ， int  成功 返回完整的数据
     */
    public function removeData($map) {
        $res = $this->where($map)->delete();
        //内容添加完成
        return $res;
    }

    /**
     * 查询一条数据
     * @return boolean fasle 失败 ， int  成功 返回完整的数据
     */
    public function getData($map) {
        $res = $this->where($map)->find();
        //内容添加完成
        return $res;
    }
}
