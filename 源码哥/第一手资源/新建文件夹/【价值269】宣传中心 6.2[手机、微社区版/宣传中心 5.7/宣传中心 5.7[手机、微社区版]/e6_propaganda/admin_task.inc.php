<?php

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
if ($_GET['tasknav'] != 'del' && !submitcheck('e6_submit')) {
	$html = '<a href="'.ADMINSCRIPT.'?action=plugins&identifier=e6_propaganda&pmod=admin_task&tasknav=add" style="color:red">'.$e6_lang['task_add'].'</a> | '.
			'<a href="'.ADMINSCRIPT.'?action=plugins&identifier=e6_propaganda&pmod=admin_task">'.$e6_lang['task_all'].'</a> | '.
			'<a href="'.ADMINSCRIPT.'?action=plugins&identifier=e6_propaganda&pmod=admin_task&tasknav=current">'.$e6_lang['task_current'].'</a> | '.
			'<a href="'.ADMINSCRIPT.'?action=plugins&identifier=e6_propaganda&pmod=admin_task&tasknav=over">'.$e6_lang['task_over'].'</a>';
	showtableheader($html);
}
if ($_GET['tasknav'] == 'del' && $_GET['formhash'] == formhash()) {
	C::t('#e6_propaganda#e6_pro_task')->delete($_GET['taskid']);
	C::t('#e6_propaganda#e6_pro_task_list')->delete($_GET['taskid']);
	cpmsg($e6_lang['success'], cpurl(false, array('tasknav')), 'succeed');
} elseif($_GET['tasknav'] == 'add' or $_GET['tasknav'] == 'edit') {
	if (submitcheck('e6_submit')) {
		$task = daddslashes($_GET['task']);
		if (empty($task['name'])) $msg = $e6_lang['task_msg_noname'];
		if(!$task['claim_'.$task['claim'].'_1'] or ($task['claim'] > 3 && !$task['claim_'.$task['claim'].'_2'])){
			cpmsg($e6_lang['task_msg_noclaim'], cpurl(false, array('tasknav')), 'succeed');
		}
		if(!$task['reward_'.$task['reward'].'_1'] or ($task['reward'] != 2 && $task['reward'] != 3 && !$task['reward_'.$task['reward'].'_2'])){
			cpmsg($e6_lang['task_msg_noreward'], cpurl(false, array('tasknav')), 'succeed');
		}
		$data = array(
				'name'		=>	$task['name'],
				'icon'		=>	$task['icon'],
				'starttime'	=> 	strtotime($task['starttime']),
				'endtime'	=> 	strtotime($task['endtime']),
				'claim'		=>	$task['claim'],
				'claim1'	=>	$task['claim_'.$task['claim'].'_1'],
				'claim2'	=>	$task['claim_'.$task['claim'].'_2'],
				'reward'	=>	$task['reward'],
				'reward1'	=>	$task['reward_'.$task['reward'].'_1'],
				'reward2'	=>	$task['reward_'.$task['reward'].'_2'],
				'grouplimit'=>	($task['grouplimit'] ? serialize($task['grouplimit']) : ''),
		);
		if ($id = intval($_GET['id'])) {
			C::t('#e6_propaganda#e6_pro_task')->update($id, $data);
		} else {
			C::t('#e6_propaganda#e6_pro_task')->insert($data);
		}
		cpmsg($e6_lang['success'], cpurl(false, array('tasknav')), 'succeed');
	} else {
		showformheader('plugins&'. cpurl(false, array('action')));
		if ($id = intval($_GET['taskid'])) {
			$task = C::t('#e6_propaganda#e6_pro_task')->fetch($id);
			$task['starttime'] = $task['starttime'] ? dgmdate($task['starttime']) : '';
			$task['endtime'] = $task['endtime'] ? dgmdate($task['endtime']) : '';
			$task['claim_'.$task['claim'].'_1'] = $task['claim1'];
			$task['claim_'.$task['claim'].'_2'] = $task['claim2'];
			$task['reward_'.$task['reward'].'_1'] = $task['reward1'];
			$task['reward_'.$task['reward'].'_2'] = $task['reward2'];
			$task['grouplimit'] && $task['grouplimit'] = unserialize($task['grouplimit']);
			echo '<input type="hidden" name="id" value="'.$id.'" />';
		}
		showsetting($e6_lang['task_name'], 'task[name]', $task['name'], 'text', 0, 0, $e6_lang['task_name_comment']);
		showsetting($e6_lang['task_icon'], 'task[icon]', $task['icon'], 'text', 0, 0, $e6_lang['task_icon_comment']);
		echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
		showsetting($e6_lang['task_starttime'], 'task[starttime]', $task['starttime'], 'calendar', 0, 0, $e6_lang['task_starttime_comment'], 1);
		showsetting($e6_lang['task_endtime'], 'task[endtime]', $task['endtime'], 'calendar', 0, 0, $e6_lang['task_endtime_comment'], 1);
		foreach(C::t('common_usergroup')->range() as $group) {
			$groups[$group['groupid']] = $group['grouptitle'];
		}
		showsetting($e6_lang['task_claim'], array('task[claim]', (array)admin_show_tbody('claim', 5)), $task['claim'], 'mradio', 0, 0, $e6_lang['task_claim_comment']);
		showtagheader('tbody', 'claim_0', $task['claim'] == 0 , 'sub');
		$html  = '<input name="task[claim_0_1]" value="'.$task['claim_0_1'].'" type="text" style="width:50px;" /> ';
		$html .= "<span>{$e6_lang['a']}</span>";
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		showtagheader('tbody', 'claim_1', $task['claim'] == 1 , 'sub');
		$html  = '<input name="task[claim_1_1]" value="'.$task['claim_1_1'].'" type="text" style="width:50px;" /> ';
		$html .= "<span>{$e6_lang['people']}</span>";
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		showtagheader('tbody', 'claim_2', $task['claim'] == 2 , 'sub');
		$html  = '<input name="task[claim_2_1]" value="'.$task['claim_2_1'].'" type="text" style="width:50px;" /> ';
		$html .= "<span>{$e6_lang['people']}</span>";
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		showtagheader('tbody', 'claim_3', $task['claim'] == 3 , 'sub');
		$html  = '<input name="task[claim_3_1]" value="'.$task['claim_3_1'].'" type="text" style="width:50px;" /> ';
		$html .= "<span>{$e6_lang['yuan']}</span>";
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		showtagheader('tbody', 'claim_4', $task['claim'] == 4 , 'sub');
		$html = '<select name="task[claim_4_1]" style="width:120px;">';
		for ($n=1; $n<=10; $n++) {
			$html .= '<option value="'.$n.'" '.($n == $task['claim_4_1'] ? 'selected' : '').'>'.$n.$e6_lang['task_num_active'].'</option>';
		}
		$html .= '</select>';
		$html .= '<input name="task[claim_4_2]" value="'.$task['claim_4_2'].'" type="text" style="width:50px;" /> ';
		$html .= "<span>{$e6_lang['people']}</span>";
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		foreach(C::t('common_usergroup')->fetch_all_by_type('special', '0') as $group) {
			$vip_groups[$group['groupid']] = $group['grouptitle'];
		}
		showtagheader('tbody', 'claim_5', $task['claim'] == 5 , 'sub');
		$html = '<select name="task[claim_5_1]" style="width:120px;">';
		foreach($vip_groups as $k => $v) {
			$html .= '<option value="'.$k.'" '.($k == $task['claim_5_1'] ? 'selected' : '').'>'.$v.'</option>';
		}
		$html .= '</select>';
		$html .= '<input name="task[claim_5_2]" value="'.$task['claim_5_2'].'" type="text" style="width:50px;" /> ';
		$html .= "<span>{$e6_lang['people']}</span>";
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		showsetting($e6_lang['task_reward'], array('task[reward]', (array)admin_show_tbody('reward', 3)), $task['reward'], 'mradio', 0, 0, $e6_lang['task_reward_comment']);
		showtagheader('tbody', 'reward_0', $task['reward'] == 0 , 'sub');
		$html  = '<input name="task[reward_0_1]" value="'.$task['reward_0_1'].'" type="text" style="width:50px;" /> ';
		$html .= '<select name="task[reward_0_2]" style="width:60px;">';
		foreach($_G['setting']['extcredits'] as $k => $v) {
			$html .= '<option value="'.$k.'" '.($k == $task['reward_0_2'] ? 'selected' : '').'>'.$v['title'].'</option>';
		}
		$html .= '</select>';
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		showtagheader('tbody', 'reward_1', $task['reward'] == 1 , 'sub');
		$magic_list = C::t('common_magic')->fetch_all_name_by_available();
		if ($magic_list) {
			$html = '<input name="task[reward_1_1]" value="'.$task['reward_1_1'].'" type="text" style="width:50px;" /> ';
			$html .= "<span>{$e6_lang['a']}</span> ";
			$html .= '<select name="task[reward_1_2]" style="width:120px;">';
			foreach ($magic_list as $v) {
				$html .= '<option value="'.$v['magicid'].'" '.($v['magicid'] == $task['reward_1_2'] ? 'selected' : '').'>'.$v['name'].'</option>';
			}
			$html .= '</select>';
		} else {
			$html = '<span style="color:red;">'.$e6_lang['magic_noopen'].'(<a href="'.ADMINSCRIPT.'?action=magics&operation=admin" style="color:blue;">'.$e6_lang['task_setting'].'</a>)</span>';
		}
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		showtagheader('tbody', 'reward_2', $task['reward'] == 2 , 'sub');
		$medal_list = C::t('forum_medal')->fetch_all_name_by_available();
		if ($medal_list) {
			$html = '<select name="task[reward_2_1]" style="width:120px;">';
			foreach ($medal_list as $v) {
				$html .= '<option value="'.$v['medalid'].'" '.($v['medalid'] == $task['reward_2_1'] ? 'selected' : '').'>'.$v['name'].'</option>';
			}
			$html .= '</select>';
		} else {
			$html = '<span style="color:red;">'.$e6_lang['medal_noopen'].'(<a href="admin.php?action=medals" style="color:blue;">'.$e6_lang['task_setting'].'</a>)</span>';
		}
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		showtagheader('tbody', 'reward_3', $task['reward'] == 3 , 'sub');
		$html = '<select name="task[reward_3_1]" style="width:120px;">';
		foreach($vip_groups as $k => $v) {
			$html .= '<option value="'.$k.'" '.($k == $task['reward_3_1'] ? 'selected' : '').'>'.$v.'</option>';
		}
		$html .= '</select>';
		$html .= " <span>{$e6_lang['task_vipdate']}</span> ";
		$html .= '<input name="task[reward_3_2]" value="'.$task['reward_3_2'].'" type="text" style="width:50px;" /> ';
		$html .= " <span>{$e6_lang['task_vipdate_comment']}</span>";
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
		showtagfooter('tbody');
		!$task['grouplimit'] && $task['grouplimit'] = array('e6');
		showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['grouplimit'].'<input class="checkbox" type="checkbox" name="chkall1" onclick="checkAll(\'prefix\', this.form, \'group\', \'chkall1\', true)" id="chkall1" /><label for="chkall1"> '.cplang('select_all').'</label>', $e6_lang['grouplimit_comment']));
		showtablerow('', 'colspan="2"', mcheckbox('task[grouplimit]', $groups, $task['grouplimit']));
		showsubmit('e6_submit');
		showformfooter();
		showtablefooter();
	}
} else {
	showsubtitle(array(
		'ID',
		$e6_lang['task_name'],
		$e6_lang['task_join'].' / '.$e6_lang['task_ok'],
		$e6_lang['task_tasktype'],
		$e6_lang['task_rewardtype'],
		$e6_lang['task_starttime'],
		$e6_lang['task_overtime'],
		$e6_lang['task_admin']
	));
	$_GET['tasknav'] == 'over' && $conditions = " AND `endtime`>0 AND `endtime`<'{$_G['timestamp']}' ";
	$_GET['tasknav'] == 'current' &&  $conditions = " AND (`endtime`='0' OR `endtime`>'{$_G['timestamp']}') ";
	$perpage = 20;
	$start = ($page - 1) * $perpage;
	$taskcount = C::t('#e6_propaganda#e6_pro_task')->count_by_search($conditions);
	if($taskcount) {
		$n = ($page - 1) * $perpage + 1;
		$claim_list = task_type();
		$reward_list = task_reward();
		foreach (C::t('#e6_propaganda#e6_pro_task')->fetch_all_by_search($conditions, $start, $perpage) as $v) {
			showtablerow('', '', array(
				$n,
				$v['name'],
				$v['participate'].$e6_lang['people'].' / '.$v['complete'].$e6_lang['people'],
				$claim_list[$v['claim']],
				$reward_list[$v['reward']],
				$v['starttime'] ? dgmdate($v['starttime']) : $e6_lang['all_date'],
				$v['endtime'] ? dgmdate($v['endtime']) : $e6_lang['all_date'],
				'<a href="'.ADMINSCRIPT.'?'.cpurl(false, array('tasknav')).'&tasknav=edit&taskid='.$v['id'].'">'.$e6_lang['edit'].'</a> | '.
				'<a href="'.ADMINSCRIPT.'?'.cpurl(false, array('tasknav')).'&tasknav=del&taskid='.$v['id'].'&formhash='.FORMHASH.'">'.$e6_lang['del'].'</a>',
			));
			$n++;
		}
		$multi = multi($taskcount, $perpage, $page, ADMINSCRIPT."?".cpurl(false)."&task=".$_GET['tasknav']);
	}
	showtablefooter();
	echo $multi;
}

?>