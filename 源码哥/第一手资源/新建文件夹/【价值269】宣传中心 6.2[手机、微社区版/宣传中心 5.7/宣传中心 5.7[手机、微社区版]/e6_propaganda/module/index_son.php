<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$page = $_GET['page'] ? intval($_GET['page']) : 1;
$perpage = 10;
$start = ($page - 1) * $perpage;
$conditions = " AND fuid1='{$_G['uid']}'";
$count = C::t('#e6_propaganda#e6_pro_user')->count_by_search($conditions);
if ($count) {
	$group_list = C::t('common_usergroup')->fetch_all_by_type();
	$status = array(pro_lang('no_reward'), pro_lang('yes_reward'));
	$son_arr = C::t('#e6_propaganda#e6_pro_user')->fetch_all_by_son($conditions, $start, $perpage);
	$n = ($page-1) * $perpage + 1;
	foreach($son_arr as $v) {
		$v['n'] = $n;
		$v['groupid'] = $group_list[$v['groupid']]['grouptitle'];
		$v['date'] = dgmdate($v['regdate'], 'Y-m-d');
		$v['regdate'] = dgmdate($v['regdate']);
		$v['register'] = $status[$v['register']];
		$v['region'] = $status[$v['region']];
		$v['activation1'] = $status[$v['activation1']];
		$v['activation2'] = $status[$v['activation2']];
		$v['activation3'] = $status[$v['activation3']];
		$v['activation4'] = $status[$v['activation4']];
		$v['activation5'] = $status[$v['activation5']];
		$v['activation6'] = $status[$v['activation6']];
		$v['activation7'] = $status[$v['activation7']];
		$v['activation8'] = $status[$v['activation8']];
		$v['activation9'] = $status[$v['activation9']];
		$v['activation10'] = $status[$v['activation10']];
		$n++;
		$son_list[] = $v;
	}
	for ($n = 1; $n <= $e6_propaganda['active_num']; $n++) {
		$active_title[$n] = pro_lang('active_n', array('n'=>$n));
	}
	if (defined('IN_MOBILE') && $page>1) {
		$list_str = "";
		foreach ($son_list as $v) {
			$list_str .= "<li class=\"e6_li\"><span>{$v['username']}</span><span>{$v['groupid']}</span><span>{$v['regdate']}</span></li>";
		}
		print $list_str;
		exit;
	}
	$multi = multi($count, $perpage, $page, $nav_url);
}
 
?>