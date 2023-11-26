<?php
 
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
$setting = current(C::t('common_setting')->fetch_all('e6_propaganda', true));
if (submitcheck('e6_submit')) {
	!$setting && $setting = array();
	$msg = 'setting_update_succeed';
	if ($_GET['setting']['active_num']>10) {
		$_GET['setting']['active_num'] = 10;
		$msg = $e6_lang['active_num_msg'];
	}
	for($n = $_GET['setting']['active_num']+1; $n<=10; $n++) {
		unset($_GET['setting']['active_condition'][$n], $_GET['setting']['active_money'][$n]);
	}
	$_GET['setting'] = array_merge($setting, $_GET['setting']);
	C::t('common_setting')->update_batch(array('e6_propaganda' => serialize(daddslashes($_GET['setting']))));
	updatecache('setting');
	cpmsg($msg, cpurl(false), 'succeed');
}
showformheader('plugins&'.cpurl(false, array('action')));
showtableheader($e6_lang['activation_title']);
showsetting($e6_lang['active_num'], 'setting[active_num]', $setting['active_num'], 'text', 0, 0, $e6_lang['active_num_comment']);
foreach (C::t('common_usergroup')->range_orderby_creditshigher() as $group) {
	if ($group['type'] == 'member') {
		$groups[$group['groupid']] = $group['grouptitle'];
	}
}
for ($n=1; $n<=$setting['active_num']; $n++) {
	showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($n.$e6_lang['active_condition'], $e6_lang['active_condition_comment']));
	$html  = '<ul class="nofloat" style="width:100%">';
	$html .= "<li style=\"float: left; width: 33%\"><input name=\"setting[active_condition][{$n}][online]\" type=\"text\" value=\"{$setting['active_condition'][$n]['online']}\" size=\"3\" /> <span>{$e6_lang['active_online']}</span></li>";
	$html .= "<li style=\"float: left; width: 33%\"><input name=\"setting[active_condition][{$n}][posts]\" type=\"text\" value=\"{$setting['active_condition'][$n]['posts']}\" size=\"3\" /> <span>{$e6_lang['active_posts']}</span></li>";
	$html .= "<li style=\"float: left; width: 33%\"><span>{$e6_lang['active_groupid']}</span>";
	$html .= "<select name=\"setting[active_condition][{$n}][groupid]\" style=\"width:120px;\"><option value=\"0\">--{$e6_lang['active_groupid_default']}--</option>";
	foreach ($groups as $k => $v) {
		$html .= '<option value="'.$k.'" '.($k == $setting['active_condition'][$n]['groupid'] ? 'selected' : '').'>'.$v.'</option>';
	}
	$html .= "</select></li>";
	$html .= '</ul>';
	showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
	showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($n.$e6_lang['active_money'], $e6_lang['active_money_comment']));
	$html  = '<ul class="nofloat" style="width:100%">';
	foreach ($_G['setting']['extcredits'] as $k => $v) {
		$html .= "<li style=\"float: left; width: 18%\"><input name=\"setting[active_money][{$n}][{$k}]\" type=\"text\" value=\"{$setting['active_money'][$n][$k]}\" size=\"3\" /> <span>{$v['title']}</span></li>";
	}
	$html .= '</ul>';
	showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
}
showsubmit('e6_submit');
showtablefooter();
showformfooter();
?>