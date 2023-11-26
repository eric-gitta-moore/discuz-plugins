<?php

define('IN_API', true);
define('CURSCRIPT', 'api');
define('DISABLEXSSCHECK', true);

require_once '../../../../source/class/class_core.php';
$discuz = C::app();
$discuz->init();
loadcache('plugin');
global $_G;
$keke_group = $_G['cache']['plugin']['keke_group'];
require_once("alipay/alipay.config.php");
require_once("alipay/alipay_notify.class.php");
$returl=str_replace('source/plugin/keke_group/paylib/', '',$_G['siteurl']);

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	$out_trade_no = $_GET['out_trade_no'];
	//支付宝交易号
	$trade_no = $_GET['trade_no'];
	//交易状态
	$trade_status = $_GET['trade_status'];
    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		$url=$keke_group['tz']? $keke_group['tz'] : $returl.'plugin.php?id=keke_group&p=my';
		Header("HTTP/1.1 303 See Other"); 
		Header("Location: $url"); 
		exit;		
    }
	echo "success<br />";
}
else {
    echo "fail";
}
?>