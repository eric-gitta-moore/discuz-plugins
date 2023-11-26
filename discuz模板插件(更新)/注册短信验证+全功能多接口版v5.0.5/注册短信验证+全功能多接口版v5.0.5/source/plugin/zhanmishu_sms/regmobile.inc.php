<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if (!$_G['uid']) {
	exit('Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_mobileverify.php';
$config=getconfig();
$referer = $_GET['referer'] ? $_GET['referer'] : dreferer();

$verify = new zhanmishu_mobileverify();

$v = $verify->get_member_verify_info();
$isverify = $verify->check_user_isverify();


?>