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
require_once DISCUZ_ROOT."source/plugin/keke_chongzhi/inc.php";	

$return=array();
$msg = '';
$returnValues = WxPayApi::notify($msg);

if(empty($returnValues)){
	$return = array('return_code'=>'FAIL','return_msg'=>$msg,);
	WxPayApi::replyNotify(arrtoxml($return));
	exit();
}

$chcksign = WxPayDataBase::CheckSigns($returnValues);
if(!$chcksign){
	$return = array('return_code'=>'FAIL','return_msg'=>'signerr',);
	WxPayApi::replyNotify(arrtoxml($return));
	exit();
	
}


if(!empty($returnValues['result_code']) && $returnValues['result_code'] == 'SUCCESS'){
	$orderdata= C::t('#keke_chongzhi#keke_chongzhi_orderlog')->fetch($returnValues['out_trade_no']);
    $orderarr=array(
		'state'=>'1',
		'zftime'=>$_G['timestamp'],
		'sn'=>$returnValues['transaction_id'],
		'opid'=>$returnValues['openid'],
	);
	C::t('#keke_chongzhi#keke_chongzhi_orderlog')->update($returnValues['out_trade_no'], $orderarr);
	
	updatemembercount($orderdata['uid'], array('extcredits'.$orderdata['credittype']=>$orderdata['credit']), true, '', 0, '',lang('plugin/keke_chongzhi', 'lang01'),lang('plugin/keke_chongzhi', 'lang01'));
	
	$return = array(
		'return_code'=>'SUCCESS',
		'return_msg'=> 'OK',
	);
	WxPayApi::replyNotify(arrtoxml($return));
}