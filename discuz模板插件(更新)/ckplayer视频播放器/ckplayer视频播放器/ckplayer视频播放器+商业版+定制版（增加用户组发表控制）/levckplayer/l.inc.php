<?php

/**
 * 魔趣吧官网：http://www.moqu8.com - 私.密.吧
 *
 * [魔趣吧!] (C)2014-2017 www.moqu8.com.  By www-魔趣吧-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;

require_once 'lev_enter.php';

$m = trim($_GET['m']) ? trim($_GET['m']) : (trim($_POST['m']) ? trim($_POST['m']) : '_run');
if (!preg_match('/^[a-zA-Z_.,-][a-zA-Z0-9_.,-=]+$/', $m)) exit('error param m!');
$param = explode('.', $m);
$func  = isset($param[0]) && trim($param[0]) ? trim($param[0]) : '_run';
unset($param[0]);

if ($func[0] !='_') {
	if (!$_G['uid']) exit('error op!');
	if ($_G['adminid'] !=1) {//check admin
		exit('error op!');
	}
}

if (!method_exists('lev_class', $func)) exit('method not exits!');

if ($func[1] !='_' && $_G['adminid'] !=1) lev_class::checkfh();

call_user_func_array(array($C, $func), $param);






