<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	loadcache('plugin');
	include_once DISCUZ_ROOT."source/plugin/keke_xzhseo/keke_xzhseo.class.php";
	$xzh=new plugin_keke_xzhseo;
	if (submitcheck("forumset")) {
		if(!$_GET['qsid']){
			cpmsg(lang('plugin/keke_xzhseo', '031'), 'action=plugins&operation=config&identifier=keke_xzhseo&pmod=admin_l', 'error');
		}
		if(!$_GET['tsnum']){
			cpmsg(lang('plugin/keke_xzhseo', '032'), 'action=plugins&operation=config&identifier=keke_xzhseo&pmod=admin_l', 'error');
		}
		for($i=intval($_GET['qsid']);$i<intval($_GET['tsnum']);$i++){
			$urlarr[]=$xzh->_creurl(intval($_GET['mods']),$i);
		}
		$ret=$xzh->_posttobaidu('','',2,$urlarr);
		cpmsg($ret, 'action=plugins&operation=config&identifier=keke_xzhseo&pmod=admin_l', 'succeed');
	}
	showtips(lang('plugin/keke_xzhseo', '028'));
	showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin_l");	
	showtableheader(lang('plugin/keke_xzhseo', '029'));
	
	showsetting(lang('plugin/keke_xzhseo', '033'), array('mods', array(
	array(2,lang('plugin/keke_xzhseo', '034')),
	array(1,lang('plugin/keke_xzhseo', '035')),
	)), '', 'select');
	showsetting(lang('plugin/keke_xzhseo', '036'),'qsid','','text','','',lang('plugin/keke_xzhseo', '037'));
	showsetting(lang('plugin/keke_xzhseo', '038'),'tsnum','','text','','',lang('plugin/keke_xzhseo', '039'));
	
	showsubmit('forumset', 'submit');
    showtablefooter();
	showformfooter();