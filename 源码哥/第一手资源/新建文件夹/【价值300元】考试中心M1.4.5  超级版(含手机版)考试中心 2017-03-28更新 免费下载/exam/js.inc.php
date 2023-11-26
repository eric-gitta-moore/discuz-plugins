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

	$jsname = explode(':',$_GET['id']);
	if(count($jsname)>=5)
	{
		$jsmod = $jsname[2];
		$jstbl = $jsname[3];
		$jsnum = intval($jsname[4]); if($jsnum<=0 || $jsnum>50)$jsnum=5;
		$jscid = intval($jsname[5]);
	}
	else
	{
		echo '&#x53C2;&#x6570;&#x8BBE;&#x7F6E;&#x9519;&#x8BEF;';
		exit;
	}
 
	if($jsmod=='log'){
		$list = C::t('#exam#tiny_exam3_log')->get_simple($jsnum);
	}
	elseif($jsmod=='paper'){
		$wcid = !$jscid ? '' : "cid='$jscid' AND";
		$list = DB::fetch_all("select pid,title,cid,uid,username,submit,minute,pass,price,last_time,last_user,pv,addtime AS time from ".DB::table('tiny_exam3_paper')." where $wcid `status`='1' AND `public`='1' order by pid desc limit $jsnum");
	}
	else{
		echo '&#x53C2;&#x6570;&#x8BBE;&#x7F6E;&#x9519;&#x8BEF;';
		exit;
	}
 
 
	ob_start();
	include template("exam:js/$jstbl");

	$jsct =  ob_get_contents();
	ob_end_clean();

	$jslist = str_replace(array('"',"\r","\n"),array('\\"','', ''),$jsct);

	echo "document.writeln(\"$jslist\");";

