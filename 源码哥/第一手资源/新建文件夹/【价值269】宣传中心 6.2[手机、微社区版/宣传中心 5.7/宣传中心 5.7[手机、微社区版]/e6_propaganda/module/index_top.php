<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$new_arr = C::t('#e6_propaganda#e6_pro_user')->fetch_all_new_user();
$n = 1;
foreach ($new_arr as $k => $v) {
	if ($v['username']) {
		$v['n'] = $n; $n++;
		$new_list[] = $v;
	} else {
		del_pro_user($v['uid']);
	}
}
$money_arr = C::t('#e6_propaganda#e6_pro_user_count')->fetch_all_top_money();
$n = 1;
foreach ($money_arr as $k => $v) {
	if ($v['username']) {
		$v['n'] = $n; $n++;
		$allmoney_list[] = $v;
	} else {
		del_pro_user($v['uid']);
	}
}
$register_arr = C::t('#e6_propaganda#e6_pro_user_count')->fetch_all_top_register();
$n = 1;
foreach ($register_arr as $k => $v) {
	if ($v['username']) {
		$v['n'] = $n; $n++;
		$register_list[] = $v;
	} else {
		del_pro_user($v['uid']);
	}
}
 
?>