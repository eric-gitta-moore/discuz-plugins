<?php

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
$setting = current(C::t('common_setting')->fetch_all('e6_propaganda', true));
if (submitcheck('auditedyes')) {
	if (is_array($_GET['withdraw_id'])) {
		C::t('#e6_propaganda#e6_pro_finance')->update($_GET['withdraw_id'], array(
			'ok' =>	1,
			'okdate' => $_G['timestamp']
		));
		if ($setting['withdrawmsg']) {
			foreach (C::t('#e6_propaganda#e6_pro_finance')->fetch_all($_GET['withdraw_id']) as $v) {
				$message_content = lang('plugin/e6_propaganda', 'withdraw_yesmsg_con', array(
					'date' => dgmdate($v['date']),
					'money'=> $v['money'].$_G['setting']['extcredits'][$v['type']]['title']
				));
				notification_add($v['uid'], 'system', 'system_notice', array(
						'subject' => $e6_lang['withdraw_yesmsg'],
						'message' => $message_content,
						'from_id' => 0,
						'from_idtype' => 'e6_pro'
				),1);
			}
		}
		cpmsg($e6_lang['success'], cpurl(false), 'succeed');
	}
} elseif (submitcheck('auditedno')) {
	if (is_array($_GET['withdraw_id'])) {
		C::t('#e6_propaganda#e6_pro_finance')->update($_GET['withdraw_id'], array(
			'ok' => 2,
			'okdate'=> $_G['timestamp']
		));
		foreach (C::t('#e6_propaganda#e6_pro_finance')->fetch_all($_GET['withdraw_id']) as $v) {
			$v['date'] = dgmdate($v['date']);
			${'user_money'.$v['uid']} = pro_money(
				array($v['type']=>$v['money']),
				'7c',
				array('date'=>$v['date']),
				$v['uid'],
				${'user_money'.$v['uid']});
			if ($v['feemoney']) {
				$fee = ' ('.$e6_lang['withdraw_nomsg_fee'].$v['feemoney'].$_G['setting']['extcredits'][$v['feetype']]['title'].') ';
				${'user_money'.$v['uid']} = pro_money(
					array($v['feetype']=>$v['feemoney']),
					'7d',
					array('date'=>$v['date']),
					$v['uid'],
					${'user_money'.$v['uid']});
			}
			if ($setting['withdrawmsg']) {
				$message_content = lang('plugin/e6_propaganda', 'withdraw_nomsg_con', array(
					'date' => $v['date'],
					'money'=> $v['money'].$_G['setting']['extcredits'][$v['type']]['title'],
					'fee'=> $fee
				));
				notification_add($v['uid'], 'system', 'system_notice', array(
						'subject' => $e6_lang['withdraw_nomsg'],
						'message' => $message_content,
						'from_id' => 0,
						'from_idtype' => 'e6_pro'
				),1);
			}
		}
		cpmsg($e6_lang['success'], cpurl(false), 'succeed');
	}
}
$state_list = array($e6_lang['not_audited'], $e6_lang['audited'], $e6_lang['refund']);
showformheader('plugins&identifier=e6_propaganda&pmod=admin_withdraw');
showtableheader('search');
$state_option = "<option value=''>{$e6_lang['all']}</option>";
foreach ($state_list as $k => $v) {
	$state_option .= "<option value=\"{$k}\">{$v}</option>";
}
echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
showtablerow('',
	array('width="125"', 'width="110"', 'width="320"'),
	array(
		$e6_lang['username'].': <input type="text" name="username" style="width:65px;">',
		$e6_lang['state'].': <select name="state">'.$state_option.'</select>',
		$e6_lang['withdraw_time'].': <input type="text" name="sdate" style="width: 108px;" onclick="showcalendar(event, this)"> -- <input type="text" name="edate" style="width: 108px;" onclick="showcalendar(event, this)">',
        "<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" />
		&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?".cpurl(false)."&excel=down\" style=\"color:blue;\">{$e6_lang['withdraw_excel']}</a>"
	)
);
showtablefooter();
showtableheader();
$tabletop[] = $e6_lang['id'];
$tabletop[] = $e6_lang['username'];
$tabletop[] = $e6_lang['withdraw_num'];
if ($setting['feetype']) {
	$tabletop[] = $e6_lang['withdraw_fee'];
}
if (!empty($setting['withdraw_profile'])) {
	$profile_list = C::t('common_member_profile_setting')->fetch_all($setting['withdraw_profile']);
	foreach ($profile_list as $k => $v) {
		$tabletop[] = $v['title'];
		$withdraw_profile[] = $k;
	}
}
$tabletop[] = $e6_lang['withdraw_time'];
$tabletop[] = $e6_lang['audited_time'];
$tabletop[] = $e6_lang['state'];
$tabletop[] = $e6_lang['operation'];
showsubtitle($tabletop);
$perpage = 20;
$start = ($page - 1) * $perpage;
if ($_GET['username']) {
	$conditions .= " AND `username`='{$_GET['username']}'";
	$theurl .= '&username='.$_GET['username'];
}
if ($_GET['state'] != '') {
	$conditions .= " AND `ok`='".dintval($_GET['state'])."'";
	$theurl .= '&state='.$_GET['state'];
}
if ($_GET['sdate']) {
	$sdate = strtotime($_GET['sdate']);
	$conditions .= " AND `date`>'".strtotime($_GET['sdate'])."'";
	$theurl .='&sdate='.$_GET['sdate'];
}
if ($_GET['edate']) {
	$edate = strtotime($_GET['edate']);
	$conditions .= " AND `date`<'".strtotime($_GET['edate'])."'";
	$theurl .='&edate='.$_GET['edate'];
}
if ($_GET['excel'] == 'down') {
	$conditions = " AND `ok`='0'";
	$start = 0;
	$perpage = 10000;
	define('FOOTERDISABLED' , 1);
	ob_end_clean();
	header('Content-Encoding: none');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=withdraw_'.date('Ymd', TIMESTAMP).'.csv');
	header('Pragma: no-cache');
	header('Expires: 0');
	array_pop($tabletop);
	$list_withdraw = implode(',', $tabletop) . "\n";
}
$withdrawcount = C::t('#e6_propaganda#e6_pro_finance')->count_by_search($conditions);
if ($withdrawcount) {
	$n = ($page - 1) * $perpage + 1;
	foreach (C::t('#e6_propaganda#e6_pro_finance')->fetch_all_by_search($conditions, $start, $perpage) as $v) {
		$list_uid[$v['uid']] = $v['uid'];
		$list[] = $v;
	}
	if (!empty($setting['withdraw_profile']) && $list_uid) {
		$list_profile = C::t('common_member_profile')->fetch_all($list_uid);
	}
	foreach ($list as $v) {
		$table_list = array();
		$table_list[] = $n;
		$table_list[] = $v['username'];
		$table_list[] = $v['money'] . $_G['setting']['extcredits'][$v['type']]['title'];
		if ($v['feemoney']) {
			$table_list[] = $v['feemoney'].$_G['setting']['extcredits'][$v['feetype']]['title'];
		} else {
			$table_list[] = pro_lang('not');
		}
		if (!empty($setting['withdraw_profile'])) {
			foreach ($withdraw_profile as $value) {
				$table_list[] = $list_profile[$v['uid']][$value];
			}
		}
		$table_list[] =  dgmdate($v['date']);
		if($v['okdate']){
			$table_list[] = dgmdate($v['okdate']);
		}else{
			$table_list[] = $e6_lang['not'];
		}
		$table_list[] = $state_list[$v['ok']];
		$table_list[] = $v['ok'] == 0 ? "<input class=\"checkbox\" type=\"checkbox\" id=\"withdraw_id\" name=\"withdraw_id[]\" value=\"{$v['id']}\" />" : '';
		if ($_GET['excel'] == 'down') {
			array_pop($table_list);
			$list_withdraw .= implode(',', $table_list) . "\n";
		} else {
			showtablerow('', '', $table_list);
		}
		$n++;
	}
	$multi = multi($withdrawcount, $perpage, $page, ADMINSCRIPT."?".cpurl(false).$theurl);
}
if ($_GET['excel'] == 'down') {
	if($_G['charset'] != 'gbk') {
		$list_withdraw = diconv($list_withdraw, $_G['charset'], 'GBK');
	}
	echo $list_withdraw;
	exit();
}
showtablefooter();
showsubmit('', '', '', '<input type="checkbox" name="chkall" id="chkall" class="checkbox" onclick="checkAll(\'prefix\', this.form, \'withdraw_id\')" /><label for="chkall">'.cplang('select_all').'</label>&nbsp;&nbsp;<input type="submit" class="btn" name="auditedno" value="'.$e6_lang['auditedno'].'" />&nbsp;<input type="submit" class="btn" name="auditedyes" value="'.$e6_lang['auditedyes'].'" />', $multi);
showformfooter();
?>