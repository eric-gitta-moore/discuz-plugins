<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
 	require_once 'tiny.common.inc.php';
	
	if(!$include_pg){
		header('Location: ./plugin.php?id=exam');
		exit;
	}
 
	$uid = $_G['uid'];

	$pid = isset($_GET['cid']) ? intval($_GET['cid']) : (isset($_GET['paper']) ? intval($_GET['paper']) : intval($_GET['test']));
 
	//未找到该套试卷!
	$paper = C::t('#exam#tiny_exam3_paper')->get_paper_info($pid);

	if(empty($paper)){
		showmessage( "&#x672A;&#x627E;&#x5230;&#x8BE5;&#x5957;&#x8BD5;&#x5377;!", "plugin.php?id=exam");
	}
  
	if($_G['adminid']!=1 && $paper['uid']!=$uid && ($paper['status']==0 || $paper['public']==0)){
		showmessage( "&#26080;&#26435;&#38480;!", "plugin.php?id=exam");
	}

	//权限判断=================================================================
	$checkPaperStatus = checkPaper($paper, $uid);
	$lid = isset($_GET['replay']) ? intval($_GET['replay']) : 0;
	
	if($checkPaperStatus===true)
	{
		//试卷中题目列表
		$groups = C::t('#exam#tiny_exam3_paper')->fetch_exam_by_pid($pid);
		
		//缓存到文件------------------------------------------------------------------------------------
		/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */
		//缓存到文件------------------------------------------------------------------------------------
		
		$paper['total_score']= C::t('#exam#tiny_exam3_paper')->get_score($pid);
		$paper['twice_did']  = C::t('#exam#tiny_exam3_log')->value('count(*)', $uid, $pid);	//做过次数
		$paper['twice_left'] = $paper['twice_left'] - $paper['twice_did'] ;	//剩余次数
	 
		//回放
		if($lid){
			$history = DB::fetch_all("SELECT eid,result AS user_result, score AS user_score FROM %t where lid='$lid' AND uid='$uid'", array('tiny_exam3_log_exam'), 'eid');
	 
		}
 
		//PV统计
		C::t('#exam#tiny_exam3_paper')->set_count($pid);

		//试卷中无试题!
		if(empty($groups))$checkPaperStatus = 'empty';
		
		//考生信息
		if($config['userinfo']){
			if($uid){
				$userinfo=DB::result_first("SELECT userinfo FROM %t where uid='$uid' order by lid DESC", array('tiny_exam3_log'));
			}
			$userinfo = empty($userinfo) ? array() : explode("\n", $userinfo);
			$userinfofield = explode(",", $config['userinfo']);
		}
	}
 
	$navtitle		= $paper['title'];
	$metakeywords	= $paper['title'];
	$metadescription= empty($paper['content']) ? $paper['title'] : dhtmlspecialchars(strip_tags(str_replace('"','\'',$paper['content'])));
	
	//限制连接数-----------------------
	$queuelock = false;
	if($config['queue_user'] && $lid==0){
		$queuetime = $_SERVER['REQUEST_TIME'] - 60 * 10;//10分钟
		$queuenum = DB::result_first("select count(*) from %t where `endtime`>'%d'", array('tiny_exam3_log', $waittime));
		if($queuenum > $config['queue_user']){
			$queuelock = true;
		}
	}
	//限制连接数-----------------------
	//print_r($paper);
	//print_r($groups);

	include template("exam:$template/paper");
