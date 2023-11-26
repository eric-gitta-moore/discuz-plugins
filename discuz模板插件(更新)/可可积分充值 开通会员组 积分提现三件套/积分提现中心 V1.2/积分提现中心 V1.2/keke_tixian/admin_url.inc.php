<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	loadcache('plugin');
	$url=$_G['siteurl'].'plugin.php?id=keke_tixian';
	$src = 'http://qr.liantu.com/api.php?&bg=ffffff&fg=000000&w=250&el=h&text='.urlencode($url);
    showtableheader(lang('plugin/keke_tixian', 'lang53'));
	echo '<tr class="hover"><td>'.$url.'</td></tr>';
	showtableheader(lang('plugin/keke_tixian', 'lang55'));
	echo '<tr class="hover"><td><img src="'.$src.'" /></td></tr>';
    showtablefooter();

