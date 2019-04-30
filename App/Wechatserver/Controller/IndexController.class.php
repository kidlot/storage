<?php

namespace Wechatserver\Controller;
use Think\Controller;
use Think\Log;
/**
 * 微信服务端Controller
 * 接收处理微信推送的消息
 */
class IndexController extends Controller {
	private $data = array ();
	protected $tryget = 1;
    public function index() {
        //鉴权
        if ($this->_checkSignature()) {
            if (empty($_REQUEST["echostr"])) {
                //非url验证消息
                $str = file_get_contents("php://input");
                Log::record($str, 'DEBUG');
                //xml解析
                $result = $this->_getXmlData($str);
                if ($result['status'] != OP_SUCCESS) {
                    Log::record("xml数据读取失败！ \n{$str}", 'ERR');
                    return;
                } else {
                    //微信消息处理
					$this->data = $result['data'];
                    $result = $this->handleWechatMessage($this->data);
                    Log::record(print_r($result, true), 'DEBUG');
                    return;
                }
            } else {
                //url验证消息
                echo $_REQUEST["echostr"];
                return;
            }
        } else {
            Log::record('鉴权失败', 'ERR');
            return;
        }
    }

    /**
     * 微信服务器验证
     */
    private function _checkSignature() {
        $signature = $_REQUEST["signature"];
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];
        $token = C('WECHAT_CFG.token');

        $tmp_arr = array($token, $timestamp, $nonce);
        sort($tmp_arr, SORT_STRING);
        $tmp_str = implode($tmp_arr);
        $tmp_str = sha1($tmp_str);

        if ($tmp_str == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * xml解析
     */
    private function _getXmlData($str) {
        $result = xmlToArray($str, LIBXML_NOCDATA);
        if ($result['status'] != OP_SUCCESS) {
            return $result;
        }
        return formatResult(OP_SUCCESS, $result['data'], "解析成功");
    }

    /**
     * 微信推送消息处理方法
     */
    protected function handleWechatMessage() {
		$MsgType = $this->data['MsgType'];
        switch ($MsgType) {
            case 'text':
                //文本消息
                return $this->handleTextMessage();
            case 'image':
                //图片消息
                return $this->handleImageMessage();
            case 'voice':
                //语音消息
                return $this->handleVoiceMessage();
            case 'video':
                //视频消息
                return $this->handleVideoMessage();
            case 'shortvideo':
                //小视频消息
                return $this->handleShortvideoMessage();
            case 'location':
                //地理位置消息
                return $this->handleLocationMessage();
            case 'link':
                //链接消息
                return $this->handleLinkMessage();
            case 'event':
                //事件
                return $this->handleEventMessage();
            default :
                Log::record("未知的MsgType：{$MsgType}", 'ERR');
                return null;
        }
    }

    /**
     * 文本消息处理方法，具体处理逻辑在此补充
	 * 匹配：匹配关键字回复（优先回复模糊匹配）
	 * 匹配：没有关键字回复则回复自动回复内容
     */
    protected function handleTextMessage() {
		$keyword = trim($this->data ['Content']);
		$keywordmdf = md5($keyword);
		$auto_reply_keyword = S("auto_reply_keyword_" . $keywordmdf);
		$like["msg_type"] = "keywords";
		if(empty($auto_reply_keyword)){
			//关键识别开始
			$spot = 0;
			$auto_reply = M("auto_reply");
			// 完全-随机匹配（前提是关键词是完全匹配）
			if(0 == $spot){
				$like["keyword"] = $keyword;
				$like["mode"] = array("eq", 1);
				$auto_reply_keyword = $auto_reply->where ( $like )->order ( 'create_time desc' )->find ();
				if(!empty($auto_reply_keyword)){
					$spot = 1;
					S("auto_reply_keyword_" . $keywordmdf, $auto_reply_keyword);
				}
			}
			// 通过模糊关键词来定位处理的回复
			if(0 == $spot){
				unset($like["keyword"]);
				$like["mode"] = array("eq", 0);
				$auto_reply_keyword = $auto_reply->where ( $like )->order ( 'create_time desc' )->select ();
				if(!empty($auto_reply_keyword)){
					foreach($auto_reply_keyword as $key => $item){
						$keyarr = explode(",", $item["keyword"]);
						foreach($keyarr as $sitem){
							Log::record($keyword, 'DEBUG');Log::record($sitem, 'DEBUG');Log::record(!(strpos ( $keyword ,  $sitem )  ===  false), 'DEBUG');
							if ( !(strpos ( $keyword ,  $sitem )  ===  false) ) {
								$auto_reply_keyword = $item;
								$spot = 1;
								S("auto_reply_keyword_" . $keywordmdf, $item);
								break;
							}
						}
						if(1 == $spot){
							break;
						}
					}
				}
			}
			// 以上都无法定位回复时，自动回复内容
			if(0 == $spot){
				$auto_reply_keyword = S("auto_reply_autoreply");
				if(empty($auto_reply_keyword)){
					$map["keyword"] = "autoreply";
					$map["msg_type"] = "beadded";
					$auto_reply_keyword = $auto_reply->where($map)->order("create_time desc")->find();
					if(!empty($auto_reply_keyword) ){
						$spot = 1;
						S("auto_reply_autoreply", $auto_reply_keyword);
					}
				}
				else{
					$spot = 1;
				}

			}
			// 最终也无法定位到插件，终止操作
			if(0 == $spot){
				$auto_reply_keyword = "";
			}
		}
		if(!empty($auto_reply_keyword)){
			//文字
			if("text" == $auto_reply_keyword["type"]){
				$this->replyText($auto_reply_keyword["content"]);
			}else if("news" == $auto_reply_keyword["type"]){
				//图文
				$list = getnews($auto_reply_keyword["media_id"]);
				$this->replyNews($list);
			}else if("image" == $auto_reply_keyword["type"]){
				//图片
				$list = ['MediaId'=>$auto_reply_keyword["media_id"]];
				$this->replyImage($list);
			}
		}else{
			$str = "欢迎来到";
			$this->replyText($str);
		}
    }

    /**
     * 图片消息处理方法，具体处理逻辑在此补充
     */
    protected function handleImageMessage() {
        //TBD
    }

    /**
     * 语音消息处理方法，具体处理逻辑在此补充
     */
    protected function handleVoiceMessage() {
        //TBD
    }

    /**
     * 视频消息处理方法，具体处理逻辑在此补充
     */
    protected function handleVideoMessage() {
        //TBD
    }

    /**
     * 小视频消息处理方法，具体处理逻辑在此补充
     */
    protected function handleShortvideoMessage() {
        //TBD
    }

    /**
     * 位置消息处理方法，具体处理逻辑在此补充
     */
    protected function handleLocationMessage() {
		//TBD
    }

    /**
     * 链接消息处理方法，具体处理逻辑在此补充
     */
    protected function handleLinkMessage() {
        //TBD
    }

    /**
     * 事件消息处理方法，调用对应事件类型的处理方法
     */
    protected function handleEventMessage() {
		$Event = $this->data['Event'];
        if (empty($Event)) {
            return null;
        }
        switch ($Event) {
            case 'subscribe':
                //关注
                return $this->handleSubscribeEvent();
            case 'unsubscribe':
                //取消关注
                return $this->handleUnsubscribeEvent();
            case 'SCAN':
                //扫码
                return $this->handleScanEvent();
            case 'LOCATION':
                //上报地理位置的事件
                return $this->handleLocationvent();

            /*             * ****************以下为自定义菜单事件*********************** */
            case 'CLICK':
                //点击菜单的事件
                return $this->handleClickEvent();
            case 'VIEW':
                //点击菜单跳转链接的事件
                return $this->handleViewEvent();
            case 'scancode_push':
                //扫码推事件
                return $this->handleScancodePushEvent();
            case 'scancode_waitmsg':
                //扫码推事件且弹出“消息接收中”提示框的事件推送
                return $this->handleScancodeWaitmsgEvent();
            case 'pic_sysphoto':
                //弹出系统拍照发图的事件
                return $this->handlePicSysphotoEvent();
            case 'pic_photo_or_album':
                //弹出拍照或者相册发图的事件
                return $this->handlePicPhotoOrAlbumEvent();
            case 'pic_weixin':
                //弹出微信相册发图器的事件
                return $this->handlePicWeixinEvent();
            case 'location_select':
                //弹出地理位置选择器的事件
                return $this->handleLocationSelectEvent();
			case 'user_view_card':
                //进入会员卡推送事件,需要开发者在创建会员卡时填入need_push_on_view	字段并设置为true。开发者须综合考虑领卡人数和服务器压力，决定是否接收该事件。
                return $this->handleUserViewCardEvent();
			case 'user_get_card':
                //领取卡券推送事件
                return $this->handleUserGetCardEvent();
			case 'user_enter_session_from_card':
                //从卡券进入公众号会话推送事件
                return $this->handleUserEnterSessionFromCardEvent();
			case 'user_del_card':
                //删除事件推送事件
                return $this->handleUserDelCardEvent();
			case 'update_member_card':
                //会员卡内容更新事件
                return $this->handleUpdateMemberCardEvent();
			case 'submit_membercard_user_info':
                //会员卡激活事件推送事件
                return $this->handleSubmitMembercardUserInfoEvent();
            case 'user_pay_from_pay_cell':
                //买单事件推送事件
                return $this->handleUserPayFromPayCellEvent();
            case 'card_pass_check':
                //审核事件推送事件
                return $this->handleCardPassCheckEvent();
            case 'user_gifting_card':
                //转赠事件推送事件
                return $this->handleUserGiftingCardEvent();
            case 'user_consume_card':
                //核销事件推送事件
                return $this->handleUserConsumeCardEvent();
            case 'card_sku_remind':
                //库存报警事件
                return $this->handleCardSkuRemindEvent();
            case 'card_pay_order':
                //券点流水详情事件
                return $this->handleCardPayOrderEvent();
            default :
                Log::record("未知的Event：{$Event}", 'ERR');
                return null;
        }
    }

    /**
     * 关注事件处理方法，具体处理逻辑在此补充
     */
    protected function handleSubscribeEvent() {
		//推送相关的图文信息
		$arr = S("auto_reply_welcome");
		if(empty($arr) || !is_array($arr)){
			$map["keyword"] = "welcome";
			$map["msg_type"] = "index";
			$arr = M("auto_reply")->where($map)->order("create_time desc")->find();
			if(empty($arr) || empty($arr["type"]) || (empty($arr["content"]) && empty($arr["media_id"]))){
				$str = "欢迎";
				$this->replyText($str);
			}
			S("auto_reply_welcome", $arr);
		}
		if("text" == $arr["type"]){
			//文字
			$this->replyText($arr["content"]);
		}else if("news" == $arr["type"]){
			//图文
			$list = getnews($arr["media_id"]);
			$this->replyNews($list);
		}else if("image" == $arr["type"]){
			//图片
			$list = ['MediaId'=>$auto_reply_keyword["media_id"]];
			$this->replyImage($list);
		}
		//推送图文之后走接口绑定用户数据
		if(empty($this->data ['EventKey'])){
			$code = "";
		}
		else{
			$code = $this->data ['EventKey'];
		}
    }

    /**
     * 取消关注处理方法，具体处理逻辑在此补充
     */
    protected function handleUnsubscribeEvent() {
		//用户解绑
    }

    /**
     * 扫码事件处理方法，具体处理逻辑在此补充
     */
    protected function handleScanEvent() {
		if(empty($this->data ['EventKey'])){
			$code = "";
		}
		else{
			$code = $this->data ['EventKey'];
		}
        $str = scanEventApi($code);
		$this->replyText($str);
    }

    /**
     * 上报地理位置的事件处理方法，具体处理逻辑在此补充
     */
    protected function handleLocationvent() {
		
    }

    /**
     * 点击菜单的事件处理方法，具体处理逻辑在此补充
     */
    protected function handleClickEvent() {
        $EventKey = $this->data["EventKey"];
		if(strpos($EventKey, "[text]") !== false){
			$this->replyText(str_replace(array("[text]"), '',$EventKey));
		}else if(function_exists($EventKey)){
			//判断类型1文字或者2图文
			$data = $EventKey($this->data["FromUserName"]);
			if(1 == $data["type"]){
				$this->replyText($data["msg"]);
			}else if(2 == $data["type"]){
				$this->replyNews($data["msg"]);
			}else{
				$str = "系统繁忙，请稍后尝试";
				$this->replyText($str);
			}
		}else{
			$str = "功能开发中";
			$this->replyText($str);
		}
    }

    /**
     * 点击菜单跳转链接的事件处理方法，具体处理逻辑在此补充
     */
    protected function handleViewEvent() {
        //TBD
    }

    /**
     * 扫码推事件处理方法，具体处理逻辑在此补充
     */
    protected function handleScancodePushEvent() {
        //TBD
    }

    /**
     * 扫码推事件且弹出“消息接收中”提示框的事件推送处理方法，具体处理逻辑在此补充
     */
    protected function handleScancodeWaitmsgEvent() {
        //TBD
    }

    /**
     * 弹出系统拍照发图的事件处理方法，具体处理逻辑在此补充
     */
    protected function handlePicSysphotoEvent() {
        //TBD
    }

    /**
     * 弹出拍照或者相册发图的事件处理方法，具体处理逻辑在此补充
     */
    protected function handlePicPhotoOrAlbumEvent() {
        //TBD
    }

    /**
     * 弹出微信相册发图器的事件处理方法，具体处理逻辑在此补充
     */
    protected function handlePicWeixinEvent() {
        //TBD
    }

    /**
     * 弹出地理位置选择器的事件处理方法，具体处理逻辑在此补充
     */
    protected function handleLocationSelectEvent() {
        //TBD
    }
	
	/**
     * 进入会员卡推送事件处理方法，具体处理逻辑在此补充
     */
    protected function handleUserViewCardEvent() {
        //TBD
    }
	
	/**
     * 领取卡券推送事件处理方法，具体处理逻辑在此补充
     */
    protected function handleUserGetCardEvent() {
        //TBD
    }
	
	/**
     * 从卡券进入公众号会话推送事件处理方法，具体处理逻辑在此补充
     */
    protected function handleUserEnterSessionFromCardEvent() {
        //TBD
    }
	
	/**
     * 删除事件推送事件处理方法，具体处理逻辑在此补充
     */
    protected function handleUserDelCardEvent() {
        //TBD
    }
	
	/**
     * 会员卡内容更新事件处理方法，具体处理逻辑在此补充
     */
    protected function handleUpdateMemberCardEvent() {
        //TBD
    }
	
	/**
     * 会员卡激活事件推送处理方法，具体处理逻辑在此补充
     */
    protected function handleSubmitMembercardUserInfoEvent() {
        //TBD
    }
/**
     * 买单事件推送处理方法，具体处理逻辑在此补充
     */
    protected function handleUserPayFromPayCellEvent() {
        //TBD
    }

    /**
     * 审核事件推送处理方法，具体处理逻辑在此补充
     */
    protected function handleCardPassCheckEvent() {
        //TBD
    }

    /**
     * 转赠事件推送处理方法，具体处理逻辑在此补充
     */
    protected function handleUserGiftingCardEvent() {
        //TBD
    }

    /**
     * 核销事件推送处理方法，具体处理逻辑在此补充
     */
    protected function handleUserConsumeCardEvent() {
        //TBD
    }
    
    /**
     * 库存报警事件处理方法，具体处理逻辑在此补充
     */
    protected function handleCardSkuRemindEvent() {
        //TBD
    }

    /**
     * 券点流水详情事件处理方法，具体处理逻辑在此补充
     */
    protected function handleCardPayOrderEvent() {
        //TBD
    }
	
	/* ========================发送被动响应消息 begin================================== */
	/* 回复文本消息 */
	protected function replyText($content) {
		$msg ['Content'] = $content;
		$this->_replyData ( $msg, 'text' );
	}
	/*
	 * 回复图文消息 articles array 格式如下： array( array('Title'=>'','Description'=>'','PicUrl'=>'','Url'=>''), array('Title'=>'','Description'=>'','PicUrl'=>'','Url'=>'') );
	 */
	protected function replyNews($articles) {
		$msg ['ArticleCount'] = count ( $articles );
		$msg ['Articles'] = $articles;
		
		$this->_replyData ( $msg, 'news' );
	}
	/*
	 * 回复图片消息
	 */
	protected function replyImage($arr = []) {
		$msg ['ArticleCount'] = count ( $articles );
		$msg ['Image'] = $arr;
		
		$this->_replyData ( $msg, 'image' );
	}
    /**
     * 转接客服
     * @static
     * @param $KfAccount 指定客服，有需要可传入
     */
    protected function replyCustomerService($KfAccount = "") {
        if (!empty($KfAccount)) {
            $msg['TransInfo'] = ['KfAccount' => $KfAccount];
        }
        $this->_replyData ( $msg, 'transfer_customer_service' );
    }
	/* 发送回复消息到微信平台 */
	protected function _replyData($msg, $msgType) {
		$msg ['FromUserName'] = $this->data ['ToUserName'];
		$msg ['ToUserName'] = $this->data ['FromUserName'];
		$msg ['CreateTime'] = time();
		$msg ['MsgType'] = $msgType;
		$xml = _sendReplyMessage($msg);
	}
	/* 活动的话写在这里 */
}
