<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

global $_G;
$keke_group = $_G['cache']['plugin']['keke_group'];
header("Content-type:text/html;charset=utf-8");
include_once DISCUZ_ROOT."source/plugin/keke_group/common.php";
$buygroupid=intval($_GET['buygroupid']);
$gorupdata=getbuygroupdata($buygroupid);
$money=floatval($gorupdata['money']/100);
$zftype=intval($_GET['zftype']);
$title= grogbk2utf(lang('plugin/keke_group', 'lang02'));
if(!$_G['uid']){
	$msg=lang('plugin/keke_group', 'lang33');
	$msgs=grogbk2utf($msg);
	if($zftype==1){
		exit( '<script>alert("'.$msgs.'");</script>');
	}else{
		exit( json_encode(array('err' =>$msgs)));
	}
}
$orderid=_orderid();_instorder($orderid,$gorupdata['money'],$zftype,$gorupdata['groupid'],$gorupdata['groupname'],$gorupdata['time']);
if($zftype==1){
	require_once("source/plugin/keke_group/paylib/alipay/alipay.config.php");
	require_once("source/plugin/keke_group/paylib/alipay/alipay_submit.class.php");
	$out_trade_no = $orderid;
	$subject = $title;
	$total_fee = $money;
	$show_url = "plugin.php?id=keke_group";
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
		"app_pay"   => "Y",
	);
	$alipaySubmit = new AlipaySubmit($alipay_config);
	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", lang('plugin/keke_group', 'lang01'));
	echo $html_text;
}elseif($zftype==2){
	include_once DISCUZ_ROOT."source/plugin/keke_group/inc.php";	
	$tools = new JsApiPay();
	$openIds = $_G['cookie'][$uskey];
	$openId=authcode($openIds, 'DECODE', $_G['config']['security']['authkey']);
	$notify = new NativePay();
	$input = new WxPayUnifiedOrder();
	$input->SetBody($title);
	$input->SetAttach($title);
	$input->SetOut_trade_no($orderid);
	$input->SetTotal_fee($gorupdata['money']);
	$input->SetTime_start(date("YmdHis"));
	$input->SetGoods_tag($title);
	$input->SetNotify_url($_G['siteurl'].'source/plugin/keke_group/paylib/notify_wx.inc.php');
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
		if(checkmobile() && $keke_group['h5']){
			$h5pay=_h5pay($gorupdata['money'],$orderid,$title);
			echo json_encode(array('h5payurl' => $h5pay['mweb_url'],'ewmurl' => '','orderid'=>$orderid));
		}else{
			$input->SetProduct_id($orderid);
			$result = $notify->GetPayUrl($input);
			$url2 = $result["code_url"];
			if($url2){
				$src = _getqrcodeurl($url2);
				echo json_encode(array('ewmurl' => '<img src="'.$src.'" />','orderid'=>$orderid));
			}else{
				$err = $result['return_msg'];
				echo json_encode(array('err' => $err));
			}
		}
	}
}