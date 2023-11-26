<?php

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
$setting = current(C::t('common_setting')->fetch_all('e6_propaganda', true));
if (submitcheck('e6_submit')) {
	!$setting && $setting = array();
	!$_GET['setting']['group'] && $setting['group'] = '';
	$msg = 'setting_update_succeed';
	if (file_exists("{$pro_module}area_extra.php")) {
		if (!function_exists('area_extra_admin_submit')) {
			require "{$pro_module}area_extra.php";
		}
		list($msg, $_GET['setting']['visit_iptype']) = area_extra_admin_submit();
	}
	if ($_GET['setting']['iptype'] == 2) {
		$file_region = ip_area('192.168.1.1');
		if (!$file_region) {
			$_GET['setting']['iptype'] = 1;
			$msg = $e6_lang['iptype_msg'];
		}
	}
	if ($_GET['setting']['urltype'] == 1) {
		$digest_Y = rand_digest();
		if (!$digest_Y) {
			$_GET['setting']['urltype'] = 0;
			$msg = $e6_lang['urltype_msg'];
		}
	}
	$_GET['setting'] = array_merge($setting, $_GET['setting']);
	C::t('common_setting')->update_batch(array('e6_propaganda' => serialize(daddslashes($_GET['setting']))));
	updatecache('setting');
	savecache('e6_pro_global', 1);
	cpmsg($msg, cpurl(false), 'succeed');
}
!$setting['group'] && $setting['group'] = array('e6');
!$setting['url_url'] && $setting['url_url'] = $_G['siteurl'].'forum.php';
!isset($setting['close']) && $setting['close'] = $e6_lang['pro_close'];
showformheader('plugins&'.cpurl(false, array('action')));
showtableheader($e6_lang['setting']);
showsetting($e6_lang['open'], 'setting[open]', $setting['open'], 'radio', 0, 0, $e6_lang['open_comment']);
showsetting($e6_lang['close'], 'setting[close]', $setting['close'], 'textarea');
foreach(C::t('common_usergroup')->range() as $group) {
	$groups[$group['groupid']] = $group['grouptitle'];
}
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['group'].'<input class="checkbox" type="checkbox" name="chkall1" onclick="checkAll(\'prefix\', this.form, \'group\', \'chkall1\', true)" id="chkall1" /><label for="chkall1"> '.cplang('select_all').'</label>', $e6_lang['group_comment']));
showtablerow('', 'colspan="2"', mcheckbox('setting[group]', $groups, $setting['group']));
showtablefooter();
showtableheader($e6_lang['setting_reward']);
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['visit'], $e6_lang['visit_comment']));
$html = '<ul class="nofloat" style="width:100%">';
foreach ($_G['setting']['extcredits'] as $k => $v) {
	$html .= "<li style=\"float: left; width: 18%\"><input name=\"setting[visit_money][{$k}]\" type=\"text\" value=\"{$setting['visit_money'][$k]}\" size=\"3\" /> <span>{$v['title']}</span></li>";
}
$html .= '</ul>';
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showsetting($e6_lang['registertype'], array('setting[registertype]', (array)admin_show_tbody('registertype', 2, 0)), $setting['registertype'], 'mradio2');
$html  = '<ul class="nofloat" style="width:100%">';
foreach ($_G['setting']['extcredits'] as $k => $v) {
	$html .= "<li style=\"float: left; width: 18%\"><input name=\"setting[register_money][{$k}]\" type=\"text\" value=\"{$setting['register_money'][$k]}\" size=\"3\" /> <span>{$v['title']}</span></li>";
}
$html .= '</ul>';
showtagheader('tbody', 'registertype_1', $setting['registertype'] == 1, 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtagfooter('tbody');
$html = '<span style="color:blue;">'.$e6_lang['register_comment1'].' (<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=e6_propaganda&pmod=admin_multi">'.$e6_lang['set_reward'].'</a>) </span>';
showtagheader('tbody', 'registertype_2', $setting['registertype'] == 2, 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtagfooter('tbody');
if (file_exists("{$pro_module}area_extra.php")) {
	if (!function_exists('area_extra_admin')) {
		require "{$pro_module}area_extra.php";
	}
	area_extra_admin();
}
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['area'], $e6_lang['area_comment']));
$iptype_arr = array(
	1	=>	$e6_lang['iptype_bbs'],
	2	=>	$e6_lang['iptype_baidu']
);
$html  = "<span>{$e6_lang['iptype']}: </span>";
$html .= '<select name="setting[iptype]" style="width:120px;" >';
foreach($iptype_arr as $key => $value) {
	$html .= '<option value="'.$key.'"'.($key == $setting['iptype'] ? ' selected="selected"' : '').'>'.$value.'</option>';
}
$html .= '</select>';
$html .= "<span>{$e6_lang['iptype_area']}: </span>";
$html .= '<input name="setting[area]" value="'.$setting['area'].'" type="text" style="width:100px;" />';
$html .= "<span> {$e6_lang['iptype_comment']}</span>";
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['region'], $e6_lang['region_comment']));
$html  = '<ul class="nofloat" style="width:100%">';
foreach ($_G['setting']['extcredits'] as $key => $value) {
	$html .= "<li style=\"float: left; width: 18%\"><input name=\"setting[region_money][{$key}]\" type=\"text\" value=\"{$setting['region_money'][$key]}\" size=\"3\" /> <span>{$value['title']}</span></li>";
}
$html .= '</ul>';
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtablefooter();
showtableheader($e6_lang['setting_cheat']);
showsetting($e6_lang['ip'], 'setting[ip]', $setting['ip'], 'text', 0, 0, $e6_lang['ip_comment']);
showsetting($e6_lang['cookie'], 'setting[cookie]', $setting['cookie'], 'text', 0, 0, $e6_lang['cookie_comment']);
showsetting($e6_lang['interval'], 'setting[interval]', $setting['interval'], 'text', 0, 0, $e6_lang['interval_comment']);
showsetting($e6_lang['ipsection'], 'setting[ipsection]', $setting['ipsection'], 'radio', 0, 0, $e6_lang['ipsection_comment']);
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['max_visit'], $e6_lang['max_visit_comment']));
$html  = '<ul class="nofloat" style="width:100%">';
foreach ($_G['setting']['extcredits'] as $key => $value) {
	$html .= "<li style=\"float: left; width: 18%\"><input name=\"setting[max_visit][{$key}]\" type=\"text\" value=\"{$setting['max_visit'][$key]}\" size=\"3\" /> <span>{$value['title']}</span></li>";
}
$html .= '</ul>';
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['max_register'], $e6_lang['max_register_comment']));
$html  = '<ul class="nofloat" style="width:100%">';
foreach ($_G['setting']['extcredits'] as $key => $value) {
	$html .= "<li style=\"float: left; width: 18%\"><input name=\"setting[max_register][{$key}]\" type=\"text\" value=\"{$setting['max_register'][$key]}\" size=\"3\" /> <span>{$value['title']}</span></li>";
}
$html .= '</ul>';
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showsetting($e6_lang['cheatlog'], 'setting[cheatlog]', $setting['cheatlog'], 'radio', 0, 0, $e6_lang['cheatlog_comment']);
showtablefooter();
showtableheader($e6_lang['setting_url']);
showsetting($e6_lang['tidshare'], array('setting[tidshare]', (array)admin_show_tbody('tidshare', 1, 0)), $setting['tidshare'], 'mradio2');
$tidshare_arr = array($e6_lang['tidshare_type0'], $e6_lang['tidshare_type1'], $e6_lang['tidshare_type2'], $e6_lang['tidshare_type3']);
$html  = "<span>{$e6_lang['tidshare_position']}</span>";
$html .= '<select name="setting[tidshare_position]" style="width:120px;" >';
foreach($tidshare_arr as $key => $value) {
	$html .= '<option value="'.$key.'"'.($key == $setting['tidshare_position'] ? ' selected="selected"' : '').'>'.$value.'</option>';
}
$html .= '</select>';
showtagheader('tbody', 'tidshare_1', $setting['tidshare'] == 1 , 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtagfooter('tbody');
showsetting($e6_lang['tidurl'], 'setting[tidurl]', $setting['tidurl'], 'radio', 0, 0, $e6_lang['tidurl_comment']);
showsetting($e6_lang['urltype'], array('setting[urltype]', (array)admin_show_tbody('urltype', 1)), $setting['urltype'], 'mradio2');
$html  = "<span>{$e6_lang['url_address']}: </span>";
$html .= '<input name="setting[url_url]" value="'.$setting['url_url'].'" type="text" style="width:400px;" /> ';
showtagheader('tbody', 'urltype_0', $setting['urltype'] == 0 , 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $e6_lang['urltype_comment0']);
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $html);
showtagfooter('tbody');
showtagheader('tbody', 'urltype_1', $setting['urltype'] == 1 , 'sub');
showtablerow('class="noborder"', 'class="vtop rowform" colspan="2" style="width:100%"', $e6_lang['urltype_comment1']);
showtagfooter('tbody');
showsubmit('e6_submit');
showtablefooter();
showformfooter();
?>