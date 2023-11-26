<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
loadcache('plugin');
$langvars=lang('plugin/qu_app');
if(!submitcheck('submit')){
	$forumdisplay_Arr = DB::fetch_all("SELECT * from ".DB::table('qu_app')."");
	foreach($forumdisplay_Arr as $forum_Arr){$forum_Arr[] = $forumdisplay_Arr;}
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=login', 'submit');
	showtableheader(lang('plugin/qu_app', 'setting'));
	echo '<input type="hidden" name="formhash" value="'.FORMHASH.'">';
	showsetting(lang('plugin/qu_app', 'qqlogin'), 'login_qq', $forum_Arr['login_qq'], 'text','','',$langvars['login_qq_tip']);
	showsetting(lang('plugin/qu_app', 'weixinlogin'), 'login_weixin', $forum_Arr['login_weixin'], 'text','','',$langvars['login_weixin_tip']);
	//showsetting(lang('plugin/qu_app', 'weibologin'), 'login_weibo', $forum_Arr['login_weibo'], 'text','','',$langvars['login_weibo_tip']);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$newdata = array(  
		"login_qq" => $_GET['login_qq'],
		"login_weixin" => $_GET['login_weixin'],
		//"login_weibo" => $_GET['login_weibo']
	); 
	DB::update('qu_app', $newdata);
	@include_once DISCUZ_ROOT.'./source/plugin/qu_app/config.php';
	cpmsg('plugins_setting_succeed', 'action=plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=login', 'succeed');
}

?>

