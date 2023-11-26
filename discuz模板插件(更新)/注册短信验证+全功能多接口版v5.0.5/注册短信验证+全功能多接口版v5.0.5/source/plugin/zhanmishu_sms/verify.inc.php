<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if (!$_G['uid'] && $_GET['method'] !== 'verify' && $_GET['method'] !== 'login' && $_GET['method'] !== 'loginsend') {
	showmessage('please_login', '', array(), array('login' => true));
}
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_mobileverify.php';
$config=getconfig();
$referer = $_GET['referer'] ? $_GET['referer'] : dreferer();
		
$data = array();
if (submitcheck('no_submit') && $_GET['method']=='send') {


	$input = daddslashes($_GET);
	$data['phone'] = strval($input['phone'] ? $input['phone'] : $input['mobile']);
	$data['code'] = strval($input['code']);
	$data['nationcode'] = strval($input['nationcode']);

	$sendsms = new zhanmishu_mobileverify($config);
	$return =  $sendsms->sendsms($data['phone'],$data['code'],true,false,false,$data['nationcode']);
	echo json_encode($return);
	exit();

}else if (submitcheck('no_submit') && $_GET['method']=='loginsend') { 

	// is verify code?
	if ($config['regsmssec'] && $config['seccodecheck']) {
		submitcheck('no_submit',false,true);
	}
	
	$input = daddslashes($_GET);
	$data['phone'] = strval($input['mobile'] ? $input['mobile'] : $input['phone']);
	$data['code'] = strval($input['code']);
	$data['nationcode'] = strval($input['nationcode']);

	$sendsms = new zhanmishu_mobileverify($config);
	$uid = $sendsms->getuidbymobile($data['phone']);
	if (!$uid) {
		$return = array('code'=>'-16','msg'=>'user is not exists');
		echo json_encode($return);
		exit;
	}
	$return =  $sendsms->sendsms($data['phone'],$data['code'],false,false,false,$data['nationcode']);
	echo json_encode($return);

}else if (submitcheck('loginsubmit') && $_GET['method']=='login' && ($config['issmslogin'] || true)) {

	$input = daddslashes($_GET);
	$data['verify'] = $input['verify'];
	$data['code'] = $input['code'];
	$data['mobile'] =  $input['mobile'];

	$login = new zhanmishu_mobileverify($config,$data['code'],$data['verify']);
	
	$return = $login->logbymobile($data['mobile']);

	echo json_encode($return);
}else if (submitcheck('no_submit') && $_GET['method']=='verify') {
	$input = daddslashes($_GET);
	$data['verify'] = $input['verify'];
	$data['code'] = $input['code'];

	$verify = new zhanmishu_mobileverify($config,$data['code'],$data['verify']);
	$return = $verify->verify();
	echo json_encode($return);
	exit();
}else if (submitcheck('send_verify_Button') && $_GET['method']=='submit') {
	$input = daddslashes($_GET);
	$data['verify'] = $input['verify'] ? $input['verify'] : $input['verifycode'];
	$data['code'] = $input['code'];

	$verify = new zhanmishu_mobileverify($config,$data['code'],$data['verify']);
	$return = $verify->mobile_verify();
	if (defined('IN_MOBILE') && $_GET['isnew']) {
		echo json_encode($return);
		exit;
	}
	$return['msg'] =diconv(strval($return['msg']),'UTF-8', CHARSET );
	if ($return['code'] == '1') {
		if (defined('IN_MOBILE') || $_GET['from'] =='mobileverify') {
			showmessage($result['msg'], $referer, array(),'success');
		}
		showmessage('', $referer, array(),array('showid' => '','extrajs' => '<script type="text/javascript">'.'hideWindow("mobileverify");showDialog("'.$return['msg'].'","right");top.location.href="'.$referer.'";</script>'.$ucsynlogin,'showdialog' => false));
	}else{
		showmessage($return['msg'], $referer, array(),array('showid' => '','striptags' => false,'showdialog' => true));
	}
	exit();
}else if (submitcheck('no_submit') && $_GET['method']=='editsend') {
	$input = daddslashes($_GET);
	$data['phone'] =  strval($input['phone'] ? $input['phone'] : $input['mobile']);
	$data['code'] = strval($input['code']);
	$data['nationcode'] = strval($input['nationcode']);

	$sendsms = new zhanmishu_mobileverify($config);
	//$return = $sendsms->sendpost('15528055356',array('aproduct'=>'AAA','name'=>'ali'),'7');
	$return =  $sendsms->sendsms($data['phone'],$data['code'],false,true,false,$data['nationcode']);
	echo json_encode($return);
	exit();

}else if (submitcheck('no_submit') && $_GET['method']=='new_send') {
	$input = daddslashes($_GET);
	$data['phone'] = strval($input['phone'] ? $input['phone'] : $input['new_mobile']);
	$data['code'] = strval($input['new_code'] ? $input['new_code'] : $input['code']);
	$data['verify'] = $input['verify'] ? $input['verify'] : $input['verifycode'];
	$data['oldcode'] = $input['oldcode'] ? $input['oldcode'] : $input['code'];
	$data['nationcode'] = strval($input['nationcode']);

	$sendsms = new zhanmishu_mobileverify($config,$data['oldcode'],$data['verify']);
	$return = $sendsms->new_send($data['phone'],$data['code'],1,false,false,$data['nationcode']);
	echo json_encode($return);
	exit();

}else if (submitcheck('no_submit') && $_GET['method']=='new_verify') {
	$input = daddslashes($_GET);
	$data['oldmobile'] = strval($input['oldmobile']);
	$data['mobile'] = strval($input['new_mobile'] ? $input['new_mobile'] : $input['mobile']);
	$data['oldverify'] = $input['oldverify'];
	$data['verify'] = $input['verify'];
	$data['oldcode'] = $input['oldcode'];
	$data['code'] = $input['new_code'] ? $input['new_code'] : $input['code'];

	$verify = new zhanmishu_mobileverify($config,$data['code'],$data['verify']);
	$return = $verify->new_verify($data);
	echo json_encode($return);
	exit();
}else if (submitcheck('send_verify_Button') && $_GET['method']=='edit') {

	$input = daddslashes($_GET);
	$data['oldmobile'] = strval($input['new_mobile']) ? $input['mobile'] : $input['oldmobile'];
	$data['mobile'] = strval($input['new_mobile']) ? strval($input['new_mobile'])  : $input['mobile'];
	$data['oldverify'] = $input['verifycode'] ? $input['verifycode'] : $input['oldverify'];
	$data['verify'] = $input['new_verifycode'] ? $input['new_verifycode'] : $input['verify'];
	$data['oldcode'] = $input['new_code'] ? $input['code'] : $input['oldcode'];
	$data['code'] = $input['new_code'] ? $input['new_code'] : $input['code'];

	$verify = new zhanmishu_mobileverify($config,$data['code'],$data['verify']);
	$result = $verify->change_mobile($data);
	if (defined('IN_MOBILE') && $_GET['isnew']) {
		echo json_encode($result);
		exit;
	}
	$msg =diconv(strval($result['msg']),'UTF-8', CHARSET );
	if ($result['code'] == '1') {
		if (defined('IN_MOBILE') || $_GET['from'] =='mobileverify') {
			showmessage($msg, $referer, array(),'success');
		}
		showmessage($msg, $referer, array(),array('showid' => '','extrajs' => '<script type="text/javascript">'.'hideWindow("mobileverify");showDialog("'.$msg.'","right");top.location.href="'.$referer.'";</script>'.$ucsynlogin,'showdialog' => false));
		
	}else{
		showmessage($msg, $referer, array(),array('showid' => '','striptags' => false,'showdialog' => true));
	}

	exit();
}else{

	// if (!$_GET['act']) {
	// 	$verify = new zhanmishu_mobileverify();
	//  	$isverify = $verify->check_user_isverify($_G['uid']);
	// 	if ($isverify) {
	// 		showmessage(lang('plugin/zhanmishu_sms','haven_verify_thissuer'), $referer);
	// 		exit;
	// 	}
	// }
	$mobile = verify_mobile_number($_GET['mobile']) ? $_GET['mobile']:getuserprofile('mobile');

	if (defined('IN_MOBILE') && !$mobile) {
		dheader("location:plugin.php?id=zhanmishu_sms:register#/verify");
		exit;
	}else if (defined('IN_MOBILE')){
		dheader("location:plugin.php?id=zhanmishu_sms:register#/verifyedit");
		exit;		
	}

	include template("zhanmishu_sms:verify");
}



?>