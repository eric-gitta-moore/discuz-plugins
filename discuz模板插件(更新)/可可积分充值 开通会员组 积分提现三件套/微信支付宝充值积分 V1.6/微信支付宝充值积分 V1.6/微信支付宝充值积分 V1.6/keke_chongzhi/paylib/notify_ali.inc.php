<?php
/*

 */


define('IN_API', true);
define('CURSCRIPT', 'api');
define('DISABLEXSSCHECK', true);

require_once '../../../../source/class/class_core.php';
$discuz = C::app();
$discuz->init();

loadcache('plugin');
require_once("alipay/alipay.config.php");
require_once("alipay/alipay_notify.class.php");




//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {
	$out_trade_no = $_POST['out_trade_no'];
	$trade_no = $_POST['trade_no'];
	$trade_status = $_POST['trade_status'];
    if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
		$orderdata= C::t('#keke_chongzhi#keke_chongzhi_orderlog')->fetch($out_trade_no);
		$orderarr=array(
			'state'=>'1',
			'zftime'=>$_G['timestamp'],
			'sn'=>$trade_no,
		);
		C::t('#keke_chongzhi#keke_chongzhi_orderlog')->update($orderdata, $orderarr);
		
		updatemembercount($orderdata['uid'], array('extcredits'.$orderdata['credittype']=>$orderdata['credit']), true, '', 0, '',lang('plugin/keke_chongzhi', 'lang01'),lang('plugin/keke_chongzhi', 'lang01'));	
			
    }
	echo "success";		
}
else {
    //验证失败
    echo "fail";
}
?>