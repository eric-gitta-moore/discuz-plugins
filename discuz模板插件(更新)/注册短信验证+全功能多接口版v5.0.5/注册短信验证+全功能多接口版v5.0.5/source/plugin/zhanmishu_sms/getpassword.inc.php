<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include_once DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'source/plugin/zhanmishu_sms/include/zhanmishu_getpassword.php';
$config=getconfig();

$data = array();
if (submitcheck('no_submit') && $_GET['method']=='getpasswordsend') {

	$input = daddslashes($_GET);
	$data['phone'] = strval($input['mobile'] ? $input['mobile'] : $input['phone']);
	$data['code'] = strval($input['code']);
	$data['username'] = strval($input['username']);
	if (!defined('IN_MOBILE') && $data['username']) {
		$data['username']  = diconv(strval($data['username']),'UTF-8', CHARSET );
	}	
	$sendsms = new zhanmishu_getpassword($config);
	$return =  $sendsms->sendsms($data['username'],$data['phone'],$data['code']);
	echo json_encode($return);

}else if (submitcheck('no_submit') && $_GET['method']=='getpasswordverify') {

	$input = daddslashes($_GET);
	$data['phone'] = strval($input['mobile'] ? $input['mobile'] : $input['phone']);
	$data['code'] = strval($input['code']);
	$data['username'] = strval($input['username']);
	$data['verify'] = $input['verify'];
	if (!defined('IN_MOBILE')) {
		$data['username']  = diconv(strval($data['username']),'UTF-8', CHARSET );
	}
	$verify = new zhanmishu_getpassword($config,$data['code'],$data['verify']);
	$return = $verify->verify($data);
	echo json_encode($return);
	exit();

}else if (submitcheck('no_submit') && $_GET['method']=='getpasswordsubmit') {

	$input = daddslashes($_GET);
	$data['phone'] = strval($input['mobile'] ? $input['mobile'] : $input['phone']);
	$data['code'] = strval($input['code']);
	$data['username'] = strval($input['username']);
	$data['verify'] = $input['verify'];
	$data['pwd'] = $input['password'] ? $input['password'] : $input['pwd'];

	if (!defined('IN_MOBILE')) {
		$data['username']  = diconv(strval($data['username']),'UTF-8', CHARSET );
		$data['pwd']  = diconv(strval($data['pwd']),'UTF-8', CHARSET );
	}
	$verify = new zhanmishu_getpassword($config,$data['code'],$data['verify']);
	$return = $verify->changepwd($data);
	echo json_encode($return);
	exit();

}else if (!empty($_POST) && $_GET['mod'] =='mobilegetpasswd') {

	$input = daddslashes($_GET);
	$data['phone'] = strval($input['mobile']);
	$data['code'] = strval($input['code']);
	$data['username'] = strval($input['lostpw_mobileusername']);
	$data['verify'] = $input['sms_verify'];
	$data['pwd'] = $input['lostpw_passwd'];
	$data['pwd1'] = $input['lostpw_passwd1'];
	if (!defined('IN_MOBILE')) {
		$data['username']  = diconv(strval($data['username']),'UTF-8', CHARSET );
		$data['pwd']  = diconv(strval($data['pwd']),'UTF-8', CHARSET );
		$data['pwd1']  = diconv(strval($data['pwd1']),'UTF-8', CHARSET );
	}

	switch ($data) {
		case !$data['username']:
			showmessage(lang('plugin/zhanmishu_sms','please_input_username'),'','error');
			break;
		case strlen($data['username']) < 1:
			showmessage(lang('plugin/zhanmishu_sms','username_wrong'),'','error');
			break;
		case !$ismobile = verify_mobile_number($data['phone']):
			showmessage(lang('plugin/zhanmishu_sms','please_input_mobile'),'','error');
			break;
		case !$data['code']:
			showmessage(lang('plugin/zhanmishu_sms','please_get_verifycode'),'','error');
			break;
		case !$data['verify']:
			showmessage(lang('plugin/zhanmishu_sms','please_input_verifycode'),'','error');
			break;
		case !$data['pwd']:
			showmessage(lang('plugin/zhanmishu_sms','please_input_password'),'','error');
			break;
		case strlen($data['pwd']) < $_G['setting']['pwlength']:
			showmessage(lang('plugin/zhanmishu_sms','password_wrong'),'','error');
			break;
		case !$data['pwd1']:
			showmessage(lang('plugin/zhanmishu_sms','please_input_password1'),'','error');
			break;
		
		case $data['pwd1'] !== $data['pwd']:
			showmessage(lang('plugin/zhanmishu_sms','pwd_is_not_same'),'','error');
			break;
		default:
			
			break;
	}

	$verify = new zhanmishu_getpassword($config,$data['code'],$data['verify']);
	$return = $verify->changepwd($data);
	$msg =diconv(strval($return['msg']),'UTF-8', CHARSET );
	if ($return['code'] < 1) {
		showmessage($msg,'','error');
	}else{
		showmessage($msg,'member.php?mod=logging&action=login','success');
	}
}else{

	if (defined('IN_MOBILE')) {
		dheader("location:plugin.php?id=zhanmishu_sms:register#/Password");
		exit;
	}
	include template('zhanmishu_sms:getpasswd');

}


?>