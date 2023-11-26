<?php
if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once ('installlang.lang.php');
require_once ('pluginvar.func.php');
$request_url=str_replace('&step='.$_GET['step'],'',$_SERVER['QUERY_STRING']);
showsubmenusteps($pluginarray['plugin']['name'].$s_installlang[$operation].$s_installlang['ilang_001'], array(
	array($s_installlang['ilang_check'], !$_GET['step']),
	array($s_installlang['ilang_sql'], $_GET['step'] == 'sql'),
	array($s_installlang['ilang_stat'].$s_installlang[$operation], $_GET['step'] == 'stat' || $_GET['step']=='ok'),
));
if($_GET['step']){
sleep(1);
}
switch($_GET['step']){
	default:
	case 'check':
		cpmsg($s_installlang['ilang_check_ok'], "{$request_url}&step=sql", 'loading', array('operation' => $s_installlang[$operation]));
		break;
	case 'sql':
		if(!$_GET['deletesql']) {
			cpmsg($s_installlang['ilang_sql_delete'], "{$request_url}&step=sql&deletesql=1314", 'form', array(), '', TRUE, ADMINSCRIPT."?{$request_url}&step=stat");
		}
		cpmsg($s_installlang['ilang_sql_ok'], "{$request_url}&step=stat", 'loading', array('operation' => $s_installlang[$operation]));
		break;
	case 'stat':
		$_StatUrl = 'http://www.xhkj5.com/addon.php';
		$code =  "<script src=\"".$_StatUrl."\" type=\"text/javascript\"></script>";
		cpmsg($s_installlang['ilang_stat_ok'], "{$request_url}&step=ok", 'loading', array('operation' => $s_installlang[$operation], 'stat_code' => $code));
		break;
	case 'ok':
		$finish = TRUE;
		break;
}
?>