<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	loadcache('plugin');
	include_once DISCUZ_ROOT."source/plugin/keke_xzhseo/keke_xzhseo.class.php";
	$xzh=new plugin_keke_xzhseo;
	if (submitcheck("forumset")) {
		if(!$_GET['posturl']){
			cpmsg(lang('plugin/keke_xzhseo', '030'), 'action=plugins&operation=config&identifier=keke_xzhseo&pmod=admin_p', 'error');
		}
		$urldata=$_GET['posturl'];
		$urlarr=explode("/hhf/",str_replace(array("\r\n", "\n", "\r"), '/hhf/',$urldata));
		include_once DISCUZ_ROOT."source/plugin/keke_xzhseo/keke_xzhseo.class.php";
		$ret=$xzh->_posttobaidu('','',1,$urlarr);
		cpmsg($ret, 'action=plugins&operation=config&identifier=keke_xzhseo&pmod=admin_p', 'succeed');
	}
	showtips(lang('plugin/keke_xzhseo', '025'));
	showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin_p");	
	showtableheader(lang('plugin/keke_xzhseo', '026'));
	
	$table = array();
	$table[0] =  '<textarea cols="100" rows="20" name="posturl"></textarea>';
	showtablerow('',array(), $table);
	
	showsubmit('forumset', 'submit');
    showtablefooter();
	showformfooter();