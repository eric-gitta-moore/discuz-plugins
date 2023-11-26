<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
pload('F:copyright,F:output');
$head_url = '?'.PICK_GO.'fast_pick&myac=';
$myac = $_GET['myac'];
$tpl = $_GET['tpl'];
if(empty($myac)) $myac = 'virtualdata_set';

if(function_exists($myac)) $info = $myac();
$mytemp = $_REQUEST['mytemp'] ? $_REQUEST['mytemp'] : $myac;

if(!$tpl && $tpl!= 'no') include template('milu_pick:'.$mytemp);


function virtualdata_set(){
	global $head_url,$header_config;
	if(!submitcheck('submit')) {
		require_once libfile('function/forumlist');
		$info = pick_common_get();
		$info['vir_cache_time'] = $info['vir_cache_time'] ? $info['vir_cache_time'] : 10;
		$info['vir_data_forum'] = unserialize($info['vir_data_forum']);
		$info['vir_data_usergroup'] = unserialize($info['vir_data_usergroup']);
		$info['forumselect'] = '<select name="set[vir_data_forum][]" size="10" multiple="multiple"><option value="">'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $info['vir_data_forum'], TRUE).'</select>';
		return $info;
	}else{
		$set = $_GET['set'];
		if(!$set['vir_data_forum'][0] && count($set['vir_data_forum']) == 1) $set['vir_data_forum'] = '';
		pick_common_set($set);
		save_syscache('milu_pick_vir_postdata', '');
		save_syscache('milu_pick_vir_data', '');
		save_syscache('milu_pick_vir_online', '');
		cpmsg(milu_lang('op_success'), PICK_GO."virtual_data", 'succeed');	
	}
}
?>