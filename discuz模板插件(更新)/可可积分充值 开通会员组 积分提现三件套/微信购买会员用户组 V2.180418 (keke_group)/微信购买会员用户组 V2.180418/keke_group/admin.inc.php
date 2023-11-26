<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	global $_G;
	loadcache('plugin');
	$keke_group = $_G['cache']['plugin']['keke_group'];
	include_once DISCUZ_ROOT."source/plugin/keke_group/common.php";
	
	
	if (submitcheck("forumsets")) {
		if(is_array($_GET['delete'])) {
				C::t('#keke_group#keke_group_orderlog')->delete($_GET['delete']);
		}
		cpmsg(lang('plugin/keke_group', 'lang18'), 'action=plugins&operation=config&identifier=keke_group&pmod=admin', 'succeed');
	}
	
	
	
	if (submitcheck("forumset")) {
		C::t('#keke_group#keke_group_orderlog')->del_oder();
		cpmsg(lang('plugin/keke_group', 'lang18'), 'action=plugins&operation=config&identifier=keke_group&pmod=admin', 'succeed');
	}
    showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin");
    showtableheader(lang('plugin/keke_group', 'lang19'));
	showsubmit('forumset', lang('plugin/keke_group', 'lang20'), '', '');
	
	showtableheader(lang('plugin/keke_group', 'lang21'));
    showsubtitle(array(lang('plugin/keke_group', 'lang22'),lang('plugin/keke_group', 'lang23'),lang('plugin/keke_group', 'lang24'), lang('plugin/keke_group', 'lang25'), lang('plugin/keke_group', 'lang26'),lang('plugin/keke_group', 'lang27'),lang('plugin/keke_group', 'lang28'),lang('plugin/keke_group', 'lang29'),lang('plugin/keke_group', 'lang30'),lang('plugin/keke_group', 'lang31'),lang('plugin/keke_group', 'lang32')));
	
	$ppp=50;
	$tmpurl='admin.php?action=plugins&operation=config&identifier=keke_group&pmod=admin';
	$page = max(1, intval($_GET['page']));
	$startlimit = ($page - 1) * $ppp;
	$allcount = C::t('#keke_group#keke_group_orderlog')->count_by_all();
	if($allcount){
		$query = C::t('#keke_group#keke_group_orderlog')->fetch_all_by_all(0,0,$startlimit,$ppp);
		foreach($query as $val){
			$money=$val['money']/100;
			$time=dgmdate($val['zftime'], 'Y/m/d H:i');
			$stat=$val['state'] ? '<font color="#33CC33">'.lang('plugin/keke_group', 'lang10').'</font>' : '<font color="#c30">'.lang('plugin/keke_group', 'lang11').'</font>' ;
			$type=$val['type']==1 ? lang('plugin/keke_group', 'lang12') : lang('plugin/keke_group', 'lang13') ;
			$table = array();
			$table[0] = '<input type="checkbox" class="checkbox" name="delete[]" value="'.$val['orderid'].'" />';
			$table[1] = $val['orderid'];
			$table[2] = $val['usname'];
			$table[3] = $val['groupname'];
			$table[4] = $val['groupvalidity'].' '.lang('plugin/keke_group', 'lang09');
			$table[5] = $money.' '.lang('plugin/keke_group', 'lang03');
			$table[6] = $type;
			$table[7] = $stat;
			$table[8] = dgmdate($val['time'], 'Y/m/d H:i');
			$table[9] = $val['zftime'] ? dgmdate($val['zftime'], 'Y/m/d H:i') : '<font color="#CCCCCC">--</font>';
			$table[10] = $val['sn'] ? $val['sn'] : '<font color="#CCCCCC">--</font>';
			showtablerow('',array(), $table);
		}
	}
	$multipage='';
	$multipage = multi($allcount, $ppp, $page, $_G['siteurl'].$tmpurl);
	if($multipage){
		echo '<tr class="hover"><td colspan="10">'.$multipage.'</td></tr>';
	}
	showsubmit('forumsets', 'submit', 'del');
    showtablefooter();
    showformfooter();
