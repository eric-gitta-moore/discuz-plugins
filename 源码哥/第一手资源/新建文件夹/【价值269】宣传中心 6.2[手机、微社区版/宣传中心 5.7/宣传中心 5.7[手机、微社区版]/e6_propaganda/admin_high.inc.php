<?php

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
$setting = current(C::t('common_setting')->fetch_all('e6_propaganda', true));
if (submitcheck('e6_submit')) {
!$setting && $setting = array();
	!$_GET['setting']['group_id'] && $setting['group_id'] = '';
	!$_GET['setting']['nav_arr'] && $setting['nav_arr'] = '';
	!$_GET['setting']['withdrawgroup'] && $setting['withdrawgroup'] = '';
	!$_GET['setting']['withdraw_profile'] && $setting['withdraw_profile'] = '';
	$msg = 'setting_update_succeed';
	$_GET['setting']['withdrawann'] = cutstr($_GET['setting']['withdrawann'], 50, NULL);
	foreach($_GET['setting']['dividend'] as $k=>$v) {
		if ($v && !is_numeric($v)) $_GET['setting']['dividend'][$k] = 0;
		if ($v >10){
			$_GET['setting']['dividend'][$k] = 10;
			$msg = $e6_lang['dividend_msg'];
		}
	}
	$_GET['setting'] = array_merge($setting, $_GET['setting']);
	C::t('common_setting')->update_batch(array('e6_propaganda' => serialize(daddslashes($_GET['setting']))));
	updatecache('setting');
	cpmsg($msg, cpurl(false), 'succeed');
}
!$setting['group_id'] && $setting['group_id'] = array('e6');
!$setting['nav_arr'] && $setting['nav_arr'] = array('e6');
!$setting['withdrawgroup'] && $setting['withdrawgroup'] = array('e6');
!$setting['withdraw_profile'] && $setting['withdraw_profile'] = array('e6');
showformheader('plugins&'. cpurl(false, array('action')));
showtableheader($e6_lang['setting_vip']);
showsetting($e6_lang['vip_open'], array('setting[vip_open]', array(
			array('1', $e6_lang['e6_open'], array('vip_open'=>'')),
			array('0', $e6_lang['e6_close'], array('vip_open'=>'none'))
)), $setting['vip_open'], 'mradio2');
foreach(C::t('common_usergroup')->fetch_all_by_type('special', '0') as $group) {
	$groups[$group['groupid']] = $group['grouptitle'];
}
showtagheader('tbody', 'vip_open', $setting['vip_open'] == 1 , 'sub');
showtablerow('class="noborder"', 'colspan="2"', $e6_lang['vip_open_comment'].' (<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=e6_propaganda&pmod=admin_multi">'.$e6_lang['set_reward'].'</a>)');
if (file_exists("{$pro_module}vip_extra.php")) {
	if (!function_exists('vip_extra_admin')) {
		require "{$pro_module}vip_extra.php";
	}
	vip_extra_admin();
} else {
	$html = '<select name="setting[group_id][]" style="width:120px;">';
	foreach($groups as $k => $v) {
		$html .= '<option value="'.$k.'" '.(in_array($k, $setting['group_id'])  ? 'selected' : '').'>'.$v.'</option>';
	}
	$html .= '</select>';
}
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtagfooter('tbody');
showsetting($e6_lang['paytype'], array('setting[paytype]', (array)admin_show_tbody('paytype', 2)), $setting['paytype'], 'mradio2');
showtagheader('tbody', 'paytype_0', $setting['paytype'] == 0 , 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $e6_lang['paytype_comment0']);
showtagfooter('tbody');
showtagheader('tbody', 'paytype_1', $setting['paytype'] == 1 , 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $e6_lang['paytype_comment1'].' (<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=e6_propaganda&pmod=admin_multi">'.$e6_lang['set_reward'].'</a>)');
showtagfooter('tbody');
$html  = "<span>{$e6_lang['reward_money']}: </span>";
$html .= '<input name="setting[pay_money2]" value="'.$setting['pay_money2'].'" type="text" style="width:50px;" /> ';
$html .= '<select name="setting[pay_type2]" style="width:120px;">';
foreach($_G['setting']['extcredits'] as $k => $v) {
	$html .= '<option value="'.$k.'" '.($k == $setting['pay_type2'] ? 'selected' : '').'>'.$v['title'].'</option>';
}
$html .= '</select>';
showtagheader('tbody', 'paytype_2', $setting['paytype'] == 2 , 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $e6_lang['paytype_comment2'].' (<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=e6_propaganda&pmod=admin_multi">'.$e6_lang['set_reward'].'</a>)');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtagfooter('tbody');
showsetting($e6_lang['paycard'], 'setting[paycard]', $setting['paycard'], 'radio', 0, 0, $e6_lang['paycard_comment'].' (<a href="'.ADMINSCRIPT.'?action=card&operation=manage">'.$e6_lang['set_card'].'</a>)');
showsetting($e6_lang['paymsg'], 'setting[paymsg]', $setting['paymsg'], 'radio', 0, 0, $e6_lang['paymsg_comment']);
showtablefooter();
showtableheader($e6_lang['setting_withdraw']);
showsetting($e6_lang['withdrawopen'], 'setting[withdrawopen]', $setting['withdrawopen'], 'radio', 0, 0, $e6_lang['withdrawopen_comment']);
showsetting($e6_lang['withdrawann'], 'setting[withdrawann]', $setting['withdrawann'], 'textarea', 0, 0, $e6_lang['withdrawann_comment']);
foreach(C::t('common_usergroup')->range() as $group) {
	$groups[$group['groupid']] = $group['grouptitle'];
}
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['withdrawgroup'].'<input class="checkbox" type="checkbox" name="chkall2" onclick="checkAll(\'prefix\', this.form, \'withdrawgroup\', \'chkall2\', true)" id="chkall2" /><label for="chkall2"> '.cplang('select_all').'</label>', $e6_lang['withdrawgroup_comment']));
showtablerow('class="noborder"', 'colspan="2"', mcheckbox('setting[withdrawgroup]', $groups, $setting['withdrawgroup']));
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['withdraw_money'], $e6_lang['withdraw_money_comment']));
$html  = '<input name="setting[withdraw_money]" value="'.$setting['withdraw_money'].'" type="text" style="width:50px;" /> ';
$html .= '<select name="setting[withdraw_type]" style="width:120px;">';
foreach($_G['setting']['extcredits'] as $k => $v) {
	$html .= '<option value="'.$k.'" '.($k == $setting['withdraw_type'] ? 'selected' : '').'>'.$v['title'].'</option>';
}
$html .= '</select>';
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
if (file_exists("{$pro_module}withdraw_extra.php")) {
	if (!function_exists('withdraw_extra_admin')) {
		require "{$pro_module}withdraw_extra.php";
	}
	withdraw_extra_admin();	
} else {
	showsetting($e6_lang['feetype'], array('setting[feetype]', (array)admin_show_tbody('feetype', 4, array(2,4), array(2,4))), $setting['feetype'], 'mradio2');
}
showtagheader('tbody', 'feetype_0', $setting['feetype'] == 0 , 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $e6_lang['feetype0_comment']);
showtagfooter('tbody');
$html  = '<input name="setting[fee_money]" value="'.$setting['fee_money'].'" type="text" style="width:50px;" /> ';
$html .= '<select name="setting[fee_type]" style="width:120px;">';
foreach($_G['setting']['extcredits'] as $k => $v) {
	$html .= '<option value="'.$k.'" '.($k == $setting['fee_type'] ? 'selected' : '').'>'.$v['title'].'</option>';
}
$html .= '</select>';
showtagheader('tbody', 'feetype_1', $setting['feetype'] == 1 , 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $e6_lang['feetype1_comment']);
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtagfooter('tbody');
$html  = "<span>{$e6_lang['feetype3_comment1']} </span>";
$html .= '<input name="setting[pay_proportion]" value="'.$setting['pay_proportion'].'" type="text" style="width:50px;" />';
$html .= "<span> %</span>";
showtagheader('tbody', 'feetype_3', $setting['feetype'] == 3 , 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $e6_lang['feetype3_comment']);
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtagfooter('tbody');
showsetting($e6_lang['withdrawmsg'], 'setting[withdrawmsg]', $setting['withdrawmsg'], 'radio', 0, 0, $e6_lang['withdrawmsg_comment']);
$no_profile_array = array(
	'field1',		'field2',		'field3',
	'field4',		'field5',		'field6',
	'field7',		'field8',		'realname',
	'telephone',	'mobile',		'idcard',
	'address',		'zipcode',		'residecity',
	'alipay',		'icq',			'qq',
	'yahoo',		'msn',
);
foreach(C::t('common_member_profile_setting')->fetch_all_by_available(1) as $fieldid => $v) {
	if (in_array($fieldid, $no_profile_array)) $profile_list[$fieldid] = $v['title'];
}
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['withdraw_profile'].'<input class="checkbox" type="checkbox" name="chkall1" onclick="checkAll(\'prefix\', this.form, \'withdraw_profile\', \'chkall1\', true)" id="chkall1" /><label for="chkall1"> '.cplang('select_all').'</label>', $e6_lang['withdraw_profile_comment'].' (<a href="'.ADMINSCRIPT.'?action=members&operation=profile" style="color:blue;">'.$e6_lang['add_withdraw_profile'].'</a>)'));
showtablerow('class="noborder"', 'colspan="2"', mcheckbox('setting[withdraw_profile]', $profile_list, $setting['withdraw_profile']));
$nav_arr = pro_nav();
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['nav_arr'].'<input class="checkbox" type="checkbox" name="chkall3" onclick="checkAll(\'prefix\', this.form, \'nav_arr\', \'chkall3\', true)" id="chkall3" /><label for="chkall3"> '.cplang('select_all').'</label>', $e6_lang['nav_arr_comment']));
showtablerow('', 'colspan="2"', mcheckbox('setting[nav_arr]', $nav_arr, $setting['nav_arr']));
showtablefooter();
showtableheader($e6_lang['setting_user']);
showsetting($e6_lang['showuser'], 'setting[showuser]', $setting['showuser'], 'radio', 0, 0, $e6_lang['showuser_comment']);
showsetting($e6_lang['message'], 'setting[message]', $setting['message'], 'radio', 0, 0, $e6_lang['message_comment']);
if (file_exists("{$pro_module}register_extra.php")) {
	if (!function_exists('register_extra_admin')) {
		require "{$pro_module}register_extra.php";
	}
	register_extra_admin();	
}
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['dividend'], $e6_lang['dividend_comment']));
$html  = '<ul class="nofloat" style="width:100%">';
foreach ($groups as $k => $v) {
	$html .= "<li style=\"float: left; width: 33%\"><span>{$v}: </span><input name=\"setting[dividend][{$k}]\" type=\"text\" value=\"{$setting['dividend'][$k]}\" size=\"3\" /> {$e6_lang['layers']}</li>";
}
$html .= '</ul>';
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showsubmit('e6_submit');
showtablefooter();
showformfooter();
?>