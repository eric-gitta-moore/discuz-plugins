<?php
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if ($_GET['type'] == 'apply') {
	if ($taskid = intval($_GET['taskid'])) {
		$task = C::t('#e6_propaganda#e6_pro_task')->fetch($taskid);
		if($task['endtime'] && $task['endtime']<$_G['timestamp']) {
			Showmessage(pro_lang('task_no_date'), $nav_url);
		}
		$my_task = C::t('#e6_propaganda#e6_pro_task_list')->fetch_by_search("AND `uid`='{$_G['uid']}' AND `taskid`='{$taskid}'");
		if ($my_task['ok']) Showmessage(pro_lang('task_no_ok'), $nav_url);
		if ($my_task) Showmessage(pro_lang('task_no_apply'), $nav_url);
		if (task_group($_G['groupid'], $task['grouplimit'])) {
			$v = task_value($task['claim'], $task['claim1']);
			C::t('#e6_propaganda#e6_pro_task_list')->insert(array(
				'uid'	=>	$_G['uid'],
				'taskid'=>	$taskid,
				'value'	=>	$v));
			C::t('#e6_propaganda#e6_pro_task')->update_by_count($taskid, '`participate`=`participate`+1');
			Showmessage(pro_lang('success'), $nav_url.'&taskid='.$taskid);
		} else {
			Showmessage(pro_lang('task_no_group'), $nav_url);
		}
	}
	dexit();
} elseif ($_GET['type'] == 'cancel') {
	if ($taskid = intval($_GET['taskid'])) {
		C::t('#e6_propaganda#e6_pro_task_list')->delete_by_user($taskid, $_G['uid']);
		C::t('#e6_propaganda#e6_pro_task')->update_by_count($taskid, '`participate`=`participate`-1');
		Showmessage(pro_lang('success'), $nav_url);
	}
	dexit();
} elseif ($_GET['type'] == 'reward') {
	if ($taskid = intval($_GET['taskid'])) {
		$my_task = C::t('#e6_propaganda#e6_pro_task_list')->fetch_by_search("AND `uid`='{$_G['uid']}' AND `taskid`='{$taskid}'");
		$task = C::t('#e6_propaganda#e6_pro_task')->fetch($taskid);
		if ($my_task['ok']) {
			Showmessage(pro_lang('task_ok_error'), $nav_url);
		}
		if ($task['endtime'] && $task['endtime']<$_G['timestamp']) {
			Showmessage(pro_lang('task_ok_overtime'), $nav_url);
		}
		if (task_ok($my_task, $task['claim'], $task['claim1'], $task['claim2'])) {
			task_send_reward($taskid, $_G['uid']);
			C::t('#e6_propaganda#e6_pro_task')->update_by_count($taskid, '`complete`=`complete`+1');
			Showmessage(pro_lang('task_ok_reward'), $nav_url);
		}
	}
	dexit();
}
$task = $_GET['task'] ? $_GET['task'] : 'all';
$_GET['taskid'] && $task = '';
${'style_'.$task} = 'style="background: #FF6600;"';
$prompt  = '<a '.$style_all.' href="'.$nav_url.'&task=all" class="task_botton">'.pro_lang('task_all').'</a>';
$prompt .= '<a '.$style_yes.' href="'.$nav_url.'&task=yes" class="task_botton">'.pro_lang('task_yes').'</a>';
$prompt .= '<a '.$style_no.'  href="'.$nav_url.'&task=no"  class="task_botton">'.pro_lang('task_no').'</a>';
if ($taskid = intval($_GET['taskid'])) {
	$task = C::t('#e6_propaganda#e6_pro_task')->fetch($taskid);
	!$task['icon'] && $task['icon'] = 'task.png';
	$task['starttime'] = $task['starttime'] ? dgmdate($task['starttime']) : pro_lang('all_date');
	$task['overtime'] = $task['endtime'] ? dgmdate($task['endtime']) : pro_lang('all_date');
	$task['claim_text'] = task_claim_text($task['claim'], $task['claim1'], $task['claim2']);
	$task['reward_text'] = task_reward_text($task['reward'], $task['reward1'], $task['reward2']);
	if ($task['grouplimit']) {
		$group_list = C::t('common_usergroup')->fetch_all_by_type();
		$group_arr = unserialize($task['grouplimit']);
		foreach($group_arr as $v) {
			$group_title[] = $group_list[$v]['grouptitle'];
		}
		$group_limit = implode(', ', $group_title);
	} else {
		$group_limit = pro_lang('all_group');
	}
	if ($task['endtime'] && $task['endtime']<$_G['timestamp']) {
		$taskimg = task_img($task['id'], 'over');
	} else {
		if (task_group($_G['groupid'], $task['grouplimit'])) {
			$my_task = C::t('#e6_propaganda#e6_pro_task_list')->fetch_by_search("AND `uid`='{$_G['uid']}' AND `taskid`='{$taskid}'");
			if ($my_task['taskid']) {
				if($my_task['ok']) {
					$taskimg = task_img($task['id'], 'ok');
					$task_ok = pro_lang('task_user_ok');
				} else {
					if (task_ok($my_task, $task['claim'], $task['claim1'], $task['claim2'])) {
						$taskimg = task_img($task['id'], 'reward');
						$task_ok = pro_lang('task_user_ok');
					} else {
						$taskimg = task_img($task['id'], 'cancel');
						$user_value = task_value($task['claim'], $task['claim1']);
						$v = $user_value - $my_task['value'];
						$task_ok_arr = array(
							0	=>	pro_lang('task_user_ip', array('ip'=>$v)),
							1 	=>	pro_lang('task_user_register', array('num'=>$v)),
							2	=>	pro_lang('task_user_area', array('num'=>$v)),
							3	=>	pro_lang('task_user_pay', array('num'=>$v)),
							4	=>	pro_lang('task_user_active', array('num'=>$v)),
							5	=>	pro_lang('task_user_vip', array('num'=>$v)));
						$task_ok = $task_ok_arr[$task['claim']];
					}
				}
			} else {
				$taskimg = task_img($task['id'], 'apply');
			}
		} else {
			$taskimg = task_img($task['id'], 'disallow');
		}
	}
} else {
	$mobile_title_arr = array(
		'all'	=>	pro_lang('task_all'),
		'yes'	=>	pro_lang('task_yes'),
		'no'	=>	pro_lang('task_no')
	);
	${'task_'.$task} = 'class="ui-btn-active ui-state-persist"';
	$user_list = C::t('#e6_propaganda#e6_pro_task_list')->fetch_all_by_user($_G['uid']);
	if ($user_list) {
		$user_taskid = implode(',',array_keys($user_list));
	} else {
		$user_taskid = 0;
	}
	$where_arr = array(
		'all'	=>	'',
		'yes'	=>	" AND id IN ({$user_taskid}) ",
		'no'	=>	" AND (`endtime`='0' OR `endtime`>'{$_G['timestamp']}') AND id NOT IN ({$user_taskid}) "
	);
	$task_arr = C::t('#e6_propaganda#e6_pro_task')->fetch_all_by_search($where_arr[$task]);
	foreach ($task_arr as $v) {
		!$v['icon'] && $v['icon'] = 'task.png';
		$v['claim_text'] = task_claim_text($v['claim'], $v['claim1'], $v['claim2']);
		$v['reward_text'] = task_reward_text($v['reward'], $v['reward1'], $v['reward2']);
		if ($v['endtime'] == 0 || $v['endtime'] > $_G['timestamp']) {
			$v['Y'] = task_group($_G['groupid'], $v['grouplimit']);
			if ($v['Y']) {
				if ($user_list && $user_list[$v['id']]) {
					if($user_list[$v['id']]['ok']) {
						$v['taskimg'] = task_img($v['id'], 'ok');
					} else {
						if (task_ok($user_list[$v['id']], $v['claim'], $v['claim1'], $v['claim2'])) {
							$v['taskimg'] = task_img($v['id'], 'reward');
						} else {
							$v['taskimg'] = task_img($v['id'], 'cancel');
						}
					}
				} else {
					$v['taskimg'] = task_img($v['id'], 'apply');
				}
			} else {
				$v['taskimg'] = task_img($v['id'], 'disallow');
			}
		} else {
			$v['taskimg'] = task_img($v['id'], 'over');
		}
		$v['starttime'] = $v['starttime'] ? dgmdate($v['starttime']) : pro_lang('all_date');
		$v['endtime'] = $v['endtime'] ? dgmdate($v['endtime']) : pro_lang('all_date');
		$task_list[] = $v;
	}
}
 
?>