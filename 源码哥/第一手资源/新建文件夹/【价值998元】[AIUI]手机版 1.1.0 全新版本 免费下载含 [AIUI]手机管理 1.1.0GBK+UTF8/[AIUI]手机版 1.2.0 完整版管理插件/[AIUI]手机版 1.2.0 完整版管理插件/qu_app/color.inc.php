<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
loadcache('plugin');
$langvars=lang('plugin/qu_app');
if(!submitcheck('submit')){
	$forumdisplay_Arr = DB::fetch_all("SELECT * from ".DB::table('qu_app')."");
	foreach($forumdisplay_Arr as $forum_Arr){$forum_Arr[] = $forumdisplay_Arr;}
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=color', 'submit');
	showtableheader(lang('plugin/qu_app', 'setting'));
	echo '<input type="hidden" name="formhash" value="'.FORMHASH.'">';
	

	//导航顶部背景颜色
	showsetting(lang('plugin/qu_app', 'topbgcolor'), 'color_topbg', $forum_Arr['color_topbg'], 'color');
	
	//导航顶部文字颜色
	showsetting(lang('plugin/qu_app', 'topwordcolor'), 'color_topword', $forum_Arr['color_topword'], 'color');
	
	//顶部导航下划线颜色
	showsetting(lang('plugin/qu_app', 'toplinecolor'), 'color_topline', $forum_Arr['color_topline'], 'color');
	
	//底部导航高亮颜色
	showsetting(lang('plugin/qu_app', 'bottomcolor'), 'color_wordbottom', $forum_Arr['color_wordbottom'], 'color');
	
	//个人中心顶部背景颜色
	//showsetting(lang('plugin/qu_app', 'usertopbgcolor'), 'color_userbgcolor', $forum_Arr['color_userbgcolor'], 'color');
	
	//全局页内高亮文字颜色
	showsetting(lang('plugin/qu_app', 'linkcolor'), 'color_link', $forum_Arr['color_link'], 'color');
	
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$newdata = array(  
		"color_topbg" => $_GET['color_topbg'],
		"color_topword" => $_GET['color_topword'],
		"color_topline" => $_GET['color_topline'],
		"color_wordbottom" => $_GET['color_wordbottom'],
		//"color_userbgcolor" => $_GET['color_userbgcolor'],
		"color_link" => $_GET['color_link'],
	); 
	DB::update('qu_app', $newdata);
	@include_once DISCUZ_ROOT.'./source/plugin/qu_app/config.php';
	cpmsg('plugins_setting_succeed', 'action=plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=color', 'succeed');
}

?>

