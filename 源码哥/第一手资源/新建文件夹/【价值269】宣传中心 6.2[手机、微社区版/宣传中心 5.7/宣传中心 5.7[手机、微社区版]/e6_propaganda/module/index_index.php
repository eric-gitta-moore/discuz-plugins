<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if ($e6_propaganda['group_id'] or $e6_propaganda['active_num']) {
	$group_list = C::t('common_usergroup')->fetch_all_by_type();
}
$dividend_n = $e6_propaganda['dividend'][$_G['groupid']];
$e6_user = C::t("#e6_propaganda#e6_pro_user")->fetch($_G['uid']);
if (!$e6_user['id']) {
	add_prouser($_G['uid']);
	$e6_user_count['money'] = $e6_user_count['register'] = $e6_user_count['ip'] = $e6_user_count['task'] = 0;
}
if(!$e6_propaganda['group'] or in_array($_G['groupid'], $e6_propaganda['group'])) {
	if ($e6_user['fuid1']) {
		$fuser1 = C::t('common_member')->fetch($e6_user['fuid1']);
		if ($fuser1['username']) {
			$prompt = pro_lang('prompt_user', array('user' => $fuser1['username']));
		} else {
			del_pro_user($e6_user['fuid1']);
		}
	}
} else {
	$prompt = pro_lang('no_group');
}
$e6_user['id'] && $e6_user_count = C::t('#e6_propaganda#e6_pro_user_count')->fetch($_G['uid']);
if($e6_propaganda['urltype'] == 0) {
	$spread_url = $e6_propaganda['url_url'] ? $e6_propaganda['url_url'] : $_G['siteurl'].'forum.php';
	if(strpos($spread_url, '?') === false) {
		$spread_url .= "?x={$_G['uid']}";
	} else {
		$spread_url .= "&x={$_G['uid']}";
	}
} else {
	$spread_url = rand_digest();
}
$prompt_1 = pro_lang('prompt_1');
$prompt_2 = pro_lang('prompt_2');
if ($e6_propaganda['ip']) {
	$prompt_2_list[] = pro_lang('prompt_2_1', array('hour' => $e6_propaganda['ip']));
}
if ($e6_propaganda['interval']) {
	$prompt_2_list[] = pro_lang('prompt_2_2', array('second' => $e6_propaganda['interval']));
}
if (array_sum($e6_propaganda['max_visit'])) {
	$max_visit = reward_text($e6_propaganda['max_visit']);
	$prompt_2_list[] = pro_lang('prompt_2_3', array('money' => $max_visit));
}
if (array_sum($e6_propaganda['max_register'])) {
	$max_register = reward_text($e6_propaganda['max_register']);
	$prompt_2_list[] = pro_lang('prompt_2_4', array('money' => $max_register));
}
//if (!$prompt_2_list) $prompt_2 = '';
$prompt_3 = pro_lang('prompt_3');
$prompt_4 = pro_lang('prompt_4');
if (array_sum($e6_propaganda['visit_money'])) {
	$visit_money = reward_text($e6_propaganda['visit_money']);
	$prompt_4_list[] = array(
		'name'		=>	pro_lang('prompt_4_1_name'),
		'comment'	=>	pro_lang('prompt_4_1_comment'),
		'reward'	=>	pro_lang('prompt_4_1_reward', array('money' => $visit_money))
	);
}
if (file_exists("{$pro_module}area_extra.php")) {
	if (!function_exists('area_extra_index')) {
		require "{$pro_module}area_extra.php";
	}
	$prompt_4_list = area_extra_index();
}
if ($e6_propaganda['registertype'] == 1) {
	if (array_sum($e6_propaganda['register_money'])) {
		$register_money = reward_text($e6_propaganda['register_money']);
		$prompt_4_list[] = array(
			'name'		=>	pro_lang('prompt_4_2_name'),
			'comment'	=>	pro_lang('prompt_4_2_comment'),
			'reward'	=>	pro_lang('prompt_4_2_reward1', array('money' => $register_money))
		);
	}
} elseif ($e6_propaganda['registertype'] == 2) {
	if ($dividend_n) {
		for ($n=1; $n<=$dividend_n; $n++) {
			$dividend_money = $e6_propaganda['multi_reg'][$n]['money'];
			$dividend_type = $money_list[$e6_propaganda['multi_reg'][$n]['type']];
			if ($dividend_money) {
				$dividend[] = pro_lang('prompt_4_2_text', array('n' => $n, 'money' => $dividend_money.$dividend_type));
			}
		}
		$register_money .= implode(', ', $dividend);
		$prompt_4_list[] = array(
			'name'		=>	pro_lang('prompt_4_2_name'),
			'comment'	=>	pro_lang('prompt_4_2_comment'),
			'reward'	=>	pro_lang('prompt_4_2_reward2', array('money' => $register_money))
		);
	}
}
if ($e6_propaganda['area'] && array_sum($e6_propaganda['region_money'])) {
	$region_money = reward_text($e6_propaganda['region_money']);
	$prompt_4_list[] = array(
		'name'		=>	pro_lang('prompt_4_3_name'),
		'comment'	=>	pro_lang('prompt_4_3_comment').$e6_propaganda['area'],
		'reward'	=>	pro_lang('prompt_4_3_reward', array('money' => $region_money))
	);
}
if($e6_propaganda['group_id']) {
	if ($dividend_n) {
		if (file_exists("{$pro_module}vip_extra.php")) {
			if (!function_exists('vip_extra_index')) {
				require "{$pro_module}vip_extra.php";
			}
			$prompt_4_list = vip_extra_index();
		} else {
			$e6_groupid = current($e6_propaganda['group_id']);
			$reward_arr = array();
			for($n=1; $n<=$dividend_n; $n++) {
				$e6_money = $e6_propaganda['multi_vip'][$e6_groupid][$n]['money'];
				$e6_type = $money_list[$e6_propaganda['multi_vip'][$e6_groupid][$n]['type']];
				if ($e6_money) {
					$reward_arr[] = pro_lang('prompt_4_4_reward1', array('n'=>$n, 'money'=>$e6_money.$e6_type));
				}
			}
			$e6_reward = implode(', ', $reward_arr);
			$prompt_4_list[] = array(
				'name'		=>	pro_lang('prompt_4_4_name', array('n'=>$n)),
				'comment'	=>	pro_lang('prompt_4_4_comment', array('grouptitle'=>$group_list[$e6_groupid]['grouptitle'])),
				'reward'	=>	pro_lang('prompt_4_4_reward', array('money'=>$e6_reward))
			);
		}	
	}
}
if ($dividend_n) {
	$reward_arr = array();
	if ($e6_propaganda['paytype'] == 1) {
		for ($n=1; $n<=$dividend_n; $n++) {
			$e6_money = $e6_propaganda['multi_pay'][$n]['money'];
			$e6_type = $money_list[$e6_propaganda['multi_pay'][$n]['type']];
			if ($e6_money) {
				$dividend_money = reward_text($e6_propaganda['active_money'][$n]);
				$reward_arr[] = pro_lang('prompt_4_5_reward1', array('n'=>$n, 'money'=>$e6_money.$e6_type));
			}
		}
		$e6_reward = implode(', ', $reward_arr);
		$prompt_4_list[] = array(
			'name'		=>	pro_lang('prompt_4_5_name'),
			'comment'	=>	pro_lang('prompt_4_5_comment1'),
			'reward'	=>	pro_lang('prompt_4_5_reward', array('money'=>$e6_reward))
		);
	} elseif ($e6_propaganda['paytype'] == 2) {
		for ($n=1; $n<=$dividend_n; $n++) {
			if ($e6_propaganda['multi_pay'][$n]['percentage']) {
				$e6_money = $e6_propaganda['pay_money2'] * $e6_propaganda['multi_pay'][$n]['percentage'] / 100;
				$e6_type = $money_list[$e6_propaganda['pay_type2']];
				$reward_arr[] = pro_lang('prompt_4_5_reward1', array('n'=>$n, 'money'=>$e6_money.$e6_type));
			}
		}
		$e6_reward = implode(', ', $reward_arr);
		$prompt_4_list[] = array(
			'name'		=>	pro_lang('prompt_4_5_name'),
			'comment'	=>	pro_lang('prompt_4_5_comment2'),
			'reward'	=>	pro_lang('prompt_4_5_reward', array('money'=>$e6_reward))
		);
	}
}
if ($e6_propaganda['active_num']) {
	for ($n=1; $n<=$e6_propaganda['active_num']; $n++) {
		$e6_online	= $e6_propaganda['active_condition'][$n]['online'];
		$e6_posts	= $e6_propaganda['active_condition'][$n]['posts'];
		$e6_groupid = $e6_propaganda['active_condition'][$n]['groupid'];
		$comment_arr = array();
		if ($e6_online or $e6_posts or $e6_groupid) {
			if ($e6_online) $comment_arr[] = pro_lang('prompt_4_6_comment1', array('hour'=>$e6_online));
			if ($e6_posts) $comment_arr[] = pro_lang('prompt_4_6_comment2', array('post'=>$e6_posts));
			if ($e6_groupid) {
				$comment_arr[] = pro_lang('prompt_4_6_comment3', array('group'=>$group_list[$e6_groupid]['grouptitle']));
			}
			$comment_str = implode(', ', $comment_arr);
			$e6_comment = pro_lang('prompt_4_6_comment', array('str'=>$comment_str));
			$active_money = reward_text($e6_propaganda['active_money'][$n]);
			$prompt_4_list[] = array(
				'name'		=>	pro_lang('prompt_4_6_name', array('n'=>$n)),
				'comment'	=>	$e6_comment,
				'reward'	=>	pro_lang('prompt_4_6_reward', array('money'=>$active_money))
			);
		}
	}
}

?>