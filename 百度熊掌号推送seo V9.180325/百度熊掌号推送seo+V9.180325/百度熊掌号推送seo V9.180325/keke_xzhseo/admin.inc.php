<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	loadcache('plugin');
	if (submitcheck("forumset")) {
		if(is_array($_GET['delete'])) {
				C::t('#keke_xzhseo#keke_xzhseo')->delete($_GET['delete']);
		}
		cpmsg(lang('plugin/keke_xzhseo', '013'), 'action=plugins&operation=config&identifier=keke_xzhseo&pmod=admin', 'succeed');
	}
	
	showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin");	
	showtableheader(lang('plugin/keke_xzhseo', '001'));
    showsubtitle(array(lang('plugin/keke_xzhseo', '014'),lang('plugin/keke_xzhseo', '015'),lang('plugin/keke_xzhseo', '016'),lang('plugin/keke_xzhseo', '017'),lang('plugin/keke_xzhseo', '019'),lang('plugin/keke_xzhseo', '020')));
	$ppp=20;
	$tmpurl='admin.php?action=plugins&operation=config&identifier=keke_xzhseo&pmod=admin';
	$page = max(1, intval($_GET['page']));
	$startlimit = ($page - 1) * $ppp;
	$count = C::t('#keke_xzhseo#keke_xzhseo')->count_all();
	if($count){
		$liatdata = C::t('#keke_xzhseo#keke_xzhseo')->fetch_all_by_limit($startlimit,$ppp);
		foreach($liatdata as $key=>$val){
			$type=$state='';
			switch ($val['type']) {
				case 1:$type=$val['mods']==2 ? lang('plugin/keke_xzhseo', '006') :lang('plugin/keke_xzhseo', '021');break;
				case 2:$type=lang('plugin/keke_xzhseo', '007');break;
			}
			switch ($val['state']) {
				case 1:$state=lang('plugin/keke_xzhseo', '009');break;
				case 2:$state=lang('plugin/keke_xzhseo', '012').lang('plugin/keke_xzhseo', '010');break;
				case 3:$state=lang('plugin/keke_xzhseo', '011');break;
				case 4:$state=lang('plugin/keke_xzhseo', '012').lang('plugin/keke_xzhseo', '022');break;
				default:$state=lang('plugin/keke_xzhseo', '012').$val['msg'];
			}
			$table = array();
			$table[0] = '<input type="checkbox" class="checkbox" name="delete[]" value="'.$val['id'].'" />';
			$table[1] = '<a href="'.$val['url'].'" target="_blank">'.$val['subject'].'</a>';
			$table[2] = '<a href="'.$val['url'].'" target="_blank">'.$val['url'].'</a>';
			$table[3] = $type;
			$table[4] = $state;
			$table[6] = dgmdate($val['time'], 'Y/m/d H:i');
			showtablerow('',array(), $table);
		}
	}
	$multipage='';
	$multipage = multi($count, $ppp, $page, $_G['siteurl'].$tmpurl);
	echo '<tr class="hover"><td colspan="9">'.$multipage.'</td></tr>';
	showsubmit('forumset', 'submit', 'del');
    showtablefooter();
	showformfooter();