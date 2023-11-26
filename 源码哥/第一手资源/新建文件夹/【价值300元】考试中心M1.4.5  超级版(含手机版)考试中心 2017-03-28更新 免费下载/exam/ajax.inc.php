<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


	require_once "tiny.common.inc.php";
	
	if ($_GET['formhash'] != formhash()) {
		exit('Access Denied');
	}
	
	$action= !isset($_GET['action']) ? '' : $_GET['action'];
	$wu =  $_G['groupid']==1 ? '' : "AND `uid`='".$_G['uid']."'";
 
	if($action=='user_exam_set_display'){
		$eid     = !isset($_GET['eid']) ? 0 : intval($_GET['eid']);
		$display = DB::result_first('select `display` from '.DB::table('tiny_exam3_exam')." where `eid`='$eid' $wu");
		$display = $display ? '0' : '1';
 
		DB::query('update '.DB::table('tiny_exam3_exam')." set `display`='$display' where `eid`='$eid' $wu");
		
		include template('common/header_ajax');
		echo $display;
		include template('common/footer_ajax');
	}
	else if($action=='user_exam_delete'){
		$eid  = !isset($_GET['eid']) ? 0 : intval($_GET['eid']);
		$status = DB::query('delete from '.DB::table('tiny_exam3_exam')." where `eid`='$eid' $wu");
		DB::query("update ".DB::table('tiny_exam3_upload')." SET `eid`='0' where `eid`='$eid' $wu");
		include template('common/header_ajax');
		echo $status=1;
		include template('common/footer_ajax');
	}
	else if($action=='user_show_exam_note'){
		$eid  = !isset($_GET['eid']) ? 0 : intval($_GET['eid']);
		$exam = DB::fetch_first('select `subject`,`note` from '.DB::table('tiny_exam3_exam')." where `eid`='$eid'");
		$exam['note'] =  dzcode($exam['note']);
		include template("exam:$template/common/show_note");
	}
	else if($action=='user_paper_payfor'){
		include template('common/header_ajax');
		$pid  =  intval($_GET['pid']);
		if(!$_G['uid']){
			echo 'nologin';
		}else{
			$pp = DB::fetch_first("SELECT `price`,`long` FROM " .DB::table('tiny_exam3_paper'). " WHERE `pid`='$pid'");
			echo payfor($pid, $_G['uid'], $pp['price'], $pp['long']);
		}
		include template('common/footer_ajax');
	}

	

