<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	global $_G;
	loadcache('plugin');
	$keke_group = $_G['cache']['plugin']['keke_group'];
	include_once DISCUZ_ROOT."source/plugin/keke_group/common.php";
	$url=$_G['siteurl'].'plugin.php?id=keke_group';
	$src = 'http://qr.liantu.com/api.php?&bg=ffffff&fg=000000&w=250&el=h&text='.urlencode($url);
    showtableheader(lang('plugin/keke_group', 'lang15'));
	echo '<tr class="hover"><td>'.$url.'</td></tr>';
	showtableheader(lang('plugin/keke_group', 'lang16'));
	echo '<tr class="hover"><td><img src="'.$src.'" /></td></tr>';
    showtablefooter();

