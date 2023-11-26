<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require 'e6_propaganda.func.php';
$setting = current(C::t('common_setting')->fetch_all('e6_propaganda', true));
if (submitcheck('e6_submit')) {
	!$_GET['setting']['mobile_nav_arr'] && $setting['mobile_nav_arr'] = '';
	$msg = 'setting_update_succeed';
	$_GET['setting'] = array_merge($setting, $_GET['setting']);
	C::t('common_setting')->update_batch(array('e6_propaganda' => serialize(daddslashes($_GET['setting']))));
	updatecache('setting');
	cpmsg($msg, cpurl(false), 'succeed');
}
!$setting['mobile_nav_arr'] && $setting['mobile_nav_arr'] = array('e6');
!isset($setting['mobile_close']) && $setting['mobile_close'] = $e6_lang['pro_close'];
showformheader('plugins&'.cpurl(false, array('action')));
showtableheader($e6_lang['mobile_setting']);
showsetting($e6_lang['mobile_open'], 'setting[mobile_open]', $setting['mobile_open'], 'radio', 0, 0, $e6_lang['mobile_open_comment']);
showsetting($e6_lang['mobile_close'], 'setting[mobile_close]', $setting['mobile_close'], 'textarea');
$nav_arr = pro_nav();
showtablerow('', array('class="td27"', 'class="vtop tips2"'), array($e6_lang['nav_arr'].'<input class="checkbox" type="checkbox" name="chkall3" onclick="checkAll(\'prefix\', this.form, \'nav_arr\', \'chkall3\', true)" id="chkall3" /><label for="chkall3"> '.cplang('select_all').'</label>', $e6_lang['nav_arr_comment']));
showtablerow('', 'colspan="2"', mcheckbox('setting[mobile_nav_arr]', $nav_arr, $setting['mobile_nav_arr']));
showtablefooter();
showtableheader($e6_lang['wechat_setting']);
showsetting($e6_lang['wechat_open'], 'setting[wechat_open]', $setting['wechat_open'], 'radio', 0, 0, $e6_lang['wechat_open_comment']);
$mobile_url_arr = array(
	array(0, $e6_lang['wechat_top']),
	array(1, $e6_lang['wechat_side'])
);
showsetting($e6_lang['mobile_url'], array('setting[mobile_url]', $mobile_url_arr), $setting['mobile_url'], 'select', 0, 0, $e6_lang['mobile_url_comment']);
showsetting($e6_lang['top_text'], 'setting[top_text]', $setting['top_text'], 'textarea', 0, 0, $e6_lang['top_text_comment']);
showsubmit('e6_submit');
showtablefooter();
showformfooter();
?>