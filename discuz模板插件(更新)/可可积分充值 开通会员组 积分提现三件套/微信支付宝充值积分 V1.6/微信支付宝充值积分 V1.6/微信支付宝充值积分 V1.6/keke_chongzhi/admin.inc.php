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
	if (submitcheck("forumset")) {
		C::t('#keke_chongzhi#keke_chongzhi_orderlog')->del_oder();
		cpmsg(lang('plugin/keke_chongzhi', 'lang07'), 'action=plugins&operation=config&identifier=keke_chongzhi&pmod=admin', 'succeed');
	}
    showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=admin");
    showtableheader(lang('plugin/keke_chongzhi', 'lang08'));
	showsubmit('forumset', lang('plugin/keke_chongzhi', 'lang09'), '', '');
	showtableheader(lang('plugin/keke_chongzhi', 'lang10'));
    showsubtitle(array(lang('plugin/keke_chongzhi', 'lang11'),lang('plugin/keke_chongzhi', 'lang12'), lang('plugin/keke_chongzhi', 'lang13'), lang('plugin/keke_chongzhi', 'lang14'),lang('plugin/keke_chongzhi', 'lang15'),lang('plugin/keke_chongzhi', 'lang16'),lang('plugin/keke_chongzhi', 'lang17'),lang('plugin/keke_chongzhi', 'lang18'),lang('plugin/keke_chongzhi', 'lang19')));
	$creditdata=$_G['cache']['keke_chongzhi_credit'] ? $_G['cache']['keke_chongzhi_credit'] : C::t('#keke_chongzhi#keke_chongzhi_credit')->fetchall_credit();
	$ppp=$keke_chongzhi['pgt'] ? intval($keke_chongzhi['pgt']) : 2;
	$tmpurl='admin.php?action=plugins&operation=config&identifier=keke_chongzhi&pmod=admin';
	$page = max(1, intval($_GET['page']));
	$startlimit = ($page - 1) * $ppp;
	$uid=1;
	$allcount = C::t('#keke_chongzhi#keke_chongzhi_orderlog')->count_by_all();
	if($allcount){
		$query = C::t('#keke_chongzhi#keke_chongzhi_orderlog')->fetch_all_by_all(0,0,$startlimit,$ppp);
		foreach($query as $val){
			$money=$val['money']/100;
			$time=dgmdate($val['zftime'], 'Y/m/d H:i');
			$cradit='<font color="#c30"><b>'.intval($money*$creditdata[$val['credittype']]['bili']).'</b></font> '.$_G['setting']['extcredits'][$val['credittype']]['title'];
			$stat=$val['state'] ? '<font color="#33CC33">'.lang('plugin/keke_chongzhi', 'lang20').'</font>' : '<font color="#c30">'.lang('plugin/keke_chongzhi', 'lang21').'</font>' ;
			$type=$val['type']==1 ? lang('plugin/keke_chongzhi', 'lang22') : lang('plugin/keke_chongzhi', 'lang23') ;
			$table = array();
			$table[0] = $val['orderid'];
			$table[1] = $val['usname'];
			$table[2] = $cradit;
			$table[3] = $money.' '.lang('plugin/keke_chongzhi', 'lang03');
			$table[4] = $type;
			$table[5] = $stat;
			$table[6] = $val['sn'] ? $val['sn'] : '<font color="#CCCCCC">--</font>';
			$table[7] = dgmdate($val['time'], 'Y/m/d H:i');
			$table[8] = $val['zftime'] ? dgmdate($val['zftime'], 'Y/m/d H:i') : '<font color="#CCCCCC">--</font>';
			showtablerow('',array(), $table);
		}
	}
	$multipage='';
	$multipage = multi($allcount, $ppp, $page, $_G['siteurl'].$tmpurl);
	echo '<tr class="hover"><td colspan="9">'.$multipage.'</td></tr>';
    showtablefooter();
    showformfooter();
