<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';
include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/zhanmishu_notice.php';
$config=getconfig();

$notice = new zhanmishu_notice($config);

$notice->emailnotice();
$notice->smsnotice();
$notice->groupsmsnotice(); 



?>