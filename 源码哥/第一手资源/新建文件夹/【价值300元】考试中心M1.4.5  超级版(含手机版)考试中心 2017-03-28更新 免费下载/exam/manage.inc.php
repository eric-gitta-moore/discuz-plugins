<?php

/*
 *Դ��磺www.ymg6.com
 *������ҵ���/ģ��������� ����Դ���
 *����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 *����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	require_once "tiny.common.inc.php";
 
	$tab  = !isset($_GET['tab']) ? 'pg' : strval($_GET['tab']);
 
	$pid   = !isset($_GET['pid']) ? 0 : intval($_GET['pid']);
	$gid   = !isset($_GET['gid']) ? 0 : intval($_GET['gid']);
	$eid   = !isset($_GET['eid']) ? 0 : intval($_GET['eid']);
	$action= !isset($_GET['action']) ? '' : $_GET['action'];


	//�ж��Ƿ��¼
	if(!$_G['uid'])showmessage('to_login', null, array(), array('showmsg' => true, 'login' => 1));

	//��ǰ�Ծ�--ȫ��
	$paper = DB::fetch_first("select * from %t where `pid`='$pid'", array('tiny_exam3_paper'));
	if(empty($paper))showmessage('&#x65E0;&#x6548;&#x8BD5;&#x5377;!');
	
	$paper['readgroup'] = empty($paper['readgroup']) ? '' : explode(',', $paper['readgroup']);
	$uid   = $paper['uid'];
 
	$wu =  $_G['groupid']==1 ? '' : "AND `uid`='$uid'";
	
	if($_G['uid'] != $uid && $_G['adminid']!=1)showmessage('&#x60A8;&#x65E0;&#x6743;&#x9650;&#x7BA1;&#x7406;&#x4ED6;&#x4EBA;&#x7684;&#x8BD5;&#x5377;!');//����Ȩ�޹������˵��Ծ�!
	$paper['starttime']= !$paper['starttime'] ? '' : date('Y-m-d H:i', $paper['starttime']);
 
 
	//�ж��Ƿ��ǿ������������û���: �����ڵ��û�����Ȩ����Ծ�, �������Ա��ϵ
 	if(!empty($config['groupadd']) && !in_array($_G['groupid'], $config['groupadd'])){//ʹ����
		showmessage('&#x4F60;&#x6240;&#x5728;&#x7684;&#x7528;&#x6237;&#x7EC4;&#x65E0;&#x6743;&#x6DFB;&#x52A0;&#x8BD5;&#x5377;, &#x8BF7;&#x4E0E;&#x7BA1;&#x7406;&#x5458;&#x8054;&#x7CFB;!');
	}
 
	if($_POST){
		if($tab>=1 && $tab<=5){//����
				if($eid>0){
					$post = array(
						'subject'	=> trim($_POST['subject']),
						'result'	=> $_POST['result'],
						'image'		=> $_POST['image'],
						'note'		=> $_POST['note'],
						'type'		=> $tab,
					);
				}else{
					$post = array(
						'subject'	=> trim($_POST['subject']),
						'result'	=> $_POST['result'],
						'image'		=> $_POST['image'],
						'note'		=> $_POST['note'],
						'gid'		=> $gid,
						'uid'		=> $uid,
						'pid'		=> $pid,
						'cid'		=> DB::result_first('select `cid` from '.DB::table('tiny_exam3_paper')." where pid='$pid'"),
						'display'	=> 1,
						'type'		=> $tab,
						'addtime'	=> $_SERVER['REQUEST_TIME'],
					);
				}
 
				if($tab==1){//�����ж���.................ʡ��
						//$post['result']	= $post['result'];
						$post['data'] = '';
				}elseif($tab==2){//������ѡ��
						$option = $_POST['option'];
						for($i=count($option)-1;$i>=0;$i--){
							$o = trim($option[$i]);
							if(empty($o)){
								unset($option[$i]);
							}else{
								break;
							}
						}
						//$post['result'] = $post['result'];
						$post['data'] = implode("\n", $_POST['option']);
				}elseif($tab==3){//������ѡ��
						$option = $_POST['option'];
						for($i=count($option)-1;$i>=0;$i--){
							$o = trim($option[$i]);
							if(empty($o)){
								unset($option[$i]);
							}else{
								break;
							}
						}
						$post['result']= implode($post['result']);
						$post['data']  = implode("\n",$_POST['option']);
				}elseif($tab==4){//���������
						$post['data'] = trim($_POST['data']);
						$post['data'] = str_replace("\r","",$post['data']);
				}elseif($tab==5){//�����ʴ���
						$post['data']  = trim($_POST['data']);
				}

				if(isset($post['subject'])){
						if($eid>0){
							DB::update('tiny_exam3_exam', $post, "eid='$eid' $wu");	
						}
						else{
							if($post['subject'] && DB::result_first('select count(*) from '.DB::table('tiny_exam3_group')." where gid='$gid' $wu")){
								$eid = DB::insert('tiny_exam3_exam', $post, true);	
							}
						}

						DB::query("update ".DB::table('tiny_exam3_upload')." SET `eid`='$eid' where `src`='".addslashes(substr ($post['image'], -25))."' $wu");
				}
 
				push_exam_to_form($eid);
 
				header("location: plugin.php?id=exam:manage&pid=$pid&gid=$gid&tab=ge#move".$eid);
				exit;
		}
		else if($tab=='in'){//�������
			include "in.submit.php";
			if($in_submit_ok==true){
				header("location: plugin.php?id=exam:manage&pid=$pid&gid=$gid&tab=ge");
				exit;
			}
		}
		else if($tab=='gs'){//��������
			if(trim($_POST['name'])){
				$post=array(
					'name'		=> $_POST['name'],
					'score'		=> $_POST['score'],
					//'num_max'	=> $_POST['num_max'],
					'content'	=> trim($_POST['message']),
					'assoc'	    => $_POST['assoc'],
				);
				DB::update('tiny_exam3_group', $post, "gid='$gid' $wu");
				DB::query("UPDATE %t SET `num_max`=%i where gid='$gid' $wu", array('tiny_exam3_group', strval($_POST['num_max'])==='' ? 'null' : "'".intval($_POST['num_max'])."'"));
				header("location: plugin.php?id=exam:manage&pid=$pid&gid=$gid&tab=pg");
				exit;
			}
		}
		else if($tab=='ps'){//�Ծ�����
			if(trim($_POST['title'])){
				$post=array(
					'title'		=> $_POST['title'],
					'public'	=> $_POST['public'],
					'pass'		=> $_POST['pass'],
					'minute'	=> $_POST['minute'],
					'price'		=> $_POST['price'],
					'starttime'	=> !$_POST['starttime'] ? 0 : strtotime($_POST['starttime']),
					'pwd'	    => trim($_POST['pwd']),
					'content'	=> trim($_POST['message']),
					'fgid'		=> $_POST['fgid'],
					'delay'		=> $_POST['delay'],
					'twice'		=> $_POST['twice'],
					'wait'		=> $_POST['wait'],
					'edittime'	=> $_SERVER['REQUEST_TIME'],
					'long'		=> $_POST['long1'] * 86400 + $_POST['long2'] * 3600,
					'readgroup' => implode(',', $_POST['readgroup']),
					//'status' 	=> 0,	Ϊ0����Ҫ�������	
				);
				DB::update('tiny_exam3_paper', $post, "`pid`='$pid' $wu");	
				header("location: plugin.php?id=exam:manage&pid=$pid&gid=$gid&tab=ps");
				exit;
			}
		}
		else if($tab[1]=='e'){//�Ծ����:�Ծ�����ͷ�ֵ����
			$sort =$_POST['sort'];
			$score=$_POST['score'];
			foreach($sort AS $k=>$v){
				$k = intval($k);
				$v = intval($v);
				$s = addslashes($score[$k]);
				DB::query("UPDATE %t SET `sort`='$v',`score`='$s' where eid='$k' $wu",array('tiny_exam3_exam'));
			}
		}
		else if($tab[1]=='g'){//��������
			$sort=$_POST['sort'];
			foreach($sort AS $k=>$v){
				$k = intval($k);
				$v = intval($v);
				DB::query("UPDATE %t SET `sort`='$v' where gid='$k' $wu", array('tiny_exam3_group'));
			}
		}
	}
	if($action=='group_new' && $_GET['formhash'] == formhash())
	{
		if(isset($_POST['groupname'])){
			if(($name = trim($_POST['groupname'])) && $paper['pid']){
				DB::insert('tiny_exam3_group', array('name'=>dhtmlspecialchars($name), 'pid'=>$paper['pid'],  'uid'=>$uid));	
				header("location: plugin.php?id=exam:manage&pid=$pid&gid=$gid&tab=$tab");
				exit;
			}
		}
	}
	elseif($action=='group_delete' && $_GET['formhash'] == formhash())
	{
		if($delgid=intval($_GET['delgid'])){
			$wud =  $_G['groupid']==1 ? '' : "AND U.`uid`='$uid'";
			DB::query("update %t AS U,%t AS E set U.eid='0' where U.eid=E.eid AND E.gid='$delgid' $wud", array('tiny_exam3_upload' , 'tiny_exam3_exam'));		
			DB::delete('tiny_exam3_exam',  "gid='$delgid' $wu");
			DB::delete('tiny_exam3_group', "gid='$delgid' $wu");
			
			header("location: plugin.php?id=exam:manage&pid=$pid&gid=$gid&tab=$tab");
			exit;
		}
	}
 
	//����--ȫ��
	$navs=array(0,1);
	$navs[1] = DB::fetch_first("select * from %t where `cid`='%d'", array('tiny_exam3_cate', $paper['cid']));
	$navs[0] = DB::fetch_first("select * from %t where `cid`='%d'", array('tiny_exam3_cate', $navs[1]['ucid']));
 
	//�Ծ��б�,���������
	$groups = C::t('#exam#tiny_exam3_group')->get_groups2($pid, true);
	$group = $groups[$gid];
	if($tab[1]=='e'){
		if($tab[0]=='p'){
			foreach($groups AS $_gid=>$g){
				$groups[$_gid]['content'] = dzcode($g['content']);
				$groups[$_gid]['list'] =  C::t('#exam#tiny_exam3_paper')->fetch_exam_by_gid($_gid, null, 0);
			}
		}
		else{
			$groups[$gid]['content'] = dzcode($groups[$gid]['content']);
			$groups[$gid]['list'] =  C::t('#exam#tiny_exam3_paper')->fetch_exam_by_gid($gid, null, 0);
		}
	}
 
	//δʹ�õ�ͼƬ
	$images = ($tab<1 || $tab>5) ? array() : DB::fetch_all("SELECT * from %t where uid='$uid' AND eid='0'", array('tiny_exam3_upload'));

	//�Ծ��ڱ༭״̬
	if($eid>0){
		$exam = DB::fetch_first("select * from ".DB::table('tiny_exam3_exam')." where `eid`='$eid' $wu");
		if($tab==2 || $tab==3){ 
			$exam['data'] = explode("\n", $exam['data']);
		}
	}
	
 
	if(empty($exam['data']) && ($tab==2 || $tab==3)) $exam['data'] = array('', '', '', '');
 
	//����������
	if($tab=='ps'){
		require_once libfile('function/friend');
		$friend_group_list = friend_group_list();
		$usergroup = DB::fetch_all("select G.groupid,G.grouptitle,F.readaccess from %t As G,%t As F where G.groupid=F.groupid And F.readaccess>0 order by F.readaccess", array('common_usergroup', 'common_usergroup_field'), 'groupid');
	}

 
	include template("exam:$template/common/manage"); 
	
	
	

	
	
 


 
	
	
	
 
