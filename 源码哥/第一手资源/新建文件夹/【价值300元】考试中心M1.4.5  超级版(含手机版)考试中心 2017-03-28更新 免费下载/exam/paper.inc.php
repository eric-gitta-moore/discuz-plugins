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
 
	//δ�ҵ������Ծ�!
	$paper = C::t('#exam#tiny_exam3_paper')->get_paper_info($pid);

	if(empty($paper)){
		showmessage( "&#x672A;&#x627E;&#x5230;&#x8BE5;&#x5957;&#x8BD5;&#x5377;!", "plugin.php?id=exam");
	}
  
	if($_G['adminid']!=1 && $paper['uid']!=$uid && ($paper['status']==0 || $paper['public']==0)){
		showmessage( "&#26080;&#26435;&#38480;!", "plugin.php?id=exam");
	}

	//Ȩ���ж�=================================================================
	$checkPaperStatus = checkPaper($paper, $uid);
	$lid = isset($_GET['replay']) ? intval($_GET['replay']) : 0;
	
	if($checkPaperStatus===true)
	{
		//�Ծ�����Ŀ�б�
		$groups = C::t('#exam#tiny_exam3_paper')->fetch_exam_by_pid($pid);
		
		//���浽�ļ�------------------------------------------------------------------------------------
		/*
 *Դ��磺www.ymg6.com
 *������ҵ���/ģ��������� ����Դ���
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */
		//���浽�ļ�------------------------------------------------------------------------------------
		
		$paper['total_score']= C::t('#exam#tiny_exam3_paper')->get_score($pid);
		$paper['twice_did']  = C::t('#exam#tiny_exam3_log')->value('count(*)', $uid, $pid);	//��������
		$paper['twice_left'] = $paper['twice_left'] - $paper['twice_did'] ;	//ʣ�����
	 
		//�ط�
		if($lid){
			$history = DB::fetch_all("SELECT eid,result AS user_result, score AS user_score FROM %t where lid='$lid' AND uid='$uid'", array('tiny_exam3_log_exam'), 'eid');
	 
		}
 
		//PVͳ��
		C::t('#exam#tiny_exam3_paper')->set_count($pid);

		//�Ծ���������!
		if(empty($groups))$checkPaperStatus = 'empty';
		
		//������Ϣ
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
	
	//����������-----------------------
	$queuelock = false;
	if($config['queue_user'] && $lid==0){
		$queuetime = $_SERVER['REQUEST_TIME'] - 60 * 10;//10����
		$queuenum = DB::result_first("select count(*) from %t where `endtime`>'%d'", array('tiny_exam3_log', $waittime));
		if($queuenum > $config['queue_user']){
			$queuelock = true;
		}
	}
	//����������-----------------------
	//print_r($paper);
	//print_r($groups);

	include template("exam:$template/paper");
