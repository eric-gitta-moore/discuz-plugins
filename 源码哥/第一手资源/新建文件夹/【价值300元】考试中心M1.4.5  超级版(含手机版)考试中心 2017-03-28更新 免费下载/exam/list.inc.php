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

	require_once 'tiny.common.inc.php';
 
	if(isset($_GET['list'])){
		list($cid, $page) = explode('-', $_GET['list']);
		$cid  = intval($cid);
		$page = intval($page);
	}else{
		$cid  = intval($_GET['cid']);
		$page = intval($_GET['page']);
	}
	$page = max(1, $page);
	
	if($cid==0 && checkmobile() && !isset($_GET['mobile'])){
		header('Location: '.$_G['siteurl'].'plugin.php?id=exam:m&mobile=no'); 
		exit;
	}

	$action = isset($_GET['action']) ? $_GET['action'] : '';
 
	$indexurl = $config['rewrite'] ? 'exam.html' : 'plugin.php?id=exam';
	$paperurl = $config['rewrite'] ? 'exam' : 'plugin.php?id=exam&paper=';
	$listurl  = $config['rewrite'] ? 'list' : 'plugin.php?id=exam&list=';
	
 	//-----------------------------------------------------------------------------------
	$cates = C::t('#exam#tiny_exam3_cate')->fetch_cate();
	$tree  = gettree($cates, 0,  'cid', 'ucid');
 
	$listnum = empty($config['listnum']) ? 15 : intval($config['listnum']);
 
	if($cid==0){
		$lognum  = empty($_GET['list']) ? max(0,intval($config['lognum'])) : 0;

		$cids = 0; 
		$WC = '';
		
		$newlog = $lognum==0  ? array() : C::t('#exam#tiny_exam3_log')->get_simple($lognum);
 
	}else{

		if(!$curcate= C::t('#exam#tiny_exam3_cate')->get_one($cid)){showmessage('The cate is not exist!');}
 
		$curTree = gettree($cates, $cid,  'cid', 'ucid');
		$cidArr = array_keys($curTree);

		foreach($curTree AS $v){
			if(isset($v['child'])){
				$cidArr = array_merge($cidArr, array_keys($v['child']));
			}
		}
		$cidArr[] = $cid;
		$cids = mysql_implode($cidArr);		
		$WC   = "`cid` in ($cids) AND";

		$parentcate = $tree[$curcate['ucid']];
		$curcate['lastcate'] = !DB::result_first("SELECT count(*) FROM %t where ucid='%d'", array('tiny_exam3_cate', $cid));
	}


	//-----------------------------------------------------------------------------------

	if(!empty($_POST) && $_G['uid'])
	{
 		if($cid && isset($_POST['papername']) && (empty($config['groupadd']) || in_array($_G['groupid'], $config['groupadd']))){//可制作试卷权限
			if(!$curcate['lastcate'])showmessage('This is not last cate, could not be adding paper!');

			if($papername = trim($_POST['papername'])){
				$post=array(
					'title'		=> $papername,
					'cid'		=> $cid,
					'uid'		=> $_G['uid'],
					'username'	=> $_G['username'],
					'addtime'	=> $_SERVER['REQUEST_TIME'],
				);
				if($pid = DB::insert('tiny_exam3_paper', $post, true)){
					$paper_count = DB::result_first("SELECT  count(*) FROM %t where `cid`='$cid'", array('tiny_exam3_paper', $cid));
					$exam_count  = DB::result_first("SELECT  count(*) FROM %t where `cid`='$cid'", array('tiny_exam3_exam',  $cid));
					DB::query("update %t set `paper_count`='%d',`exam_count`='%d' where `cid`='%d'", array('tiny_exam3_cate', $paper_count, $exam_count, $cid));

					$u_paper_count = DB::result_first("SELECT sum(`paper_count`) FROM %t where `ucid`='%d'", array('tiny_exam3_cate', $curcate['ucid']));
					$u_exam_count = DB::result_first("SELECT sum(`exam_count`) FROM %t where `ucid`='%d'", array('tiny_exam3_cate', $curcate['ucid']));
					
					DB::query("update %t set `paper_count`='%d',`exam_count`='%d' where `cid`='%d'", array('tiny_exam3_cate', $u_paper_count, $u_exam_count, $curcate['ucid']));

					header("location: plugin.php?id=exam:manage&pid=$pid&gid=0&tab=ps");
					exit;
				}
			}
		}
		else if($_G['adminid']==1)//管理员功能
		{
			$pids = addslashes(implode(',', $_POST['moderate']));
			if(!empty($pids))
			{
				if(isset($_GET['color'])){
					DB::update('tiny_exam3_paper', array('color'=>intval($_GET['color'])), "pid in ($pids)");
				}
				else if(isset($_GET['delete']))
				{
					DB::query("update %t AS U,%t AS E set U.eid='0' where E.pid in (%i) AND U.eid=E.eid", array('tiny_exam3_upload', 'tiny_exam3_exam', $pids));				
					DB::delete('tiny_exam3_paper', "pid in ($pids)");
					DB::delete('tiny_exam3_group', "pid in ($pids)");
					DB::delete('tiny_exam3_exam',  "pid in ($pids)");
 
					if($cid>0){
						$paper_count = DB::result_first("SELECT count(*) FROM %t where `cid`='%d'", array('tiny_exam3_paper', $cid));
						DB::query("update %t set `paper_count`='%d' where `cid`='%d'", array('tiny_exam3_cate', $paper_count, $cid));
					}
				}
				else if(isset($_GET['stick'])){
					C::t('#exam#tiny_exam3_paper')->set_status('stick', 1, $pids);
				}
				else if(isset($_GET['unstick'])){
					C::t('#exam#tiny_exam3_paper')->set_status('stick', 0, $pids);
				}
				else if(isset($_GET['lock'])){
					C::t('#exam#tiny_exam3_paper')->set_status('status',2, $pids);
				}
				else if(isset($_GET['check'])){
					C::t('#exam#tiny_exam3_paper')->set_status('status',1, $pids);
					//C::t('#exam#tiny_exam3_paper')->set_status('public',1, $pids);
				}
				else if(isset($_GET['uncheck'])){
					C::t('#exam#tiny_exam3_paper')->set_status('status',0, $pids);
				}
				else if(isset($_GET['move'])){
					$tocid  = intval($_GET['move']);
					DB::update('tiny_exam3_paper', array('cid'=>$tocid,   'last_time'=>$_SERVER['REQUEST_TIME']),  "pid in ($pids)");
					DB::update('tiny_exam3_exam',  array('cid'=>$tocid),  "pid in ($pids)");
				}

				header('location: '.$_SERVER["HTTP_REFERER"]);
			}
		}
 
	}
	
	//-----------------------------------------------------------------------------------
	if($listnum>0){
		$W = "`status`='1' AND `public`='1'";//正常
		if($_G['adminid']==1){
			if    ($action=='lock')    $W = "`status`='2'"; //已锁定
			elseif($action=='unpublic')$W = "`public`='0'"; //未发布
			elseif($action=='uncheck') $W = "`status`='0' AND `public`='1'"; //未审核
		}
 
		$total   = DB::result_first("SELECT count(*) FROM %t where %i $W", array('tiny_exam3_paper', $WC));
		$papers  = DB::fetch_all("select * from %t where %i $W order by `stick` desc,`pid` desc limit %d,%d",array('tiny_exam3_paper', $WC, (max($page, 1)-1)*$listnum, $listnum),'pid');//`last_time` desc,
 
		if($cid){
			$multipage = multi($total, $listnum, $page, "plugin.php?id=exam&list={$cid}.html",10,10);
			$multipage = $config['rewrite'] ? preg_replace("/plugin\.php\?id=exam&list=(\d*)\.html&(?:amp;)?page=(\d*)/i", "list\$1-\$2.html", $multipage)
											: preg_replace("/list=(\d*)\.html&(?:amp;)?page=(\d*)/i", "list=\$1-\$2.html", $multipage);
			
		}
		else{
			$multipage = multi($total, $listnum, $page, "plugin.php?id=exam&list=-x.html",10,10);

			$multipage = $config['rewrite'] ? preg_replace("/plugin\.php\?id=exam&list=-x\.html&(?:amp;)?page=(\d*)/i", "list-\$1.html", $multipage)
											: preg_replace("/-x\.html&(?:amp;)?page=(\d*)/i", "-\$1.html", $multipage);			
		}

	}

	$_G['cookie']['cookie_cate'] = isset( $_G['cookie']['cookie_cate']) ? explode(';',  $_G['cookie']['cookie_cate']) : array();
 
	$navtitle		= 0==$cid ? $config['title']      : $curcate['name'];
	$metakeywords	= 0==$cid ? $config['keywords']   : $curcate['name'];
	$metadescription= empty($curcate['description']) ?  $curcate['name'] .' '. $config['description'] : dhtmlspecialchars(strip_tags(str_replace('"','\'',$curcate['description'])));

	include template("exam:$template/list"); 
?>

