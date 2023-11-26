<?php
/*
!
 */


if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

global $_G;
$keke_chongzhi = $_G['cache']['plugin']['keke_chongzhi'];
header("Content-type:text/html;charset=utf-8");
if(!$_G['uid']){
	exit('Access Denied');
}
$moneyQuantity=floatval($_GET['moneyQuantity']);
$money=$moneyQuantity*100;
$zftype=intval($_GET['zftype']);
$credittype=intval($_GET['credittype']);
loadcache('keke_chongzhi_credit');
$creditdata=$_G['cache']['keke_chongzhi_credit'] ? $_G['cache']['keke_chongzhi_credit'] : C::t('#keke_chongzhi#keke_chongzhi_credit')->fetchall_credit();
$credit=intval($moneyQuantity*$creditdata[$credittype]['bili']);
$title= CHARSET=='gbk' ? diconv(lang('plugin/keke_chongzhi', 'lang01'), CHARSET, 'UTF-8') : lang('plugin/keke_chongzhi', 'lang01');
if($keke_chongzhi['zuidi']>$moneyQuantity){
	$msg=lang('plugin/keke_chongzhi', 'lang02').floatval($keke_chongzhi['zuidi']).lang('plugin/keke_chongzhi', 'lang03');
	$msgs=diconv($msg, CHARSET,'utf-8');
	if($zftype=1){
		echo '<script>alert("'.$msg.'");window.history.go(-1);</script>';
	}else{
		echo json_encode(array('err' =>$msgs));
	}
	exit();
}

$nowdate=dgmdate($_G['timestamp'], 'YmdHis');
$random=random(8,1);
$orderid=$nowdate.$random;
$orderarr=array(
	'orderid'=>$orderid,
	'uid'=>$_G['uid'],
	'usname'=>$_G['username'],
	'money'=>$money,
	'type'=>$zftype,
	'time'=>$_G['timestamp'],
	'credit'=>$credit,
	'credittype'=>$credittype,
);
C::t('#keke_chongzhi#keke_chongzhi_orderlog')->insert($orderarr, true);

if($zftype==1){
	
	require_once("source/plugin/keke_chongzhi/paylib/alipay/alipay.config.php");
	require_once("source/plugin/keke_chongzhi/paylib/alipay/alipay_submit.class.php");
	
	//商户订单号，商户网站订单系统中唯一订单号，必填
	$out_trade_no = $orderid;
	//订单名称，必填
	$subject = $title;
	//付款金额，必填
	$total_fee = $moneyQuantity;
	//收银台页面上，商品展示的超链接，必填
	$show_url = "plugin.php?id=keke_chongzhi";
	//构造要请求的参数数组，无需改动
	$parameter = array(
		"service"       => $alipay_config['service'],
		"partner"       => $alipay_config['partner'],
		"seller_id"  => $alipay_config['seller_id'],
		"payment_type"	=> $alipay_config['payment_type'],
		"notify_url"	=> $alipay_config['notify_url'],
		"return_url"	=> $alipay_config['return_url'],
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"show_url"	=> $show_url,
	);
	//建立请求
	$alipaySubmit = new AlipaySubmit($alipay_config);
	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", lang('plugin/keke_chongzhi', 'lang05'));
	echo $html_text;
}elseif($zftype==2){

	include_once DISCUZ_ROOT."source/plugin/keke_chongzhi/inc.php";	
		
	//①、获取用户openid
	$tools = new JsApiPay();
	$openIds = $_G['cookie'][$uskey];
	$openId=authcode($openIds, 'DECODE', $_G['config']['security']['authkey']);
	
	//②、统一下单
	$notify = new NativePay();
	$input = new WxPayUnifiedOrder();
	$input->SetBody($title);
	$input->SetAttach($title);
	$input->SetOut_trade_no($orderid);
	$input->SetTotal_fee($money);
	$input->SetTime_start(date("YmdHis"));
	$input->SetGoods_tag($title);
	$input->SetNotify_url($_G['siteurl']. 'source/plugin/keke_chongzhi/paylib/notify_wx.inc.php');
	$input->SetTrade_type($s_type);
	
	if($iswx){
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		$jsApiParameters = $tools->GetJsApiParameters($order);
		
		try
        {
            $jsApiParameters = $tools->GetJsApiParameters($order);
        }catch (Exception $e){
            $jsApiParameters = json_encode(array('err' => $e->getMessage()));
            $jsApiParameters = diconv($jsApiParameters, 'utf-8');
        }
        echo $jsApiParameters;
        exit;
		
	}else{
		$input->SetProduct_id($orderid);
		$result = $notify->GetPayUrl($input);
		$url2 = $result["code_url"];
		if($url2){
			$src = 'http://qr.liantu.com/api.php?&bg=ffffff&fg=000000&w=250&el=h&text='.urlencode($url2);
            echo json_encode(array('ewmurl' => '<img src="'.$src.'" />'));
        }else{
			$err = $result['return_msg'];
			echo json_encode(array('err' => $err));
        }
	}
	

}