<?php
namespace Wechatserver\Controller;
use Think\Controller;
class ApiController extends Controller {
    public function index(){
		//接口处理问题用户
		$ehtoo = I("get.ehtoo");
		if($ehtoo != "xyehtoowlsw"){
			echo "参数错误1";exit;
		}
		$issyn = I("get.t");
		if(empty($issyn)){
			echo "参数错误2";exit;
		}
		if(!($issyn == 2 || $issyn == 3 || $issyn == 4 || $issyn == 5)){
			echo "参数错误3";exit;
		}
		$Activity = M('Activity','etoo_','DB_CONFIGTHREE');
		$_time = time();
		$slist = $Activity->where('issyn>1')->select();
		if(empty($slist)){
			echo "数据正常";exit;
		}
		$m2 = 0;
		$m3 = 0;
		$m4 = 0;
		$m5 = 0;
		foreach($slist as $item){
			if($item["issyn"] == 2){
				$m2++;
			}elseif($item["issyn"] == 3){
				$m3++;
			}elseif($item["issyn"] == 4){
				$m4++;
			}elseif($item["issyn"] == 5){
				$m5++;
			}
		}
		echo "未知：" . $m2 . "条数据<p>";
		echo "多用户：" . $m3 . "条数据<p>";
		echo "未注册：" . $m4 . "条数据<p>";
		echo "其他情况：" . $m5 . "条数据<p>";
		$list = $Activity->where('issyn=' . $issyn)->order('rand()')->limit(1)->find();
		if(!empty($list) && !empty($list["id"])){
			$apidata = array('weixin_no' => $list["openid"], 'coupon_no' => $list["coupon"], 'binding_date' => date("Y-m-d", $_time));
			$msg = getApiUrl("binding_coupon", $apidata, [CURLOPT_TIMEOUT_MS => 6000]);
			unset($apidata);
			//接口返回成功或者券被绑定都直接更新为１
			if (!empty($msg) && ($msg['errcode'] == 0 || $msg['errcode'] == 41038)) {
				$res = $Activity->where(["id" => $list["id"]])->save(["issyn" => 1, "utime" => $_time]);
				if($res){
					echo "处理成功";exit;
				}
			}else{
				print_r($msg);exit;
			}
			unset($msg);
		}
		else{
			switch($issyn){
				case 2:echo "没有【未知】数据";exit;
				case 3:echo "没有【多用户】数据";exit;
				case 4:echo "没有【未注册】数据";exit;
				case 5:echo "没有【其他情况】数据";exit;
			}
		}
		unset($list);
    }
}