<?php

define('IN_API', true);
define('CURSCRIPT', 'api');
define('DISABLEXSSCHECK', true);

require_once '../../../../source/class/class_core.php';
$discuz = C::app();
$discuz->init();

loadcache('plugin');
require_once("alipay/alipay.config.php");
require_once("alipay/alipay_notify.class.php");
require_once DISCUZ_ROOT."source/plugin/keke_group/common.php";	

$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {
	$out_trade_no = $_POST['out_trade_no'];
	$trade_no = $_POST['trade_no'];
	$trade_status = $_POST['trade_status'];
    if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
		_upuserdata($out_trade_no,$trade_no);
    }
	echo "success";	//fr om w w  w.mo qu8.co m	
}
else {
    echo "fail";
}
?>