<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_mobileverify.php';

$config=getconfig();

if ($_G['uid']) {
	$return = array('code'=>'-912','msg'=>'you have loging in');
	echo json_encode($return);
	exit;
}

$data = array();
if (submitcheck('no_submit') && $_GET['method']=='send') { 

	// is verify code?
	if ($config['regsmssec'] && $config['seccodecheck']) {
		submitcheck('no_submit',false,true);
	}
	
	$input = daddslashes($_GET);
	$data['phone'] = strval($input['mobile'] ? $input['mobile'] : $input['phone']);
	$data['code'] = strval($input['code']);
	$data['nationcode'] = strval($input['nationcode']);

	$sendsms = new zhanmishu_sms($config);
	$return =  $sendsms->sendsms($data['phone'],$data['code'],'',$data['nationcode']);
	echo json_encode($return);

}else if (submitcheck('no_submit') && $_GET['method']=='verify') {
	$input = daddslashes($_GET);
	$data['verify'] = $input['sms_verify'] ? $input['sms_verify'] : $input['verify'];
	$data['code'] = $input['code'];

	$verify = new zhanmishu_sms($config,$data['code'],$data['verify']);
	$return = $verify->verify();
	echo json_encode($return);

}else if (submitcheck('registersubmit') && $_GET['method']=='register' && $config['ismobileregister']) {

	$input = daddslashes($_GET);
	$data['verify'] = $input['verify'];
	$data['code'] = $input['code'];
	$data['mobile'] =  $input['mobile'];
	$data['username'] = $input['username'];
	$data['passwd'] = $input['passwd'];
	$data['nationcode'] = strval($input['nationcode']);
	// $data['username']  = diconv(strval($data['username']),'UTF-8', CHARSET );
	// $data['passwd']  = diconv(strval($data['passwd']),'UTF-8', CHARSET );
	$register = new zhanmishu_sms($config,$data['code'],$data['verify']);
	$return = $register->mobile_register($data);

	if ($return['code'] == '1') {
		$return['msg'] = dreferer();
			$verify = new zhanmishu_mobileverify($config);
			$ismobileverify = $verify -> ismobile_verify($data['mobile']);
			if (!$ismobileverify && $_G['uid'] && $config['auto_verify']) {
				$verify->set_verify($_G['uid'],false,$data['mobile'],'1','',$_G['username'],true);
			}
	}
	echo json_encode($return);
}

?>