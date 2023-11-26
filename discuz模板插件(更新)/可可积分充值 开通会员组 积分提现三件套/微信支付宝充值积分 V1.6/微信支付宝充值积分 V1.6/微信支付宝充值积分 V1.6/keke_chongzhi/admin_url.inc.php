<?php
/*
 *魔趣吧：www.moqu8.com
 *更多商业插件/模版免费下载 就在魔趣吧
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	loadcache('plugin');
	$keke_chongzhi = $_G['cache']['plugin']['keke_chongzhi'];
	$url=$_G['siteurl'].'plugin.php?id=keke_chongzhi';
	$src = 'http://qr.liantu.com/api.php?&bg=ffffff&fg=000000&w=250&el=h&text='.urlencode($url);
    showtableheader(lang('plugin/keke_chongzhi', 'lang25'));
	echo '<tr class="hover"><td>'.$url.'</td></tr>';
	showtableheader(lang('plugin/keke_chongzhi', 'lang26'));
	echo '<tr class="hover"><td><img src="'.$src.'" /></td></tr>';
    showtablefooter();

