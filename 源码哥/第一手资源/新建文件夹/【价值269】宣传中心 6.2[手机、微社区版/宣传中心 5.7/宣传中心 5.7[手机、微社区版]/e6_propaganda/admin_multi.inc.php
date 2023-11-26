<?php

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
$setting = current(C::t('common_setting')->fetch_all('e6_propaganda', true));
if (submitcheck('e6_submit')) {
	!$setting && $setting = array();
	$msg = 'setting_update_succeed';
	$_GET['setting'] = array_merge($setting, $_GET['setting']);
	C::t('common_setting')->update_batch(array('e6_propaganda' => serialize(daddslashes($_GET['setting']))));
	updatecache('setting');
	cpmsg($msg, cpurl(false), 'succeed');
}
showformheader('plugins&'. cpurl(false, array('action')));
showtableheader($e6_lang['multi_title']);
if ($setting['registertype'] == 2) {
	showtablerow('', 'class="td27"', $e6_lang['multi_reg']);
	$html = '<ul class="nofloat" style="width:100%">';
	for ($n=1; $n<=10; $n++) {
		$html .= '<li style="float:left; width:33%;">';
		$html .= $n.$e6_lang['multi_reg_title']."<input name=\"setting[multi_reg][{$n}][money]\" value=\"{$setting['multi_reg'][$n]['money']}\" style=\"width:30px;\"> ";
		$html .= "<select name=\"setting[multi_reg][{$n}][type]\" style=\"width:80px;\">";
		foreach($_G['setting']['extcredits'] as $k => $v) {
			$html .= '<option value="'.$k.'" '.($k == $setting['multi_reg'][$n]['type'] ? 'selected' : '').'>'.$v['title'].'</option>';
		}
		$html .= '</select>';
		$html .= '</li>';
	}
	$html .= '</ul>';
	showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
}
if ($setting['paytype'] > 0) {
	showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['multi_pay'], $e6_lang['multi_pay_comment'].' (<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=e6_propaganda&pmod=admin_high">'.$e6_lang['multi_pay_setting'].'</a>)'));
	$html = '<ul class="nofloat" style="width:100%">';
	for ($n=1; $n<=10; $n++) {
		$html .= '<li style="float:left; width:33%;">'.$n.$e6_lang['multi_pay_title'];
		if ($setting['paytype'] == 1) {
			$html .= "<input name=\"setting[multi_pay][{$n}][money]\" value=\"{$setting['multi_pay'][$n]['money']}\" style=\"width:30px;\"> ";
			$html .= "<select name=\"setting[multi_pay][{$n}][type]\" style=\"width:80px;\">";
			foreach($_G['setting']['extcredits'] as $k => $v) {
				$html .= '<option value="'.$k.'" '.($k == $setting['multi_pay'][$n]['type'] ? 'selected' : '').'>'.$v['title'].'</option>';
			}
			$html .= '</select>';
		} else {
			$html .= "<input name=\"setting[multi_pay][{$n}][percentage]\" value=\"{$setting['multi_pay'][$n]['percentage']}\" style=\"width:30px;\"> <span>%</span>";
		}
		$html .= '</li>';
	}
	$html .= '</ul>';
	showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
}
foreach(C::t('common_usergroup')->range() as $group) {
	$groups[$group['groupid']] = $group['grouptitle'];
}
if ($setting['vip_open'] > 0) {
	foreach ($setting['group_id'] as $value) {
		showtablerow('', 'class="td27"', $e6_lang['multi_vip'].'<span style="color:red"> '.$groups[$value].' </span>'.$e6_lang['multi_vip_reward']);
		$html = '<ul class="nofloat" style="width:100%">';
		for ($n=1; $n<=10; $n++) {
			$html .= '<li style="float:left; width:33%;">';
			$html .= $n.$e6_lang['multi_vip_title'].": <input name=\"setting[multi_vip][{$value}][{$n}][money]\" value=\"{$setting['multi_vip'][$value][$n]['money']}\" style=\"width:30px;\"> ";
			$html .= "<select name=\"setting[multi_vip][{$value}][{$n}][type]\" style=\"width:80px;\">";
			foreach($_G['setting']['extcredits'] as $k => $v) {
				$html .= '<option value="'.$k.'" '.($k == $setting['multi_vip'][$value][$n]['type'] ? 'selected' : '').'>'.$v['title'].'</option>';
			}
			$html .= '</select>';
			$html .= '</li>';
		}
		$html .= '</ul>';
		showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
	}
}
showsubmit('e6_submit');
showtablefooter();
showformfooter();
?>