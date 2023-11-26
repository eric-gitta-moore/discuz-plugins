<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$page = $_GET['page'] ? intval($_GET['page']) : 1;
$perpage = 10;
$start = ($page - 1) * $perpage;
$conditions = " AND uid='{$_G['uid']}'";
$count = C::t('#e6_propaganda#e6_pro_credit')->count_by_search($conditions);
if ($count) {
	$log_arr = C::t('#e6_propaganda#e6_pro_credit')->fetch_all_by_search($conditions, $start, $perpage);
	foreach($log_arr as $v) {
		$v['type'] = $money_list[$v['type']];
		$v['date'] = dgmdate($v['date']);
		$log_list[] = $v;
	}
	$multi = multi($count, $perpage, $page, $nav_url);
	if (defined('IN_MOBILE') && $page>1) {
		$list_str = "";
		foreach ($log_list as $v) {
			$list_str .= "<li class=\"e6_li\">{$v['describe']}</li>";
		}
		print $list_str;
		exit;
	}
}

?>