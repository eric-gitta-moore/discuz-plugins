<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include/zhanmishu_transfer.php';
$config=getconfig();
$data = array();
if (submitcheck('no_submit') && $_GET['method']=='send') {
	//is verify code?
	$input = daddslashes($_GET);
	$data['phone'] = strval($input['mobile'] ? $input['mobile'] : $input['phone']);
	$data['code'] = strval($input['code']);	
	$sendsms = new zhanmishu_transfer($config);	
	$return =  $sendsms->sendsms($data['phone'],$data['code']);

	echo json_encode($return);

}else if (submitcheck('no_submit') && $_GET['method']=='verify') {
	$input = daddslashes($_GET);
	$data['verify'] = $input['smsverify'];
	$data['code'] = $input['code'];

	$verify = new zhanmishu_transfer($config,$data['code'],$data['verify']);
	$return = $verify->safe_verify();
	echo json_encode($return);

}

?>