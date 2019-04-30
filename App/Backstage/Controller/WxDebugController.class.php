<?php
/**
 * 微信接口调试
 */
namespace Backstage\Controller;
use Org\Wechat\WechatApi;
class WxDebugController extends AdminBaseController {
	public function __construct() {
		parent::__construct();
	}
    public function index() {
		//调用接口
		$level = M('sys_wordbook')->where(['type'=>'sys_wx_config', 'code'=>'CURL_LEVEL', 'status'=>1])->getField('value');
		$arr = M('sys_wordbook')->where(['type'=>'sys_wx_config', 'code'=>'CURL_LEVEL_ARR'.$level, 'status'=>1])->getField('value');
		if(!empty($arr)){
			$this->assign('_data', json_decode(htmlspecialchars_decode($arr), true));
		}
		$this->assign('_level', $level);
		$this->display();
    }
	public function curl() {
		$method = I('method','',false);
		$parameter = I('parameter','',false);
		if(empty($method)){
			$this->error('请输入method');exit;
		}
		$apidata = [];
		if(is_json($parameter) == 1){
			$apidata = json_decode($parameter,true);
		}
		$level = M('sys_wordbook')->where(['type'=>'sys_wx_config', 'code'=>'CURL_LEVEL', 'status'=>1])->getField('value');
		$result = [];
		if($level == 2){
			if(empty($parameter)){
				$result = WechatApi::$method();
			}else{
				$result = WechatApi::cardWxDebug($method, $parameter);
			}
			
		}elseif($level == 3){
			$result['data'] = getApiUrl($method, $apidata);
		}else{
			$result = curl_request($method, $parameter);
		}
        $this->back($result['data']);
    }
	private function back($data = []) {
		header('Content-Type:application/json; charset=utf-8');
		$data = do_arr_coding($data);
		exit(urldecode(json_encode($data)));
	}
}
