<?php
/**
 *	[游客变会员(guests.{modulename})] (C)2012-2099 Powered by 源码哥.
 *  Version: 5.0
 *  Date: 2015-09-06 14:06:26
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if (!$_G['adminid']) {
	return false;
}

$perpage = 25;
$page = max(1, $_G['page']);
$start_limit = ($page - 1) * $perpage;
$running = 0;
$member_count = 0;

$res = DB::fetch_first('SELECT ctime FROM '.DB::table('plugin_guests_info').' WHERE name=\'guests\'');
if ($res) {
	$running = floor((time() - strtotime($res['ctime'])) / 86400);
	if ($running <= 0) {
		$running = 0;
	}
}

$res = DB::fetch_first('SELECT count(*) as `count` FROM '.DB::table('plugin_guests_members'));
if ($res) {
	$member_count = $res['count'];
}

$query = DB::query("select * from ".DB::table('plugin_guests_members')." order by ctime desc limit $start_limit, $perpage");
$uids = '';
if ($query) {
	while($value = DB::fetch($query)) {
		if (empty($uids)) {
			$uids = intval($value['uid']);
		} else {
			$uids .= ','.intval($value['uid']);
		}
		$value['referer_sub'] = cutstr($value['referer'], 60);
		$guests_members[intval($value['uid'])] = $value;
	}
}

if (!empty($uids)) {
	$query = DB::query('SELECT * FROM '.DB::table('common_member').' WHERE uid IN('.$uids.')');
	if ($query) {
		while($value = DB::fetch($query)) {
			$guests_members[$value['uid']]['username'] = $value['username'];
			$guests_members[$value['uid']]['location'] = convertip($guests_members[$value['uid']]['ip']);
		}
	}
}

$page = multi($member_count, $perpage, $page, "?action=plugins&operation=config&do=$pluginid&identifier=guests&pmod=member");

include_once template('guests:member');
?>
