<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/*www-Cgzz8-com*/include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/function.php';
/*www-Cgzz8-com*/include_once DISCUZ_ROOT.'./source/plugin/zhanmishu_sms/include/Autoloader.php';

$config=getconfig();


$data = array();




include template("zhanmishu_sms:action");
