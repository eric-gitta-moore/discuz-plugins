<?php
if(!defined('IN_DISCUZ') ) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
pload('F:pick,F:copyright,F:output');
if($_GET['pid']){
	$info = get_pick_info();
	$info = show_pick_format($info);
}else{
	num_limit('strayer_picker', 3000, 'p_num_limit');
}
if($_GET['turn_type']){
	$info = get_trun_data();
	$info['rules_type'] = 2;
	$info['theme_url_test'] = $info['theme_url_test'] ? $info['theme_url_test'] : $info['detail_ID_test'];
}
$step = $_GET['step'];
if(!$step) $step = 1;
$info['time_out'] = $pick_config['time_out'];
include_once libfile('function/portalcp');
require_once libfile('function/forumlist');
$threadtypes = getthreadtypes(array('typeid' => $info['public_class'][1], 'fid' => $info['public_class'][0]) );
$forumselect = '<select id="forums" name="forums" onchange="getthreadtypes(this.value, 0)">'.forumselect(FALSE, 0, $info['public_class'][0], TRUE).'</select>';
$portalselect = category_showselect('portal', 'portal', FALSE, $info['public_class'][0]);
$blogselect = category_showselect('blog', 'blog', TRUE, $info['public_class'][0]);
$show_bottom_js = bottom_js_output($info);
$info['pick_cid'] = $info['pick_cid'] ? $info['pick_cid'] : intval($_GET['pick_cid']);
if($_GET['editsubmit']){
	$setarr = $_POST['set'];
	$setarr = dstripslashes($setarr);
	//if($_GET['time_public'] == 1) $setarr['public_start_time'] = $setarr['public_end_time'] = '';
	$setarr['rules_var'] = serialize($_GET['rules_var']);
	$setarr['content_filter_html'] = serialize($_GET['content_filter_html']);
	$setarr['reply_filter_html'] = serialize($_GET['reply_filter_html']);
	$setarr['many_page_list'] = serialize($_GET['many_page_list']);
	$setarr['title_filter_rules'] = serialize($_GET['title_filter_rules']);
	$setarr['content_filter_rules'] = serialize($_GET['content_filter_rules']);
	$setarr['reply_filter_rules'] = serialize($_GET['reply_filter_rules']);
	$strtotime_public_start_time = strtotime($setarr['public_start_time']);
	$time_pre = '1234321';//这是代表 - 符号
	$setarr['public_start_time'] = intval($setarr['public_start_time']);
	if($setarr['public_start_time'] < 0){
		$setarr['public_start_time'] = $time_pre.abs($setarr['public_start_time']);
	}else{
		$setarr['public_start_time'] = !$strtotime_public_start_time && $setarr['public_start_time'] ? $setarr['public_start_time'] : $strtotime_public_start_time;
	}
	$strtotime_public_end_time = strtotime($setarr['public_end_time']);
	$setarr['public_end_time'] = !$strtotime_public_end_time && $setarr['public_end_time'] ? $setarr['public_end_time'] : $strtotime_public_end_time;
	$setarr['public_uid_group'] = serialize($setarr['public_uid_group']);
	$setarr['reply_uid_group'] = serialize($setarr['reply_uid_group']);
	//print_r($setarr);exit();
	if($setarr['public_type'] == 1){
		$setarr['public_class'][0] = intval($_GET['portal']);
	}else if($setarr['public_type'] == 2){
		$setarr['public_class'][0] = intval($_GET['forums']);
		$setarr['public_class'][1] = intval($_GET['threadtypeid']);
	}else if($setarr['public_type'] == 3){
		$setarr['public_class'][0] = intval($_GET['blog']);
	}
	$setarr['public_class'] = serialize($setarr['public_class']);
	if(empty($setarr['name'])) cpmsg_error(milu_lang('pick_name_no_empty'));
	if($_GET['pid'] && $_GET['add'] != 'copy'){
		$pid = $_GET['pid'] ;
		if(empty($setarr['rules_hash'])) $setarr['rules_hash'] = '';
		if(empty($setarr['page_url_auto'])) $setarr['page_url_auto'] = 0;
		$msg = milu_lang('modify');
		if(empty($setarr['reply_is_extend'])) $setarr['reply_is_extend'] = 0;
		$setarr = paddslashes($setarr);
		$data_info = get_pick_info();
		if($data_info['cron_day'] == 0) $data_info['cron_day'] = -1;//数据库中的字段类型为未签署，导致没法小于0
		if($data_info['cron_minute'] != $setarr['cron_minute'] || $data_info['cron_hour'] != $setarr['cron_hour'] || $data_info['cron_day'] != $setarr['cron_day'] || $data_info['cron_weekday'] != $setarr['cron_weekday']){//计划任务修改时，把下次执行时间清空
			save_syscache('pick_run', TIMESTAMP);
			$setarr['lastrun'] = $setarr['nextrun'] = 0;
		}
		DB::update('strayer_picker', $setarr, array('pid' => $pid));
		$url = PICK_GO.'picker_manage';
	}else{
		$msg = milu_lang('add');
		$setarr = paddslashes($setarr);
		$setarr['picker_hash'] = create_hash();
		$pid = DB::insert('strayer_picker', $setarr, TRUE);
	}
	$url = PICK_GO.'picker_manage&myaction=edit_pick&pid='.$pid.'&step='.$_GET['step'];
	if(!$pid) cpmsg_error($msg.milu_lang('fail'));
	cpmsg(milu_lang('pick_op_finsh', array('msg' => $msg)), $url, 'succeed');
}
if(!$info['jump_num'])  $info['jump_num'] = $pick_config['pick_num'];
include template('milu_pick:picker_edit');
?>