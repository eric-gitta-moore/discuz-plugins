<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
loadcache('plugin');
$langvars=lang('plugin/qu_app');
if(!submitcheck('submit')){
	include_once libfile('function/forumlist');
	$forumdisplay_Arr = DB::fetch_all("SELECT * from ".DB::table('qu_app')."");
	foreach($forumdisplay_Arr as $forum_Arr){
		$forum_Arr[] = $forumdisplay_Arr;
	}
	//新闻风格
	$forum_Arr['f_news'] = dunserialize($forum_Arr['f_news']);
	$forum_Arr['f_news'] = is_array($forum_Arr['f_news']) ? $forum_Arr['f_news'] : array();
	$forumselect_news = '<select name="f_news[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_news']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_news'], TRUE).'</select>';
	
	//圈子风格
	$forum_Arr['f_quan'] = dunserialize($forum_Arr['f_quan']);
	$forum_Arr['f_quan'] = is_array($forum_Arr['f_quan']) ? $forum_Arr['f_quan'] : array();
	$forumselect_quan = '<select name="f_quan[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_quan']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_quan'], TRUE).'</select>';
	
	//图文风格
	$forum_Arr['f_tuwen'] = dunserialize($forum_Arr['f_tuwen']);
	$forum_Arr['f_tuwen'] = is_array($forum_Arr['f_tuwen']) ? $forum_Arr['f_tuwen'] : array();
	$forumselect_tuwen = '<select name="f_tuwen[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_tuwen']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_tuwen'], TRUE).'</select>';
	
	//QQ空间风格
	$forum_Arr['f_qqzone'] = dunserialize($forum_Arr['f_qqzone']);
	$forum_Arr['f_qqzone'] = is_array($forum_Arr['f_qqzone']) ? $forum_Arr['f_qqzone'] : array();
	$forumselect_qqzone = '<select name="f_qqzone[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_qqzone']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_qqzone'], TRUE).'</select>';
	
	//微博风格
	$forum_Arr['f_weibo'] = dunserialize($forum_Arr['f_weibo']);
	$forum_Arr['f_weibo'] = is_array($forum_Arr['f_weibo']) ? $forum_Arr['f_weibo'] : array();
	$forumselect_weibo = '<select name="f_weibo[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_weibo']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_weibo'], TRUE).'</select>';
	
	//大图风格
	$forum_Arr['f_bigpic'] = dunserialize($forum_Arr['f_bigpic']);
	$forum_Arr['f_bigpic'] = is_array($forum_Arr['f_bigpic']) ? $forum_Arr['f_bigpic'] : array();
	$forumselect_bigpic = '<select name="f_bigpic[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_bigpic']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_bigpic'], TRUE).'</select>';
	
	//瀑布流风格
	$forum_Arr['f_pbl'] = dunserialize($forum_Arr['f_pbl']);
	$forum_Arr['f_pbl'] = is_array($forum_Arr['f_pbl']) ? $forum_Arr['f_pbl'] : array();
	$forumselect_pbl = '<select name="f_pbl[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_pbl']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_pbl'], TRUE).'</select>';
	
	//视频风格
	$forum_Arr['f_video'] = dunserialize($forum_Arr['f_video']);
	$forum_Arr['f_video'] = is_array($forum_Arr['f_video']) ? $forum_Arr['f_video'] : array();
	$forumselect_video = '<select name="f_video[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_video']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_video'], TRUE).'</select>';
	
	//音频风格
	$forum_Arr['f_music'] = dunserialize($forum_Arr['f_music']);
	$forum_Arr['f_music'] = is_array($forum_Arr['f_music']) ? $forum_Arr['f_music'] : array();
	$forumselect_music = '<select name="f_music[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_music']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_music'], TRUE).'</select>';
	
	//商品风格
	$forum_Arr['f_trade'] = dunserialize($forum_Arr['f_trade']);
	$forum_Arr['f_trade'] = is_array($forum_Arr['f_trade']) ? $forum_Arr['f_trade'] : array();
	$forumselect_trade = '<select name="f_trade[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_trade']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_trade'], TRUE).'</select>';
	
	//投票风格
	$forum_Arr['f_poll'] = dunserialize($forum_Arr['f_poll']);
	$forum_Arr['f_poll'] = is_array($forum_Arr['f_poll']) ? $forum_Arr['f_poll'] : array();
	$forumselect_poll = '<select name="f_poll[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_poll']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_poll'], TRUE).'</select>';
	
	//活动风格
	$forum_Arr['f_activity'] = dunserialize($forum_Arr['f_activity']);
	$forum_Arr['f_activity'] = is_array($forum_Arr['f_activity']) ? $forum_Arr['f_activity'] : array();
	$forumselect_activity = '<select name="f_activity[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_activity']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_activity'], TRUE).'</select>';
	
	//辩论风格
	$forum_Arr['f_debate'] = dunserialize($forum_Arr['f_debate']);
	$forum_Arr['f_debate'] = is_array($forum_Arr['f_debate']) ? $forum_Arr['f_debate'] : array();
	$forumselect_debate = '<select name="f_debate[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_debate']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_debate'], TRUE).'</select>';
	
	//悬赏风格
	$forum_Arr['f_reward'] = dunserialize($forum_Arr['f_reward']);
	$forum_Arr['f_reward'] = is_array($forum_Arr['f_reward']) ? $forum_Arr['f_reward'] : array();
	$forumselect_reward = '<select name="f_reward[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_reward']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_reward'], TRUE).'</select>';
	
	//智能风格
	$forum_Arr['f_zhineng'] = dunserialize($forum_Arr['f_zhineng']);
	$forum_Arr['f_zhineng'] = is_array($forum_Arr['f_zhineng']) ? $forum_Arr['f_zhineng'] : array();
	$forumselect_zhineng = '<select name="f_zhineng[]" multiple="multiple" size="10"><option value="0"'.(in_array(0, $forum_Arr['f_zhineng']) ? ' selected' : '').'>'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $forum_Arr['f_zhineng'], TRUE).'</select>';
	
	
	showformheader('plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=forumdisplay', 'submit');
	showtableheader(lang('plugin/qu_app', 'setting'));
	echo '<input type="hidden" name="formhash" value="'.FORMHASH.'">';
	
	showsetting($langvars['f_zhineng'], '', '', $forumselect_zhineng);
	showsetting($langvars['f_news'], '', '', $forumselect_news);
	showsetting($langvars['f_quan'], '', '', $forumselect_quan);
	showsetting($langvars['f_tuwen'], '', '', $forumselect_tuwen);
	showsetting($langvars['f_qqzone'], '', '', $forumselect_qqzone);
	showsetting($langvars['f_weibo'], '', '', $forumselect_weibo);
	showsetting($langvars['f_bigpic'], '', '', $forumselect_bigpic);
	showsetting($langvars['f_pbl'], '', '', $forumselect_pbl);
	showsetting($langvars['f_video'], '', '', $forumselect_video);
	showsetting($langvars['f_music'], '', '', $forumselect_music);
	showsetting($langvars['f_trade'], '', '', $forumselect_trade);
	showsetting($langvars['f_poll'], '', '', $forumselect_poll);
	showsetting($langvars['f_activity'], '', '', $forumselect_activity);
	showsetting($langvars['f_debate'], '', '', $forumselect_debate);
	showsetting($langvars['f_reward'], '', '', $forumselect_reward);
	//showsetting($langvars['f_wordnum'], 'f_wordnum', $forum_Arr['f_wordnum'], 'text','','',$langvars['tip_wordnum']);
	
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$newdata = array(  
		"f_news" => serialize($_GET['f_news']),
		"f_quan" => serialize($_GET['f_quan']),
		"f_tuwen" => serialize($_GET['f_tuwen']),
		"f_qqzone" => serialize($_GET['f_qqzone']),
		"f_weibo" => serialize($_GET['f_weibo']),
		"f_bigpic" => serialize($_GET['f_bigpic']),
		"f_pbl" => serialize($_GET['f_pbl']),
		"f_video" => serialize($_GET['f_video']),
		"f_music" => serialize($_GET['f_music']),
		"f_trade" => serialize($_GET['f_trade']),
		"f_poll" => serialize($_GET['f_poll']),
		"f_activity" => serialize($_GET['f_activity']),
		"f_debate" => serialize($_GET['f_debate']),
		"f_reward" => serialize($_GET['f_reward']),
		"f_zhineng" => serialize($_GET['f_zhineng']),
		//"f_wordnum" => $_GET['f_wordnum']
	); 
	DB::update('qu_app', $newdata);
	@include_once DISCUZ_ROOT.'./source/plugin/qu_app/config.php';
	@include_once DISCUZ_ROOT.'./source/plugin/qu_app/c/cache.php';
	cpmsg('plugins_setting_succeed', 'action=plugins&operation=config&do='.$pluginid.'&identifier=qu_app&pmod=forumdisplay', 'succeed');
}

?>

