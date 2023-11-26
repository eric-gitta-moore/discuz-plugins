<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}	
 
	require 'tiny.common.inc.php';
	$uid = $_G['uid'];
	$pid = intval($_POST['pid']);

	if($_G['uid'] && ($_SERVER['REQUEST_TIME'] - C::t('#exam#tiny_exam3_log')->value('endtime', $uid, $pid)) < 15){
		//include template('common/header_ajax');
		echo 're_subject';
		//include template('common/footer_ajax');
		exit;
	}

	$result = array();
	foreach($_POST AS $k => $v){
		if(substr($k, 0, 2)=='e_' && $k = intval(substr($k,2))){
			$type = $v['type'];
			unset($v['type']);
			if($type<=3){
				$result[$k] = array('eid' => $k, 'type' => $type, 'user_result' => implode('', $v));
			}elseif($type==4){
				$result[$k] = array('eid' => $k, 'type' => $type, 'user_result' => implode("\n", $v));
			}elseif($type==5){
				$result[$k] = array('eid' => $k, 'type' => $type, 'user_result' => $v[0], 'user_score' => $v[1]==='' ? '' : max(0,$v[1]));
			}
		}
	}
 
	if(empty($result)){
		//include template('common/header_ajax');
		echo 'null_subject';
		//include template('common/footer_ajax');
		exit;
	}
 
	//--------------------------------------------------------------------------------------------------------------------------
	$groups = C::t('#exam#tiny_exam3_paper')->fetch_exam_by_pid($pid);
	$paper  = C::t('#exam#tiny_exam3_paper')->get_paper_info($pid);	
	$rmsg = checkPaper($paper, $uid);
	if($rmsg !== true){
		//include template('common/header_ajax');
		echo $rmsg;
		//include template('common/footer_ajax');
		exit;
	}
	
	$score_total = 0;
	$score_right = 0;
	if($exam = DB::fetch_all("SELECT eid,uid,pid,cid,gid,tid,subject,result,data,note,type,score,addtime FROM %t WHERE eid in(%n) order by eid", array('tiny_exam3_exam', array_keys($result)), 'eid'))
	{
		foreach($exam AS $eid=>$e){

			$result[$eid]['sys_score'] = $e['score']==0 ? $groups[$e['gid']]['score'] : $e['score'];

			//--------------------------------------------------------------

			if($e['type']<=3){//判断,选择
				$result[$eid]['sys_result']  = trim($e['result']);
			}
			else if($e['type']==4){//填空题
				$result[$eid]['sys_result']  = trim($e['data']);
			}
			else if($e['type']==5){//问答
				$result[$eid]['user_score']  = min($result[$eid]['sys_score'], $result[$eid]['user_score']);
				$result[$eid]['sys_result']  = trim($e['data']);
			}
			else{
				continue;
			}
			$result[$eid]['sys_note']  = trim($e['note']);
			$result[$eid]['type']  = $e['type'];
 			
			
			//第二轮计算,算分============================================================================================================
			$bStatusWrong = false;
			$ra = $result[$eid];//result array
			$score_total += $ra['sys_score'];
 
			if($ra['type']<=4){
				if(strval($ra['user_result']) == strval($ra['sys_result'])){
					$result[$eid]['user_score'] = $ra['sys_score'];
					$score_right += $ra['sys_score'];
					DB::query("update %t set `count_right`=`count_right`+1 where `eid`='$eid'", array('tiny_exam3_exam'));
				}else{
					DB::query("update %t set `count_wrong`=`count_wrong`+1 where `eid`='$eid'", array('tiny_exam3_exam'));
					$result[$eid]['user_score'] = 0;
					$bStatusWrong = true;
				}
			}else if($ra['type']==5){
				if($ra['user_score']>0){
					$score_right += $ra['user_score'];
				}
				else{
					$bStatusWrong = true;
				}
			}
			
			//记录错误题目
			if($bStatusWrong && strval($ra['user_result'])!=''){
				$post = array(
					'eid'		 => $eid,
					'uid'		 => $_G['uid'], 
					'pid' 		 => $pid,
					'addtime'	 => $_SERVER['REQUEST_TIME'],
					'cid'		 => $e['cid'],
					'type' 		 => $e['type'],
					'sys_result' => $ra['sys_result'],
					'user_result'=> $ra['user_result'],
					'tid'	     => $e['tid'],
				);
				$isHas = DB::result_first("select count(*) from %t where `eid`='$eid' AND `uid`='$uid'", array('tiny_exam3_wrong'));
				$isHas ? DB::update('tiny_exam3_wrong', $post, "eid='$eid' AND uid='$uid'") :  DB::insert('tiny_exam3_wrong', $post);
			}
		}
	}
	$paper['total'] = $score_total;
	$paper['score'] = $score_right;
	
	if($pid==0){
		//include template('common/header_ajax');
		echo 'null_pid';
		//include template('common/footer_ajax');
		exit;
	}/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

	if(empty($_GET['replay']))
	{	
		//加入试题记录
		DB::query("update %t set `submit`=`submit`+1 where `pid`='$pid'", array('tiny_exam3_paper'));
		
		//加入试卷记录
		$post = array(
			//'title'     => $paper['title'],
			'uid'       => $_G['uid'],
			'pid'       => $paper['pid'],
			'cid'       => $paper['cid'],
			'score'     => $paper['score'],
			'total'     => $paper['total'],
			'starttime' => 0,
			'endtime'   => $_SERVER['REQUEST_TIME'],
			'userinfo'  => implode("\n", $_POST['userinfo'])
		);
		$jid = DB::insert('tiny_exam3_log', $post, true);
			
		//考试记录
		foreach($result AS $eid=>$e){
			$post = array(
				'lid'		=> $jid,
				'eid'		=> $eid,
				'uid'		=> $_G['uid'],
				'pid'		=> $pid,
				'cid'		=> $paper['cid'],
				'type'		=> $e['type'],
				'result'	=> $e['user_result'],
				'score'	    => $e['user_score'],
				'addtime'	=> $_SERVER['REQUEST_TIME'],
			);
			DB::insert('tiny_exam3_log_exam', $post);
		}


		//向板块更新最后一次考试结果
		$lastu = array(
			'last_time'  => $_SERVER['REQUEST_TIME'],
			'last_user'  => $_G['username'],
		);
		DB::update('tiny_exam3_paper', $lastu, "`pid`='".$paper['pid']."'");
		
		//向试卷更新最后一次考试结果
		$last = array(
			'paper'		=> $paper['title'],
			'username'	=> $_G['username'],
			'time'		=> $_SERVER['REQUEST_TIME'],
			'score'		=> $paper['score'],
			'pid'		=> $pid
		);
		DB::update('tiny_exam3_cate', array('last' => serialize($last)), "`cid`='".$paper['cid']."'");
		
	 
		//同步考试记录到一个板块
		if($config['push_exam_result_fid']>0 && $_G['uid']){
			push_to_form($config['push_exam_result_fid'], L('push_to_form_subject'), L('push_to_form_message'), $_G['uid'], $_G['username']);
		}


		//同步到动态
		if($_G['setting']['feedstatus'] && $config['feed']){
			push_to_share($paper['pid'], $paper['title'], $paper['score'], $paper['total'], $paper['pass'], $paper['minute']);
		}
	}

	//include template('common/header_ajax');
	echo $config['showscore'] ? str_replace(array('<','>','='),array('&lt;','&gt;',"&#61;"), array2json($result)) : 'score='.$paper['score'];
	//include template('common/footer_ajax');
?>