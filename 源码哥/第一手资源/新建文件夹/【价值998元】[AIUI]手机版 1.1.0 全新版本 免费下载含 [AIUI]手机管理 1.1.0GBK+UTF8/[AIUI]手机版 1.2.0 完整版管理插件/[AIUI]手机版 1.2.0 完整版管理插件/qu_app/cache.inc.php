<?php
/**
 *      [ainuo] (C)2010-2020 ainuo.
 *
 *      $QQ QQÈº£º550494646 2017-05-18 ainuo $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
global $_G;
loadcache('plugin');

$dirname = DISCUZ_ROOT."/data/sysdata/qu_app_cache"; 
$dirnamepic = DISCUZ_ROOT."/data/attachment/qu_app"; 
function rmdirr($dirname){
	if (!file_exists($dirname)) {
		return false;
	}
	if (is_file($dirname) || is_link($dirname)) {
		return unlink($dirname);
	}
	$dir = dir($dirname);
	while (false !== $entry = $dir->read()) {
		if ($entry == '.' || $entry == '..') {
			continue;
		}
		rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
	}
	$dir->close();
	return rmdir($dirname);
}

cpheader();

if($operation == 'config') {
	$step = max(1, intval($_GET['step']));
	shownav('tools', 'nav_updatecache');
	showsubmenusteps('nav_updatecache', array(
		array('nav_updatecache_confirm', $step == 1),
		array('nav_updatecache_verify', $step == 2),
		array('nav_updatecache_completed', $step == 3)
	));

	//showtips($alang['updatecache_plugintips']);
	if($step == 1) {
		cpmsg('', 'action=plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=cache&step=2', 'form', '', FALSE);
	} elseif($step == 2) {
		$type = implode('_', (array)$_GET['type']);
		cpmsg(cplang('tools_updatecache_waiting'), 'action=plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=cache&step=3&type=$type', 'loading', '', FALSE);
	} elseif($step == 3) {
		$type = explode('_', $_GET['type']);
		rmdirr($dirname);
		rmdirr($dirnamepic);
		cpmsg('update_cache_succeed', '', 'succeed', '', FALSE);
	}
}
$finish = TRUE;
?>