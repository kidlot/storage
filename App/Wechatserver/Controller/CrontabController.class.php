<?php

namespace Wechatserver\Controller;
use Think\Controller;
use Org\Wechat\WechatApi;
use Think\Log;

/**
 * 定时器
 */
class CrontabController extends Controller {

    public function index() {
        $log = M('sys_wordbook')->where(['type'=>'sys_wx_config', 'code'=>'WX_CROMTAB_LOG', 'status'=>1])->getField('value');
		if($log == 1){
			$crontab_log = M('crontab_log');
			$count = $crontab_log->where("TO_DAYS(NOW()) = TO_DAYS(utime) ")->count();
			if($count < 50000){
				$res1 = WechatApi::refreshAccessToken();
				$res2 = WechatApi::refreshApiTicket('jsapi');
				$res3 = WechatApi::refreshApiTicket('wx_card');
				$crontab_log->add(['type'=>'refreshAccessToken','title'=>'更新全局access_token','content'=>print_r($res1, true), 'utime'=>date("Y-m-d H:i:s", time())]);
				$crontab_log->add(['type'=>'refreshApiTicket_jsapi','title'=>'更新全局ApiTicket_jsapi','content'=>print_r($res2, true), 'utime'=>date("Y-m-d H:i:s", time())]);
				$crontab_log->add(['type'=>'refreshApiTicket_wx_card','title'=>'更新全局ApiTicket_wx_card','content'=>print_r($res3, true), 'utime'=>date("Y-m-d H:i:s", time())]);
			}
		}
    }
}
