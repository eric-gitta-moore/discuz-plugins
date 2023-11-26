<?php

if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'./source/discuz_version.php';
require_once ('installlang.lang.php');
require_once ('pluginvar.func.php');
$request_url = str_replace('&step='.$_GET['step'],'',$_SERVER['QUERY_STRING']);

//3.1�Ժ�汾ֱ������ɾ�����ݿ�
if(str_replace('X', '', DISCUZ_VERSION) >= 3.1){
		$_GET['step'] = 'sql';
		$_GET['deletesql'] = '20140130223PgBe2WR2G';
}
if($_GET['available']){
	showsubmenusteps($pluginarray['plugin']['name'].$s_installlang[$operation].$s_installlang['ilang_001'], array(
		array($s_installlang['ilang_check'], !$_GET['step']),
		array($s_installlang['ilang_sql'], $_GET['step'] == 'sql'),
		array($s_installlang['ilang_stat'], $_GET['step'] == 'stat'),
		array($s_installlang['ilang_addon'], $_GET['step'] == 'addon'),
		array($s_installlang['ilang_ok'].$s_installlang[$operation], $_GET['step']=='ok'),
	));
}else{
	showsubmenusteps($pluginarray['plugin']['name'].$s_installlang[$operation].$s_installlang['ilang_001'], array(
		array($s_installlang['ilang_check'], !$_GET['step']),
		array($s_installlang['ilang_sql'], $_GET['step'] == 'sql'),
		array($s_installlang['ilang_stat'], $_GET['step'] == 'stat'),
		array($s_installlang['ilang_ok'].$s_installlang[$operation], $_GET['step']=='ok'),
	));
}
switch($_GET['step']){
	default:
	case 'check':
		$available = dfsockopen('http://addon.1314study.com/api/available.php?siteurl='.rawurlencode($_G['siteurl']));
		if($available == 'succeed'){
				$available = 1;
		}else{
				$available = 0;
		}
		cpmsg($s_installlang['ilang_check_ok'], "{$request_url}&step=sql&available=$available", 'loading', array('operation' => $s_installlang[$operation]));
		break;
	case 'sql':
		if(!$_GET['deletesql']) {
			cpmsg($s_installlang['ilang_sql_delete'], "{$request_url}&step=sql&deletesql=1314", 'form', array(), '', TRUE, ADMINSCRIPT."?{$request_url}&step=stat");
		}
		$sql = <<<EOF
DROP TABLE IF EXISTS pre_study_seo_ping;
DROP TABLE IF EXISTS pre_study_seo_ping_article;
EOF;
		runquery($sql);
		cpmsg($s_installlang['ilang_sql_ok'], "{$request_url}&step=stat", 'loading', array('operation' => $s_installlang[$operation]));
		break;
	case 'stat':
		$step = $_GET['available'] ? 'addon' : 'ok';
		if(!$_GET['agreestat']) {
			cpmsg($s_installlang['ilang_stat_agree'], "{$request_url}&step=stat&agreestat=1314", 'form', array(), '', TRUE, ADMINSCRIPT."?{$request_url}&step=$step");
		}
		$_statInfo = array();
		$_statInfo['pluginName'] = $pluginarray['plugin']['identifier'];
		$_statInfo['pluginVersion'] = $pluginarray['plugin']['version'];
		$_statInfo['bbsVersion'] = DISCUZ_VERSION;
		$_statInfo['bbsRelease'] = DISCUZ_RELEASE;
		$_statInfo['timestamp'] = TIMESTAMP;
		$_statInfo['bbsUrl'] = $_G['siteurl'];
		$_statInfo['SiteUrl'] = 'http://127.0.0.1/';
		$_statInfo['ClientUrl'] = 'http://127.0.0.1/';
		$_statInfo['SiteID'] = '';
		$_statInfo['bbsAdminEMail'] = $_G['setting']['adminemail'];
		$_statInfo['action'] = substr($operation,6);
		$_statInfo['genuine'] = splugin_genuine($pluginarray['plugin']['identifier']);
		$_statInfo = base64_encode(serialize($_statInfo));
		$_md5Check = md5($_statInfo);
		$StatUrl = 'http://addon.1314study.com/stat.php';
		$_StatUrl = $StatUrl.'?info='.$_statInfo.'&md5check='.$_md5Check;
		$code =  "<script src=\"".$_StatUrl."\" type=\"text/javascript\"></script>";
		cpmsg($s_installlang['ilang_stat_ok'], "{$request_url}&step=$step", 'loading', array('operation' => $s_installlang[$operation], 'stat_code' => $code));
		break;
	case 'addon':
		if($_GET['available']){
				$_statInfo = array();
				$_statInfo['pluginName'] = $pluginarray['plugin']['identifier'];
				$_statInfo['bbsVersion'] = DISCUZ_VERSION;
				$_statInfo['bbsUrl'] = $_G['siteurl'];
				$_statInfo['action'] = substr($operation,6);
				$_statInfo['nextUrl'] = ADMINSCRIPT.'?'.$request_url;
				$_statInfo = base64_encode(serialize($_statInfo));
				$_md5Check = md5($_statInfo);
				$StatUrl = 'http://addon.1314study.com/api/outer_addon.php';
				$_StatUrl = $StatUrl.'?type=js&info='.$_statInfo.'&md5check='.$_md5Check;
				echo '<script type="text/javascript">location.href="'.$_StatUrl.'";</script>';
		}else{
				echo '<script type="text/javascript">location.href="'.$_G['siteurl'].ADMINSCRIPT.'?'.$request_url.'&step=ok";</script>';
		}
		break;
	case 'ok':
		$finish = TRUE;
		break;
}
?>