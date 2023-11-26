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
include 'tiny.common.inc.php';
 
//判断是否登录
if(!$_G['uid'])showmessage('to_login', null, array(), array('showmsg' => true, 'login' => 1));

 
 
$perpage = 20;
$tab     = $_GET['tab'];
$page    = intval($_GET['page']);
$uid     = $_G['uid'];
$action  = $_GET['action'];
$pid     = intval($_GET['pid']);
$all     = intval($_GET['all']);


if($tab == 'wrong')
{
	if($action=='wrong_delete' && $_GET['formhash'] == formhash())
	{
		$w = $all ? '' : "wid in (%n) AND";
		DB::query("delete from %t where $w uid='$uid'", array('tiny_exam3_wrong', $_POST['moderate']));
		header("location: plugin.php?id=exam:my&tab=wrong&page=$page");
		exit;
	}
 
	$total  = DB::result_first("SELECT count(*) FROM %t WHERE uid='$uid' order by  wid desc", array('tiny_exam3_wrong'), 'wid');
	$wrongs = DB::fetch_all("SELECT W.*,E.subject FROM %t AS W LEFT JOIN %t AS E ON W.eid=E.eid  WHERE W.uid='$uid' order by W.wid desc limit %d,%d", array('tiny_exam3_wrong','tiny_exam3_exam',(max($page, 1)-1)*$perpage, $perpage),  'wid');

	$multipage =  multi($total, $perpage, $page, "plugin.php?id=exam:my&tab=wrong",10,10);
 
}
else if($tab == 'paper')
{
	$paper = C::t('#exam#tiny_exam3_paper')->get_paper_info($pid);
 
	if($action=='cp_comment' && $_GET['formhash'] == formhash())
	{
		$lid = intval($_POST['comment_lid']);
		$comment = $_POST['comment'];
		if($lid && $comment){
			$comment = daddslashes(dhtmlspecialchars($comment));
			DB::query("update %t AS L,%t AS P set L.`comment`='$comment', L.`commenttime`='".time()."' where L.lid='$lid' and L.pid=P.pid and P.uid='$uid'", array('tiny_exam3_log', 'tiny_exam3_paper'));
		}
		header("location: plugin.php?id=exam:my&tab=paper&pid=$pid&page=$page#a_$lid");
		exit;
	}
	else if($action=='cp_delete' && $_GET['formhash'] == formhash())
	{
		$w = $all ? '' : "and lid in(%n)";
	
		if(DB::result_first("SELECT count(*) FROM %t where pid='$pid' AND uid='$uid'", array('tiny_exam3_paper'))){
			DB::query("delete from %t where pid='$pid' $w", array('tiny_exam3_log', $_POST['moderate']));
		}

		header("location: plugin.php?id=exam:my&tab=paper&pid=$pid&page=$page");
		exit;
	}
	else if($action == 'cp_export' && $_GET['formhash'] == formhash())
	{
		$w =  $all ? '' : "L.lid in(%n) and";
		$lm = $all ? '' : "limit %d,%d";

		//$logs = DB::fetch_all("SELECT L.*,P.pass,P.uid AS authorid,P.username AS author,M.username FROM %t AS L LEFT JOIN %t AS P ON L.pid=P.pid LEFT JOIN %t AS M ON L.uid=M.uid WHERE L.pid='$pid' and (P.uid='$uid' || P.uid='0') $wp order by $os L.`lid` desc limit %d,%d", array('tiny_exam3_log', 'tiny_exam3_paper', 'common_member' , (max($page, 1)-1)*$perpage, $perpage), 'lid');
		$logs = DB::fetch_all("SELECT L.*,P.pass,P.uid AS authorid,P.username AS author,M.username FROM %t AS L LEFT JOIN %t AS P ON L.pid=P.pid LEFT JOIN %t AS M ON L.uid=M.uid WHERE L.pid='$pid' and (P.uid='$uid' || P.uid='0') $wp order by $os L.`lid` desc $lm", array('tiny_exam3_log', 'tiny_exam3_paper', 'common_member' , (max($page, 1)-1)*$perpage, $perpage), 'lid');
			
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=\"$paper[title].csv\"");
		if(empty($logs))echo "ERROR".date("Y-m-d H:i:s");
		$output = '';
		$cfguserinfo = explode(",", $config['userinfo']);
		$cfguicount = count($cfguserinfo);
		
		foreach($logs AS $log){
			$bPass = $log['score'] >= $log['pass'] ? 'YES' : 'NO';
			$output .= $log['username'] . ',' . $log['score'] . ',' . $bPass;
			$uinfo = explode("\n", $log['userinfo']);
			for($i=0; $i<$cfguicount; $i++){
				$output .= ",\"'". str_replace('"','""',$uinfo[$i]) ."\"";
			}
			$output .= ',' . date("Y-m-d H:i:s", $log['endtime']);
			$output .= "\n";
		}
	 
		$numss = "Name, Score, Pass ";
		foreach($cfguserinfo AS $v){
			$numss .= ','. $v;
		}
		$numss .= ", Time";
		echo $numss."\n".$output;
		exit;
	}
	$total = DB::result_first("SELECT count(*) FROM %t AS L,%t AS P WHERE L.pid='$pid' and L.pid=P.pid and P.uid='$uid'", array('tiny_exam3_log','tiny_exam3_paper'));
	if($total){
		$_pass  = intval($_GET['_pass']);
		$_score = intval($_GET['_score']);
		$wp = $_pass >0 ? 'and L.score>=P.pass' : ($_pass <0 ? 'and L.score<P.pass' : '');
		$os = $_score>0 ? 'L.score asc,'       : ($_score<0 ? 'L.score desc,' : '');
			
		//$logs = DB::fetch_all("SELECT L.*,P.pass,P.uid AS authorid,P.username AS author,M.username FROM %t AS P,%t AS L LEFT JOIN %t AS M ON L.uid=M.uid WHERE L.pid='$pid' and L.pid=P.pid and (P.uid='$uid' || P.uid='0') $wp order by $os L.`lid` desc limit %d,%d", array('tiny_exam3_paper','tiny_exam3_log',  'common_member' , (max($page, 1)-1)*$perpage, $perpage), 'lid');
		$logs = DB::fetch_all("SELECT L.*,P.pass,P.uid AS authorid,P.username AS author,M.username FROM %t AS L LEFT JOIN %t AS P ON L.pid=P.pid LEFT JOIN %t AS M ON L.uid=M.uid WHERE L.pid='$pid' and (P.uid='$uid' || P.uid='0') $wp order by $os L.`lid` desc limit %d,%d", array('tiny_exam3_log', 'tiny_exam3_paper', 'common_member' , (max($page, 1)-1)*$perpage, $perpage), 'lid');
		$multipage =  multi($total, $perpage, $page, "plugin.php?id=exam:my&tab=paper&pid=$pid",10,10);
	}

}
elseif($tab == 'logs')
{
		if($_GET['action']){
			$lid    = intval($_GET['lid']);
 	
			if($action=='replay'){
				$pid = DB::result_first("SELECT pid FROM ".DB::table('tiny_exam3_log')." where lid='$lid' AND uid='$uid'");
				$_G['uid'] ? header("location: plugin.php?id=exam&paper=$pid&replay=$lid") : header("location: $paperurl$pid.html");
				exit;
			}else if($action=='redo'){
				$pid = DB::result_first("SELECT pid FROM ".DB::table('tiny_exam3_log')." where lid='$lid' AND uid='$uid'");
				header("location: $paperurl$pid.html");
				exit;
			}else if($action=='delete'){
				if($_GET['formhash'] != formhash()){
					die('ERROR SUBMIT!');
				}
	 
				DB::query("update %t set `status`='1' where `lid`='$lid' AND uid='$uid'", array('tiny_exam3_log'));
 
				header("location: plugin.php?id=exam:my&tab=logs&page=$page");
				exit;
			}
		}//if

		$total = DB::result_first("SELECT count(*) FROM ".DB::table('tiny_exam3_log')." where uid='$_G[uid]'");
		
		//$logs = DB::fetch_all("SELECT * FROM %t WHERE `uid`=%n AND `status`='0' order by `lid` desc limit %d,%d", array('tiny_exam3_log', $_G['uid'], (max($page, 1)-1)*$perpage, $perpage), 'lid');
		$logs = DB::fetch_all("SELECT L.*,P.title FROM %t AS L Left JOIN %t AS P ON L.pid=P.pid WHERE L.`uid`=%n AND L.`status`='0' order by `lid` desc limit %d,%d", array('tiny_exam3_log','tiny_exam3_paper', $_G['uid'], (max($page, 1)-1)*$perpage, $perpage), 'lid');
		
 
		$uids = array();
		foreach($logs AS $v){
			if($v['uid'] && !in_array($v['uid'], $uids))
				$uids[]=$v['uid'];
		}
		
		$logs_user = DB::fetch_all("SELECT uid,username FROM %t WHERE `uid` in (%n)", array('common_member', $uids), 'uid');
 
		$multipage =  multi($total, $perpage, $page, 'plugin.php?id=exam:my&tab=logs',10,10);
}
elseif($tab == 'show')
{		
		if($_GET['showper']==1){
	        $per = '';
			$leid    = intval($_GET['leid']);
			$ep = DB::fetch_first("SELECT eid,pid FROM %t where leid='$leid'", array('tiny_exam3_log_exam'));
			if(DB::result_first("SELECT count(*) FROM %t where pid='%d' AND uid='%d'", array('tiny_exam3_paper', $ep['pid'], $_G['uid']))){
				
				$data  = DB::result_first("SELECT data FROM %t where eid='%d'", array('tiny_exam3_exam', $ep['eid']));
				$count = count(explode("\n", $data));
				
				$total = DB::result_first("SELECT count(*) FROM %t where eid='%d'", array('tiny_exam3_log_exam', $ep['eid']));
				for($i=0; $i<$count; $i++){
					echo $A = chr(65+$i);
					$n = DB::result_first("SELECT count(*) FROM %t where eid='%d' AND result LIKE '%i%i%i'", array('tiny_exam3_log_exam', $ep['eid'], '%', $A, '%'));
					$per  .= intval($n*100 / $total) .';';
				}
			}
			//include template('common/header_ajax');
			echo $per;
			//include template('common/footer_ajax');
			exit;
		}
		
		//--------------------------------------------------------------------------
		$lid    = intval($_GET['lid']);
		if(isset($_POST['score2']) && $_G['groupid']==1)
		{
			//include template('common/header_ajax');
			
			$leid   = intval($_POST['leid']);
			$score2 = floatval($_POST['score2']);
			if(strval($_POST['score2'])===''){
				DB::query("update ".DB::table('tiny_exam3_log_exam')." SET `score2`=null where `leid`='$leid'");
				$score2='---';
			}
			else
				DB::query("update ".DB::table('tiny_exam3_log_exam')." SET `score2`='$score2' where `leid`='$leid'");
 

			echo $score2;
			//include template('common/footer_ajax');
			exit;
		}

		$log     = DB::fetch_first("SELECT L.score,L.pid,L.uid,P.title FROM %t AS L LEFT JOIN %t AS P ON L.pid=P.pid where L.lid='$lid' %i", array('tiny_exam3_log', 'tiny_exam3_paper', $_G['groupid']==1 ? '' : "AND L.uid='$uid'"));
		$log['username'] = DB::result_first("SELECT `username` from %t where uid='%d'", array('common_member', $log['uid']));
		
		$logexam = DB::fetch_all("SELECT * FROM %t where lid='$lid' %i order by leid asc", array('tiny_exam3_log_exam', $_G['groupid']==1 ? '' : "AND `uid`='$uid'"), 'eid'); 

		
		
		$eids = array();
		foreach($logexam AS $v){
			if($v['eid'])$eids[] = $v['eid'];
		}
		$exams   = DB::fetch_all("SELECT eid,result,data,subject,type,tid,count_right,count_wrong FROM %t where eid in(%n)", array('tiny_exam3_exam', $eids), 'eid'); 

		$tab = 'logs_show';
}
else
{
	$tab = 'list';
	if($action=='cp_paper_delete' && $_GET['formhash'] == formhash())
	{
		$pid = intval($_GET['pid']);
		if(DB::result_first("SELECT count(*) FROM ".DB::table('tiny_exam3_paper')." where pid='$pid' AND uid='$uid'")){
			DB::delete('tiny_exam3_exam',    "pid='$pid'");
			DB::delete('tiny_exam3_group',   "pid='$pid'");				
			DB::delete('tiny_exam3_paper',   "pid='$pid'");			
			DB::delete('tiny_exam3_log',     "pid='$pid'");			
			DB::delete('tiny_exam3_log_exam',"pid='$pid'");
		}

		$paper_count = DB::result_first("SELECT  count(*) FROM %t where `cid`='$cid'", array('tiny_exam3_paper'));
		DB::query("update %t set `paper_count`='$paper_count' where `cid`='$cid'", array('tiny_exam3_cate'));

		header("location: plugin.php?id=exam:my&tab=list&page=$page");
		exit;
	}
	$total = DB::result_first("SELECT count(*) FROM %t where uid='$_G[uid]'", array('tiny_exam3_paper'));
	$list  = DB::fetch_all('SELECT * FROM %t WHERE uid=%d order by `pid` desc limit %d,%d', array('tiny_exam3_paper', $_G['uid'], (max($page, 1)-1)*$perpage, $perpage), 'lid');
	$multipage =  multi($total, $perpage, $page, 'plugin.php?id=exam:my&tab=list',10,10);
}
 
include template("exam:$template/my");
?>