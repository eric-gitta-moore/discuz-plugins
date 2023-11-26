<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id:$
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class pick_cron
{

	function run($pid = 0) {

		global $_G;
		$timestamp = TIMESTAMP;
		save_syscache('pick_run', TIMESTAMP + 300);
		$cron = DB::fetch_first("SELECT lastrun,nextrun,pid,cron_minute,cron_hour,cron_day,cron_weekday FROM ".DB::table('strayer_picker')." WHERE is_auto_pick>'0' AND nextrun<='$timestamp' ORDER BY nextrun LIMIT 1");
		if($cron['cron_day'] == 0) $cron['cron_day'] = -1;
		$processname ='PICK_CRON_'.(empty($pid) ? 'CHECKER' : $cron['pid']);
		if($pid && !empty($cron)) {
			discuz_process::unlock($processname);
		}
		if(discuz_process::islocked($processname, 600)) {
			return false;
		}
		if($cron['pid']) {
			require_once(PICK_DIR.'/lib/pick.class.php');
			
			$cron['cron_minute'] = explode(",", $cron['cron_minute']);
			pick_cron::setnextime($cron);
			@set_time_limit(1000);
			@ignore_user_abort(TRUE);
			$pick = new pick($cron['pid'], 1);
			$pick->run_start();
		}
		pick_cron::nextcron();
		discuz_process::unlock($processname);
		return true;
	}
	
	//定时发布文章
	function run_timing($a){
		global $_G;
		$timestamp = TIMESTAMP;
		$processname ='TIMING_CRON_CHECK';
		$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_timing')." WHERE public_dateline<='$timestamp' "), 0);	
		if($check) discuz_process::unlock($processname);
		if(discuz_process::islocked($processname, 600)) {
			return false;
		}
		if(!$check) return FALSE;
	
		@set_time_limit(1000);
		@ignore_user_abort(TRUE);
		//防止发生异常，先预订一个1小时的总时间,假如发布文章需要2小时才完成。还未到2小时，又被触发了，这样会造成文章的重复发布
		save_syscache('pick_timing', TIMESTAMP + 60*60*1);
		
		$optype_arr = array(1 => 'move_portal', 2 => 'move_forums', 3 => 'move_blog'); 
		$query = DB::query("SELECT * FROM ".DB::table('strayer_timing')." WHERE public_dateline<='$timestamp' ORDER by public_dateline");
		$timing_aid_arr = $tid_arr = $args = array();
		while($rs = DB::fetch($query)) {
			$timing_aid_arr[]  = dstripslashes($rs);
			$tid_arr[] = $rs['id'];
		}
		if(!$timing_aid_arr) return;
		pload('F:article,F:pick');
		article_timing_delete($tid_arr);//不管有没有发布成功，先清理掉定时发布表里面的数据，防止文章又被重复检测到
		foreach($timing_aid_arr as $k => $rs){
			$args = unserialize($rs['public_info']);
			$args['aid'] = array($rs['data_id']);
			$args['pid'] = $rs['pid'];
			$args['timing'] = 1;
			$args['cron_run'] = 1;
			$args['public_time'][$rs['data_id']] = $rs['public_dateline'];
			article_import($optype_arr[$rs['public_type']], $args);
		}
		save_syscache('pick_timing', TIMESTAMP + 600);//成功运行，时间按正常设置
		discuz_process::unlock($processname);
		return true;
	}

	function nextcron() {
		$nextrun = DB::result_first("SELECT nextrun FROM ".DB::table('strayer_picker')." WHERE is_auto_pick>'0' ORDER BY nextrun LIMIT 1");
		save_syscache('pick_run', TIMESTAMP + 300);
		return;
		if($nextrun !== FALSE) {
			save_syscache('pick_cronnextrun', $nextrun);
		} else {
			save_syscache('pick_cronnextrun', TIMESTAMP + 86400 * 365);
		}
		return true;
	}

	function setnextime($cron) {

		global $_G;

		if(empty($cron)) return FALSE;

		list($yearnow, $monthnow, $daynow, $weekdaynow, $hournow, $minutenow) = explode('-', gmdate('Y-m-d-w-H-i', TIMESTAMP + $_G['setting']['timeoffset'] * 3600));

		if($cron['cron_weekday'] == -1) {
			if($cron['cron_day'] == -1) {
				$firstday = $daynow;
				$secondday = $daynow + 1;
			} else {
				$firstday = $cron['cron_day'];
				$secondday = $cron['cron_day'] + gmdate('t', TIMESTAMP + $_G['setting']['timeoffset'] * 3600);
			}
		} else {
			$firstday = $daynow + ($cron['cron_weekday'] - $weekdaynow);
			$secondday = $firstday + 7;
		}

		if($firstday < $daynow) {
			$firstday = $secondday;
		}

		if($firstday == $daynow) {
			
			$todaytime = pick_cron::todaynextrun($cron);
			if($todaytime['cron_hour'] == -1 && $todaytime['cron_minute'] == -1) {
				$cron['cron_day'] = $secondday;
				$nexttime = pick_cron::todaynextrun($cron, 0, -1);
				$cron['cron_hour'] = $nexttime['cron_hour'];
				$cron['cron_minute'] = $nexttime['cron_minute'];
			} else {
				$cron['cron_day'] = $firstday;
				$cron['cron_hour'] = $todaytime['cron_hour'];
				$cron['cron_minute'] = $todaytime['cron_minute'];
				$cron['cron_minute'] = $cron['cron_minute'] > 0 ? $cron['cron_minute'] : 0;
			}
		} else {
			$cron['cron_day'] = $firstday;
			$nexttime = pick_cron::todaynextrun($cron, 0, -1);
			$cron['cron_hour'] = $nexttime['cron_hour'];
			$cron['cron_minute'] = $nexttime['cron_minute'];
		}

		$nextrun = @gmmktime($cron['cron_hour'], $cron['cron_minute'] > 0 ? $cron['cron_minute'] : 0, 0, $monthnow, $cron['cron_day'], $yearnow) - $_G['setting']['timeoffset'] * 3600;

		DB::query("UPDATE ".DB::table('strayer_picker')." SET lastrun='$_G[timestamp]', nextrun='$nextrun'  WHERE pid='$cron[pid]'");

		return true;
	}

	function todaynextrun($cron, $hour = -2, $minute = -2) {
		global $_G;

		$hour = $hour == -2 ? gmdate('H', TIMESTAMP + $_G['setting']['timeoffset'] * 3600) : $hour;
		$minute = $minute == -2 ? gmdate('i', TIMESTAMP + $_G['setting']['timeoffset'] * 3600) : $minute;

		$nexttime = array();
		if($cron['cron_hour'] == -1 && !$cron['cron_minute']) {
			$nexttime['cron_hour'] = $hour;
			$nexttime['cron_minute'] = $minute + 1;
		} elseif($cron['cron_hour'] == -1 && $cron['cron_minute'] != '') {
			$nexttime['cron_hour'] = $hour;
			if(($nextminute = pick_cron::nextminute($cron['cron_minute'], $minute)) === false) {
				++$nexttime['cron_hour'];
				$nextminute = $cron['cron_minute'][0];
			}
			$nexttime['cron_minute'] = $nextminute;
		} elseif($cron['cron_hour'] != -1 && $cron['cron_minute'] == '') {
			if($cron['cron_hour'] < $hour) {
				$nexttime['cron_hour'] = $nexttime['cron_minute'] = -1;
			} elseif($cron['cron_hour'] == $hour) {
				$nexttime['cron_hour'] = $cron['cron_hour'];
				$nexttime['cron_minute'] = $minute + 1;
			} else {
				$nexttime['cron_hour'] = $cron['cron_hour'];
				$nexttime['cron_minute'] = 0;
			}
		} elseif($cron['cron_hour'] != -1 && $cron['cron_minute'] != '') {
			$nextminute = pick_cron::nextminute($cron['cron_minute'], $minute);
			if($cron['cron_hour'] < $hour || ($cron['cron_hour'] == $hour && $nextminute === false)) {
				$nexttime['cron_hour'] = -1;
				$nexttime['cron_minute'] = -1;
			} else {
				$nexttime['cron_hour'] = $cron['cron_hour'];
				$nexttime['cron_minute'] = $nextminute;
			}
		}

		return $nexttime;
	}

	function nextminute($nextminutes, $minutenow) {
		foreach($nextminutes as $nextminute) {
			if($nextminute > $minutenow) {
				return $nextminute;
			}
		}
		return false;
	}
}

?>