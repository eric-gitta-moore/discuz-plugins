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
	$isPC = !checkmobile();
 
	if(!$isPC && !isset($_GET['mobile'])){
		header('Location: '.$_G['siteurl'].'plugin.php?id=exam:m&mobile=no'); 
		exit;
	}
 
	$qrfile = DISCUZ_ROOT.'source/plugin/exam/image/qrcode.png';
 
	if($_G['adminid'] == 1 && !file_exists($qrfile) && ($host = substr($_SERVER['HTTP_HOST'],0,4))!='192.' && $host!='127.') {
		require_once DISCUZ_ROOT.'source/plugin/exam/qrcode.class.php';
		QRcode::png($mobiurl, $qrfile);
	}
	
	if($_GET['mobi']!='yes' && $isPC){
		include template("exam:$template/common/mobi");
		exit;
	}

	$cid = empty($_GET['list'])  ? '' : intval($_GET['list']);
	$pid = empty($_GET['paper']) ? '' : intval($_GET['paper']);
 
 	//-----------------------------------------------------------------------------------
	$cates = C::t('#exam#tiny_exam3_cate')->fetch_cate();
	$tree  = gettree($cates, 0,  'cid', 'ucid');
 
	if($cid>0){
		$listnum = empty($config['listnum']) ? 15 : intval($config['listnum']);
		$curcate= C::t('#exam#tiny_exam3_cate')->get_one($cid);
		$parentcate = $tree[$curcate['ucid']];
 
		$W = "`cid` = $cid AND `status`='1' AND `public`='1'";//正常
 
		$total   = DB::result_first("SELECT count(*) FROM %t where $W", array('tiny_exam3_paper'));
		$papers  = DB::fetch_all("select * from %t where $W order by `stick` desc,`last_time`,`pid` desc limit %d,%d",array('tiny_exam3_paper',  (max($_GET['page'], 1)-1)*$listnum, $listnum),'pid');
		foreach($papers AS $k => $v){
			$papers[$k]['content'] = dzcode($v['content']);
		}
		$pages   = ceil($total/$listnum);
	}
	elseif($pid>0)
	{
		$paper = C::t('#exam#tiny_exam3_paper')->get_paper_info($pid);

		$checkPaperStatus = checkPaper($paper, $_G['uid']);
		if($checkPaperStatus===true && ($paycheck = payfor($pid, $_G['uid'], 'check')))
		{
			//试卷中题目列表
			$groups              = C::t('#exam#tiny_exam3_paper')->fetch_exam_by_pid($pid);
			$paper['total_score']= C::t('#exam#tiny_exam3_paper')->get_score($pid);
			if(empty($groups))
			{
				$checkPaperStatus = 'empty';
			}
			//PV统计
			C::t('#exam#tiny_exam3_paper')->set_count($pid);
		}
	}
 
	include template("exam:$template/mobile/m"); 
?>

