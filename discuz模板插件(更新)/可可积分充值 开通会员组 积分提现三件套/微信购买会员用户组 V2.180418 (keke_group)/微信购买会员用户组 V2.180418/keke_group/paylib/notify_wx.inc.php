<?php

define('IN_API', true);
define('CURSCRIPT', 'api');
define('DISABLEXSSCHECK', true);

require_once '../../../../source/class/class_core.php';
$discuz = C::app();
$discuz->init();
loadcache('plugin');
require_once DISCUZ_ROOT."source/plugin/keke_group/inc.php";	

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
	exit();//fr om w w  w.mo qu  8.co m
}
if(!empty($returnValues['result_code']) && $returnValues['result_code'] == 'SUCCESS'){
	_upuserdata($returnValues['out_trade_no'],$returnValues['transaction_id'],$returnValues['openid']);
	$return = array(
		'return_code'=>'SUCCESS',
		'return_msg'=> 'OK',
	);
	WxPayApi::replyNotify(arrtoxml($return));
}