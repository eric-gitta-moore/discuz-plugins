<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP') ) {
	exit('Access Denied');
}
 
require_once 'tiny.common.inc.php';
 
$cid = !isset($_GET['cid']) ? 0 : intval($_GET['cid']);

if($_POST['editsubmit'] && $_GET['formhash'] == formhash()){
	foreach($_POST['name'] AS $k=>$v){
		$k = intval($k);
		if($k==0)continue;
		$post = array(
			'ucid'  => $cid,
			'name' => $v,
			'sort'  => $_POST['sort'][$k],
			'icon'  => $_POST['icon'][$k],
			'description'  => $_POST['description'][$k],
		);
		DB::update('tiny_exam3_cate', $post ,"cid='$k'");
	}
	foreach($_POST['newcat'] AS $k=>$v){
		$k = intval($k);
		if($k==0 || $v=='')continue;
		$post = array(
			'ucid'  => $cid,
			'name' => $v,
			'sort'  => $_POST['newcatorder'][$k],
		);
		DB::insert('tiny_exam3_cate', $post );
	}
	//update_sysnav();
}
else if(isset($_GET['delid']) && $_GET['formhash'] == formhash()){
	$delid=intval($_GET['delid']);
	if(!DB::result_first("select count(*) from ".DB::table('tiny_exam3_paper')." where cid='$delid'") && !DB::result_first("select count(*) from ".DB::table('tiny_exam3_cate')." where ucid='$delid'")){
		DB::delete('tiny_exam3_cate',  "cid='$delid'");
		DB::delete('tiny_exam3_paper', "cid='$delid'");
		DB::delete('tiny_exam3_exam',  "cid='$delid'");
	}
	else{
		$ERROR = 1;
	}

}
else if(isset($_GET['hide']) && $_GET['formhash'] == formhash()){
	//DB::query("UPDATE ".DB::table('tiny_exam3_cate')." SET `status`=ABS(`status`-1) WHERE cid='".intval($_GET['hide'])."'");
	$hide = intval($_GET['hide']);
	$stat = DB::result_first("select `status` from %t where cid='$hide'", array('tiny_exam3_cate'));
	DB::query("UPDATE %t SET `status`=%n WHERE cid='$hide'", array('tiny_exam3_cate', $stat ? 0 : 1));
}

 
$syscates = DB::fetch_all("select * from ".DB::table('tiny_exam3_cate')." where ucid='$cid' order by `sort`,`cid` asc",array(),'cid');
$curname  = $cid >0 ? DB::result_first("select name from ".DB::table('tiny_exam3_cate')." where cid='$cid'") : '';

$baseurl = "admin.php?action=plugins&operation=config&identifier=exam&pmod=admincp_cate&cid=$cid&formhash=".$_G['formhash'];
 

 
include template("exam:$template/common/admincp_cate");

?>