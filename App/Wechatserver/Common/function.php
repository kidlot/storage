<?php
/**
 * 获取文档封面图片
 *
 * @param int $cover_id         
 * @param string $field         
 * @return 完整的数据 或者 指定的$field字段值
 * @author huajie <banhuajie@163.com>
 */
function get_cover($cover_id, $field = null) {
    if (empty ( $cover_id ))
        return false;
    
    $key = 'Picture_' . $cover_id;S ( $key , null);
    $picture = S ( $key );
    
    if (! $picture) {
        $map ['status'] = 1;
        $picture = M ( 'Picture' )->where ( $map )->getById ( $cover_id );
        S ( $key, $picture, 86400 );
    }
    
    if (empty ( $picture ))
        return '';
    
    return empty ( $field ) ? $picture : $picture [$field];
}
function get_cover_url($cover_id, $width = '', $height = '') {
    $info = get_cover ( $cover_id );
    if ($width > 0 && $height > 0) {
        $thumb = "?imageMogr2/thumbnail/{$width}x{$height}";
    } elseif ($width > 0) {
        $thumb = "?imageMogr2/thumbnail/{$width}x";
    } elseif ($height > 0) {
        $thumb = "?imageMogr2/thumbnail/x{$height}";
    }
    if ($info ['url'])
        return $info ['url'] . $thumb;
    
    $url = $info ['path'];
    if (empty ( $url ))
        return '';
    return C("IMG_SITE_URL") . $url . $thumb;
}
/* 组装xml数据 */
/**
 * 微信消息回复预处理方法
 * @static
 * @access private
 * @param $arr 需要处理的数组
 */
function _wxReplyMessagePrepare($arr = []) {
	foreach ($arr as $key=>&$value) {
		if (is_array($value)) {
			//数组递归
			$value = _wxReplyMessagePrepare($value);
		} else {
			if (is_string($value)) {
				$value = "<![CDATA[{$value}]]>";
			}
		}
	}
	return $arr;
}
/**
 * 发送回复消息
 * 数组结构需和接口文档一致，字符串类型的自动封装为<![CDATA[{$value}]]>
 */
function _sendReplyMessage($arr = []) {
	if (empty($arr['MsgType'])) {
		return formatResult(OP_FAIL, '', "回复消息类型或数据为空！");
	}
	$arr = _wxReplyMessagePrepare($arr);
	$xml = data_to_xml(array('xml' => $arr));
	Think\Log::record($xml, 'DEBUG');
	echo ($xml);
}
//获取前台需要的图文封装,并且根据media_id进行F永久缓存
function getnews($media_id = ""){
	if(empty($media_id)){
		return false;
	}
	$arr = S($media_id);
	if(is_array($arr) && !empty($arr)){
		return $arr;
	}
	$weixin_material_news = M ( 'weixin_material_news' );
	$field = 'title, intro, cover_id, url';
	$map["type"] = "news";
	$map["media_id"] = $media_id;
	$mdata = $weixin_material_news->where ( $map )->field ($field)->select ();
	$num = count($mdata);
	if($num > 0){
		foreach ( $mdata as $key => $vo ) {
			$mdata[$key]["Title"] = $vo["title"];
			$mdata[$key]["Description"] = json_decode($vo["intro"]);
			$mdata[$key]["PicUrl"] = get_cover_url($vo["cover_id"]);
			$mdata[$key]["Url"] = $vo["url"];
			unset($mdata[$key]["title"]);
			unset($mdata[$key]["intro"]);
			unset($mdata[$key]["cover_id"]);
			unset($mdata[$key]["url"]);
		}
		S($media_id, $mdata);
		return $mdata;
	}
	else{
		return false;
	}
}
