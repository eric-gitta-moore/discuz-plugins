<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
include DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
$verify = get_verify_setting();

if(!submitcheck('jiesubmit')) {
	cpheader();
	showtips(lang('plugin/zhanmishu_sms', 'verifytips'));
	showformheader('plugins&operation=config&do=58&identifier=zhanmishu_sms&pmod=open');
	if (check_verify($verify)) {
		echo lang('plugin/zhanmishu_sms', 'opendone');
	}else{
		echo lang('plugin/zhanmishu_sms', 'open');		
	}
	showformfooter();
}else{

	$verify = get_verify($verify);
	if (!$verify) {
		cpmsg(lang('plugin/zhanmishu_sms', 'dataeror'), dreferer(), 'error');
	}
	$verify = serialize($verify);
	C::t('common_setting')->update('verify',$verify);

	updatecache(array('setting'));
	updatemenu('user');
	cpmsg(lang('plugin/zhanmishu_sms', 'setsuccess'), dreferer(), 'succeed');

}




?>