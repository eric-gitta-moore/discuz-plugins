<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
$GLOBALS['e6_lang'] = $e6_lang = $scriptlang['e6_propaganda'];
$GLOBALS['pro_module'] = $pro_module = DISCUZ_ROOT . 'source/plugin/e6_propaganda/module/';
foreach ($_G['setting']['extcredits'] as $k => $v) {
	$GLOBALS['money_list'][$k] = $money_list[$k] = $v['title'];
}
function e6_propaganda() {}
function pro_lang($str, $arr = array()){
	return lang('plugin/e6_propaganda', $str, $arr);
}
function pro_nav() {
	return array(
		'index'		=> pro_lang('index_nav'),
		'task'		=> pro_lang('task_nav'),
		'son' 		=> pro_lang('son_nav'),
		'multi' 	=> pro_lang('multi_nav'),
		'withdraw' 	=> pro_lang('withdraw_nav'),
		'log' 		=> pro_lang('log_nav'),
		'top' 		=> pro_lang('top_nav')
	);
}
function ip_area($ip = NULL) {
	global $_G;
	!$ip && $ip = $_G['clientip'];
	$url = "http://www.baidu.com/s?wd=" . $ip;
	$ext = stream_context_create(array('http' => array('timeout' => 3)));
	$file_region = @file_get_contents($url, false, $ext);
	if($file_region){
		if ($_G['charset'] == 'gbk') {
			$file_region = iconv("UTF-8", "GB2312//IGNORE", $file_region);
		}
		preg_match("/<span class=\"c-gap-right\">".lang('plugin/e6_propaganda', 'ip_address').":&nbsp;{$ip}<\/span>(.*)(.+\s*)<\/td>/i", $file_region, $str);
	}
	return $str[1];
}
function rand_digest() {
	$count = C::t('forum_thread')->count_search(array('digest' => '1'));
	if ($count > 0) {
		$start = rand(0, $count-1);
		$arr = current(C::t('forum_thread')->fetch_all_by_digest_displayorder('', '>', null, null, $start, 1));
		if ($arr['tid']) {
			return pro_rewrite($arr['tid']);
		}
		return FALSE;
	}
	return FALSE;
}
function pro_rewrite($tid) {
	global $_G;
	if ($_G['setting']['rewritestatus'] && in_array('forum_viewthread', $_G['setting']['rewritestatus'])) {
		$url = rewriteoutput('forum_viewthread', 1, $_G['siteurl'], $tid);
		$url .= '?x=' . $_G['uid'];
	} else {
		$url = $_G['siteurl'] . 'forum.php?mod=viewthread&tid=' . $tid;
		$url .= '&x=' . $_G['uid'];
	}
	return $url;
}
function admin_show_tbody($id, $i, $no=null, $extra_no=array()) {
	global $e6_lang;
	$arr = $son_arr = array();
	!is_array($no) && $no = (array)$no;
	for ($n=0; $n<=$i; $n++) {
		if (!in_array($n, $extra_no)) {
			for ($m=0; $m<=$i; $m++) {
				if (in_array($m, $no)) continue;
				$son_arr[$n][$id.'_'.$m] = $m == $n ? '' : 'none';
			}
			$arr[$n] = array($n, $e6_lang[$id.'_'.$n], $son_arr[$n]);
		}
	}
	return $arr;
}
function task_reward() {
	global $e6_lang;
	return array(
		$e6_lang['money'],
		$e6_lang['magics'],
		$e6_lang['medals'],
		$e6_lang['usergroups']
	);
}
function task_type() {
	global $e6_lang;
	return array(
		$e6_lang['task_ip'],
		$e6_lang['task_reg'],
		$e6_lang['task_area'],
		$e6_lang['task_pay'],
		$e6_lang['task_active'],
		$e6_lang['task_vip']
	);
}
function pro_log_type() {
	global $pro_module;
	$arr = array(
		'1' => pro_lang('log_visit'),
		'2' => pro_lang('log_register'),
		'3' => pro_lang('log_area'),
		'4' => pro_lang('log_active'),
		'5' => pro_lang('log_vip'),
		'6' => pro_lang('log_pay'),
		'7' => pro_lang('log_withdraw'),
		'8'	=> pro_lang('log_task'),
		'9' => pro_lang('log_cheatlog'),
		
		
	);
	if (file_exists("{$pro_module}area_extra.php")) {
		$arr[50] = pro_lang('log_visit_area');
	}
	return $arr;
}
function pay_type() {
	global $e6_lang;
	return array(
		'0'	=>	$e6_lang['pay_online'],
		'1'	=>	$e6_lang['pay_card'],
		'2'	=>	$e6_lang['pay_expansion']
	);
}
function del_pro_user($uids) {
	foreach (C::t('#e6_propaganda#e6_pro_user')->fetch_all($uids) as $v) {
		if ($v['fuid1']) C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($v['fuid1'], '`register`=`register`-1');
	}
	C::t('#e6_propaganda#e6_pro_user')->delete($uids);
	C::t('#e6_propaganda#e6_pro_user_count')->delete($uids);
	C::t('#e6_propaganda#e6_pro_finance')->delete_by_uid($uids);
	C::t('#e6_propaganda#e6_pro_clientorder')->delete_by_uid($uids);
	C::t('#e6_propaganda#e6_pro_credit')->delete_by_uid($uids);
	for ($n=1; $n<=10; $n++) {
		$data = array('fuid'.$n => '');
		C::t('#e6_propaganda#e6_pro_user')->update_by_fuid($uids, $n, $data);
	}
}
function add_prouser($uid) {
	if(!$uid) return FALSE;
	$data = array('uid' => $uid);
	C::t('#e6_propaganda#e6_pro_user')->insert($data);
	C::t('#e6_propaganda#e6_pro_user_count')->insert($data);
}
function reward_text($money_arr) {
	global $money_list;
	foreach (array_filter($money_arr) as $k => $v) {
		$arr[] = "<em class=\"e6_red\">$v</em> {$money_list[$k]}";
	}
	return implode(', ', $arr);
}
function pro_money($money_arr = array(), $log_type, $lang_arr = array(), $uid, $e6_user = array()) {
	global $_G;
	if($money_arr) $money_arr = array_filter($money_arr);
	if ($money_arr) {
		foreach ($money_arr as $k => $v) {
			$e6_money['extcredits'.$k] = $v;
		}
		if (!$e6_user) $e6_user = C::t('common_member_count')->fetch($uid);
		updatemembercount($uid, $e6_money);
	}
	foreach ($money_arr as $k => $v) {
		$money_lang = array('money' => $v.$_G['setting']['extcredits'][$k]['title']);
		$lang_arrs = $lang_arr ? array_merge($money_lang, $lang_arr) : $money_lang;//lang_arrs
		C::t('#e6_propaganda#e6_pro_credit')->insert(array(
			'uid'		=>	$uid,
			'type'		=>	$k,
			'logtype'	=>	(float)$log_type,
			'smoney'	=>	$e6_user['extcredits'.$k],
			'emoney'	=>	$e6_user['extcredits'.$k] + $v,
			'change'	=>	$v,
			'date'		=>	$_G['timestamp'],
			'ip'		=>	$_G['clientip'],
			'describe'	=>	pro_lang('log_'.$log_type, $lang_arrs)	//lang_arrs
		));
		$e6_user['extcredits'.$k] = $e6_user['extcredits'.$k] + $v;
	}
	return $e6_user;
}
function get_multi_sql($uid, $num = 1){
	for($n = 1; $n <= $num; $n++) {
		$sql .= "`fuid{$n}` = '{$uid}' ";
		$n < $num && $sql .= ' or ';
	}
	!$sql && $sql = '1=2';
	return $sql;
}
function task_claim_text($claim, $claim1 = NULL, $claim2 = NULL) {
	global $e6_propaganda;
	if ($claim == 5) $group_list = C::t('common_usergroup')->fetch_all_by_type();
	$task_arr = array(
		0	=>	pro_lang('task_claim_0', array('num'=>$claim1)),
		1 	=>	pro_lang('task_claim_1', array('num'=>$claim1)),
		2	=>	pro_lang('task_claim_2', array('area'=>$e6_propaganda['area'], 'num'=>$claim1)),
		3	=>	pro_lang('task_claim_3', array('num'=>$claim1)),
		4	=>	pro_lang('task_claim_4', array('n'=>$claim1, 'num'=>$claim2)),
		5	=>	pro_lang('task_claim_5', array('grouptitle'=>$group_list[$claim1]['grouptitle'], 'num'=>$claim2)),
	);
	return $task_arr[$claim];
}
function task_reward_text($reward, $reward1 = NULL, $reward2 = NULL) {
	global $_G;
	switch($reward) {
		case 1 : $magic_list = C::t('common_magic')->fetch_all_name_by_available(); break;
		case 2 : $medal_list = C::t('forum_medal')->fetch_all_name_by_available(); break;
		case 3 : $group_list = C::t('common_usergroup')->fetch_all_by_type(); break;
	}
	$reward_arr =  array(
		0	=>	pro_lang('task_reward_0', array('money'=>$reward1.$_G['setting']['extcredits'][$reward2]['title'])),
		1 	=>	pro_lang('task_reward_1', array('num'=>$reward1, 'title'=>$magic_list[$reward2]['name'])),
		2	=>	pro_lang('task_reward_2', array('title'=>$medal_list[$reward1]['name'])),
		3	=>	pro_lang('task_reward_3', array('grouptitle'=>$group_list[$reward1]['grouptitle'], 'date'=>($reward2 ? $reward2 . pro_lang('date') : pro_lang('lasting'))))
	);
	return $reward_arr[$reward];
}
function task_group($groupid, $grouplimit = NULL) {
	if(!$grouplimit) return TRUE;
	if(in_array($groupid, unserialize($grouplimit))) return TRUE;
	return FALSE;
}
function task_img($taskid, $type) {
	if(defined('IN_MOBILE')) {
		if ($type == 'apply' or $type == 'cancel' or $type == 'reward') {
			return "<a data-role=\"button\" data-ajax=\"false\" href=\"plugin.php?id=e6_propaganda&nav=task&type={$type}&taskid={$taskid}\">".pro_lang('task_button_'.$type)."</a>";
		}
		return '<a data-role="button" data-ajax="false" href="javascript:void(0);" >'.pro_lang('task_button_'.$type).'</a>';
	} else {
		if ($type == 'apply' or $type == 'cancel' or $type == 'reward') {
			return "<a href=\"plugin.php?id=e6_propaganda&nav=task&type={$type}&taskid={$taskid}\"><img src=\"source/plugin/e6_propaganda/image/{$type}.gif\"></a>";
		}
		return "<img src=\"source/plugin/e6_propaganda/image/{$type}.gif\">";
	}
}
function task_value($claim, $claim1 = NULL) {
	global $_G;
	$e6_user = C::t('#e6_propaganda#e6_pro_user_count')->fetch($_G['uid']);
	switch($claim) {
		case 0 : $v = $e6_user['ip']; break;
		case 1 : $v = $e6_user['register']; break;
		case 2 : $v = $e6_user['area']; break;
		case 3 : $v = $e6_user['paymoney']; break;
		case 4 :
			$arr = unserialize($e6_user['active']);
			$v = $arr[$claim1];
			break;
		case 5 :
			$arr = unserialize($e6_user['upvip']);
			$v = $arr[$claim1];
			break;
	}
	!$v && $v = 0;
	return $v;
}
function task_ok($task_user, $claim, $claim1 = NULL, $claim2 = NULL) {
	$task_all = task_value($claim, $claim1);
	if ($claim > 3) {
		$v = $claim2;
	} else {
		$v = $claim1;
	}
	if (($task_all - $task_user['value']) >= $v) {
		return TRUE;
	}
	return FALSE;
}
function task_send_magic($uid, $magicid, $num = 1) {
	$Y = C::t('common_member_magic')->fetch($uid, $magicid);
	if ($Y) {
		C::t('common_member_magic')->increase($uid, $magicid, array('num' => $num));
	} else {
		C::t('common_member_magic')->insert(array(
			'uid' => $uid,
			'magicid' => $magicid,
			'num' => $num));
	}
	require_once libfile('function/magic');
	updatemagiclog($magicid, '3', $num, '', $uid);
}
function task_send_medal($uid, $medalid) {
	global $_G;
	$user = C::t('common_member_field_forum')->fetch($uid);
	if ($user['medals']) {
		$my_medal_arr = explode("\t", $user['medals']);
		if(!in_array($medalid, $my_medal_arr)){
			$new_medal = $medalid . "\t" . $user['medals'];
		}
	} else {
		$new_medal = $medalid;
	}
	if ($new_medal) {
		C::t('common_member_field_forum')->update($uid, array('medals' => $new_medal), true);
		$data = array(
			'uid' 		=> $uid,
			'medalid' 	=> $medalid,
			'type' 		=> 0,
			'dateline'	=> $_G['timestamp'],
			'expiration'=> 0,
			'status'	=> 0
		);
		C::t('forum_medallog')->insert($data);
		if ($_G['setting']['version'] != 'X2') {
			C::t('common_member_medal')->insert(array('uid' => $uid, 'medalid' => $medalid), 0, 1);
		}
	}
}
function task_send_group($uid, $groupid, $date = NULL) {
	global $_G;
	$user = C::t('common_member')->fetch($uid);
	$user_field = C::t('common_member_field_forum')->fetch($uid);
	if ($user['extgroupids']) {
		$group_arr = explode("\t", $user['extgroupids']);
		if (!in_array($groupid, $group_arr)){
			$group_arr[] = $groupid;
			$no_old = 1;
		}
	} else {
		$group_arr[] = $groupid;
		$no_old = 1;
	}
	if ($user_field) $groupterms = dunserialize($user_field['groupterms']);
	if ($date) {
		if ($groupterms['ext'][$groupid] && $groupterms['ext'][$groupid] > $_G['timestamp']) {
			$expiry = $groupterms['ext'][$groupid] + ($date * 86400);
		}
		if ($no_old or $groupterms['ext'][$groupid]) {
			!$expiry && $expiry = ($_G['timestamp']+($date*86400));
			$groupterms['ext'][$groupid] = $expiry;
		}
	} else {
		unset($groupterms['ext'][$groupid]);
	}
	if (!function_exists('groupexpiry')) {
		require_once libfile('function/forum');
	}
	$grouptermsnew = serialize($groupterms);
	$groupexpirynew = groupexpiry($groupterms);
	$extgroupidsnew = implode("\t", $group_arr);
	C::t('common_member')->update($uid, array('extgroupids'=>$extgroupidsnew, 'groupexpiry'=>$groupexpirynew));
	if($user_field) {
		C::t('common_member_field_forum')->update($uid, array('groupterms'=>$grouptermsnew));
	} else {
		C::t('common_member_field_forum')->insert(array('uid'=>$uid, 'groupterms'=>$grouptermsnew));
	}
}
function task_send_reward($taskid, $uid, $task = NULL) {
	global $_G;
	!$task && $task = C::t('#e6_propaganda#e6_pro_task')->fetch($taskid);
	switch($task['reward']) {
		case 0 :
			pro_money(array($task['reward2'] => $task['reward1']), '8',
			array('task' => $task['name'], 'money' => $task['reward1'].$_G['setting']['extcredits'][$task['reward2']]['title']),
			$uid);
			$message = pro_lang('log_8', array('task'=>$task['name'], 'money' => $task['reward1'].$_G['setting']['extcredits'][$task['reward2']]['title']));
			C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($uid, "`money`=`money`+'{$task['reward1']}'");
			break;
		case 1 :
			task_send_magic($uid, $task['reward2'], $task['reward1']);
			$magic = C::t('common_magic')->fetch($task['reward2']);
			$magic_title = pro_lang('task_magic_reward', array('num'=>$task['reward1'], 'magic'=>$magic['name']));
			$message = pro_lang('log_8', array('task'=>$task['name'], 'money'=>$magic_title));
			C::t('#e6_propaganda#e6_pro_credit')->insert(array(
				'uid'		=>	$uid,
				'logtype'	=>	8,
				'date'		=>	$_G['timestamp'],
				'ip'		=>	$_G['clientip'],
				'describe'	=>	$message));
			break;
		case 2 :
			task_send_medal($uid, $task['reward1']);
			$medal = C::t('forum_medal')->fetch($task['reward1']);
			$medal_title = pro_lang('task_medal_reward', array('medal'=>$medal['title']));
			$message = pro_lang('log_8', array('task'=>$task['name'], 'money'=>$medal_title));
			C::t('#e6_propaganda#e6_pro_credit')->insert(array(
				'uid'		=>	$uid,
				'logtype'	=>	8,
				'date'		=>	$_G['timestamp'],
				'ip'		=>	$_G['clientip'],
				'describe'	=>	$message));
			break;
		case 3 :
			task_send_group($uid, $task['reward1'], $task['reward2']);
			$group = C::t('common_usergroup')->fetch($task['reward1']);
			$group_title = pro_lang('task_group_reward', array('grouptitle'=>$group['grouptitle'], 'date'=>($task['reward2'] ? $task['reward2'] . pro_lang('date') : pro_lang('lasting'))));
			$message = pro_lang('log_8', array('task'=>$task['name'], 'money'=>$group_title));
			C::t('#e6_propaganda#e6_pro_credit')->insert(array(
				'uid'		=>	$uid,
				'logtype'	=>	8,
				'date'		=>	$_G['timestamp'],
				'ip'		=>	$_G['clientip'],
				'describe'	=>	$message));
			break;
		default: return FALSE;
	}
	C::t('#e6_propaganda#e6_pro_task_list')->update_by_ok($taskid, $uid);
	C::t('#e6_propaganda#e6_pro_user_count')->update_by_count($uid, "`task`=`task`+1");
	notification_add($uid, 'system', 'system_notice', array(
		'subject' => pro_lang('task_msg_title'),
		'message' => $message,
		'from_id' => 0,
		'from_idtype' => 'e6_pro'
	),1);
}

?>