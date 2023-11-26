<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      V1.0 QQ179667784
 *		WWW.DZZSK.COM
 *      POWERED BY AINUO 
 */
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;
$view = $_GET['view'];
loadcache('ranklist');
loadcache('ranklisttop');
$langvars=lang('plugin/qu_ranklist');
$vars = $_G['cache']['plugin']['qu_ranklist'];
$hy_con = $vars['hy_con'];
$jf_con = $vars['jf_con'];
$tz_con = $vars['tz_con'];
$zt_con = $vars['zt_con'];
$aicon = $vars['icon'];
$qujian = $vars['qujian'] ? $vars['qujian'] : 100;
$astyle = $vars['astyle'];
$atitle = $vars['atitle'];
$atime = $vars['atime'];
$touchcolor = $vars['touchcolor'];
$qu_listnum = $vars['num'];

$navtitle = $vars['navtitle'];
$metakeywords = $vars['metakeywords'];
$metadescription = $vars['metadescription'];

if(!in_array($view, array('credits', 'posts', 'threads','friends'))) {
	$view = 'credits';
}
$currentview[$view] = 'class="xw1 a"';
$perpage = $qu_listnum ? $qu_listnum : 10;
$start = $perpage * ($_G['page'] - 1);
$data = array();
$data[$view] = get_user_list($view, $start, $perpage);
$count = $data[$view]['usercount'];
$mpurl = 'plugin.php?id=qu_ranklist:ranklist&view='.$view;
$multipage = multi($count, $perpage, $_G['page'], $mpurl);

//获取个人信息排名
if($_G['uid']){
	$thisuid  = explode(',',$vars['xhkj5uids']);
	if (!in_array($_G['uid'],$thisuid)){
	$myview = C::t('#qu_ranklist#plugin_qu_ranklist')->fetch_by_conlist($view,$_G['uid']);
	$opos = C::t('#qu_ranklist#plugin_qu_ranklist')->fetch_user_by_uid($view);
	$o=0;
	foreach($opos as $pos){
		$o++;
		if(($pos[$view] == $myview) && ($pos['uid'] == $_G['uid'])){
			$mypos = $o;
			break;
		}
	}
	}
}

include template('qu_ranklist:index');

//获取所有会员列表
function get_user_list($view, $start = 0, $num = 10) {
	global $_G,$atime,$start;
	$thisuid  = explode(',',$_G['cache']['plugin']['qu_ranklist']['xhkj5uids']);
	$cachetimelimit = $atime ? $atime : 0;
	$cache = $_G['cache']['ranklist'][$view];
	if($cache && (TIMESTAMP - $cache['cachetime']) < $cachetimelimit) {
		$uids = $cache['data'];
		foreach ($uids as $key=>$value)
		{
		if (in_array($value,$thisuids)){
		unset($uids[$key]);
		}
		}
		$usercount = count($uids);
		$uids = array_slice($uids, $start, $num, true);
		$updatecache = false;
		if(empty($uids)) {
			return array();
		}
	} else {
		$uids = array();
		$updatecache = true;
	}
	
	$query = C::t('#qu_ranklist#plugin_qu_ranklist')->fetch_user_by_uid($view, $uids);
	$n = 0;
	foreach($query as $user) {
		if (!in_array($user['uid'],$thisuid)){
		$userids[] = $user['uid'];
		}
		if($uids || ($n >= $start && $n < ($start + $num))) {
		if (!in_array($user['uid'],$thisuid)){
		$list[$user[uid]] = $user;
		}
		}
		$n++;
	}
	$userlist = array();
	if($uids) {
		$userids = array();
		foreach($uids as $key => $uid) {
			if($list[$uid]) {
				if (!in_array($uid,$thisuid)){
				$userlist[$key] = $list[$uid];
				$userids[] = $uid;
				}
			}
		}
	} else {
		$userlist = $list;
	}

	unset($list);
	if($updatecache) {
		$usercount = count($userids);
		$data = array('cachetime' => TIMESTAMP, 'data' => $userids);
		$_G['cache']['ranklist'][$view] = $data;
		savecache('ranklist', $_G['cache']['ranklist']);
	}
	return array('usercount' => $usercount, 'userlist' => $userlist);
}



?>