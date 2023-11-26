<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$prompt = $e6_propaganda['withdrawann'];
!$e6_propaganda['withdrawopen'] && Showmessage(pro_lang('withdraw_close'));
if ($e6_propaganda['withdrawgroup'] && !in_array($_G['groupid'], $e6_propaganda['withdrawgroup'])) {
	Showmessage(pro_lang('withdraw_no_group'));
}
$e6_user = C::t('common_member_count')->fetch($_G['uid']);
if (is_array($e6_propaganda['withdraw_profile'])) {
	$profile_title = C::t('common_member_profile_setting')->fetch_all($e6_propaganda['withdraw_profile']);
	$user_profile = C::t('common_member_profile')->fetch($_G['uid']);
}
if (file_exists("{$pro_module}withdraw_extra.php")) {
	if (!function_exists('withdraw_extra_index')) {
		require "{$pro_module}withdraw_extra.php";
	}
} else {
	if ($e6_propaganda['feetype'] == 2) $e6_propaganda['feetype'] = 1;
}
if ($e6_propaganda['feetype']) {
	if ($e6_propaganda['feetype'] == 1) {
		if ($e6_propaganda['fee_money']) {
			$fee_content = pro_lang('fee_content1', array('withdraw'=>$e6_propaganda['fee_money'].$money_list[$e6_propaganda['fee_type']]));
		}
	} elseif ($e6_propaganda['feetype'] == 2) {
		$fee_content = withdraw_extra_index(2);
	} elseif ($e6_propaganda['feetype'] == 3) {
		if ($e6_propaganda['pay_proportion']) {
			$fee_content = pro_lang('fee_content3', array('proportion'=>$e6_propaganda['pay_proportion']));
		}
	} elseif ($e6_propaganda['feetype'] == 4) {
		$fee_content = withdraw_extra_index(4);
	}
}
if (submitcheck('formhash')) {
	$money = intval($_GET['money']);
	!$money && Showmessage(pro_lang('withdraw_null'));
	$money > $e6_user['extcredits'.$e6_propaganda['withdraw_type']] && Showmessage(pro_lang('user_no_money'));
	if ($e6_propaganda['withdraw_money'] && $money < $e6_propaganda['withdraw_money']) {
		Showmessage(pro_lang('small_withdraw', array('money'=>$e6_propaganda['withdraw_money'].$money_list[$e6_propaganda['withdraw_type']])));
	}
	foreach ($e6_propaganda['withdraw_profile'] as $v) {
		if (!$user_profile[$v]) Showmessage(pro_lang('no_profile', array('profile'=>$profile_title[$v]['title'])));
	}
	if ($e6_propaganda['feetype']) {
		if ($e6_propaganda['feetype'] == 1) {
			if ($e6_propaganda['fee_money']) {
				if ($e6_propaganda['fee_type'] == $e6_propaganda['withdraw_type']) {
					if (($e6_propaganda['fee_money'] + $money) > $e6_user['extcredits'.$e6_propaganda['withdraw_type']]) {
						Showmessage(pro_lang('withdraw_fee_money', array(
							'money'=> ($e6_propaganda['fee_money']+$money). $money_list[$e6_propaganda['withdraw_type']]
						)));
					}
				} else {
					if ($e6_propaganda['fee_money'] > $e6_user['extcredits'.$e6_propaganda['fee_type']]) {
						Showmessage(pro_lang('user_no_fee', array('money'=>$e6_propaganda['fee_money'].$money_list[$e6_propaganda['fee_type']])));
					}
				}
				$fee_type = $e6_propaganda['fee_type'];
				$fee_money = $e6_propaganda['fee_money'];
			}
		} elseif ($e6_propaganda['feetype'] == 2) {
			list($fee_money, $fee_type) = withdraw_extra_submit(2);
		} elseif ($e6_propaganda['feetype'] == 3) {
			if ($e6_propaganda['pay_proportion']) {
				$fee_money = ceil($money * $e6_propaganda['pay_proportion'] / 100);
			}
			if (($fee_money + $money) > $e6_user['extcredits'.$e6_propaganda['withdraw_type']]) {
				Showmessage(pro_lang('withdraw_fee_money', array('money'=>($fee_money+$money).$money_list[$e6_propaganda['withdraw_type']])));
			}
			$fee_type = $e6_propaganda['withdraw_type'];
		} elseif ($e6_propaganda['feetype'] == 4) {
			list($fee_money, $fee_type) = withdraw_extra_submit(4);
		}
	}
	!$fee_money && $fee_money = 0;
	if ($fee_money) {
		$e6_user = pro_money(array($fee_type => -$fee_money), '7b', '', $_G['uid'], $e6_user);
	}
	pro_money(array($e6_propaganda['withdraw_type'] => -$money), '7a', '', $_G['uid'], $e6_user);
	C::t('#e6_propaganda#e6_pro_finance')->insert(array(
		'uid'		=>	$_G['uid'],
		'username'	=>	$_G['username'],
		'money'		=>	$money,
		'type'		=>	$e6_propaganda['withdraw_type'],
		'feemoney'	=>	$fee_money,
		'feetype'	=>	$fee_type,
		'date'		=>	$_G['timestamp']));
	Showmessage(pro_lang('success'), $nav_url);
}
$state_arr = array(pro_lang('not_audited'), pro_lang('audited'), pro_lang('refund'));
$page = $_GET['page'] ? intval($_GET['page']) : 1;
$perpage = 10;
$start = ($page - 1) * $perpage;
$conditions = " AND `uid`='{$_G['uid']}'";
$count = C::t('#e6_propaganda#e6_pro_finance')->count_by_search($conditions);
if($count) {
	$n = ($page - 1) * $perpage + 1;
	$withdraw_arr = C::t('#e6_propaganda#e6_pro_finance')->fetch_all_by_search($conditions, $start, $perpage);
	foreach ($withdraw_arr as $v) {
		$v['n']	= $n; $n++;
		$v['date'] = dgmdate($v['date']);
		$v['okdate'] = $v['okdate'] ? dgmdate($v['okdate']) : '-';
		$v['ok'] = $state_arr[$v['ok']];
		$v['money'] && $v['money'] .= $money_list[$v['type']];
		$v['feemoney'] = $v['feemoney'] ? $v['feemoney'].$money_list[$v['feetype']] : pro_lang('not');
 		$withdraw_list[] = $v;
	}
	$multi = multi($count, $perpage, $page, $nav_url);
	if (defined('IN_MOBILE') && $page>1) {
		$list_str = "";
		foreach ($withdraw_list as $v) {
			$list_str .= "<li class=\"e6_li\"><span>{$v['money']}</span><span>{$v['feemoney']}</span><span>{$v['ok']}</span></li>";
		}
		print $list_str;
		exit;
	}
}
 
?>