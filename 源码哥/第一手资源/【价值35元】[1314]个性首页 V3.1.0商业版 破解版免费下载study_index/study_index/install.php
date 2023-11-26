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
		$addonid = $pluginarray['plugin']['identifier'].'.plugin';
		$array = cloudaddons_getmd5($addonid);
		cpmsg($s_installlang['ilang_check_ok'], "{$request_url}&step=sql", 'loading', array('operation' => $s_installlang[$operation]));
		break;
	case 'sql':
		cpmsg($s_installlang['ilang_sql_ok'], "{$request_url}&step=stat", 'loading', array('operation' => $s_installlang[$operation]));
		break;
	case 'stat':
		cpmsg("&#x7f13;&#x5b58;&#x6e05;&#x7a7a;&#x5b8c;&#x6bd5;", "{$request_url}&step=ok", 'loading');

		break;
	case 'ok':
		//¸üÐÂ»º´æ
		splugin_updatecache($pluginarray['plugin']['identifier']);
		$finish = TRUE;
		break;
}
?>