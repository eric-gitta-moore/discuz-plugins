<?php
/*
 * 出处：源码哥
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
if(submitcheck('newsubmit')){
	$_GET = daddslashes($_GET);
	if(empty($_GET['mold'])||empty($_GET['contact']['qq'])||empty($_GET['contact']['mobile'])||empty($_GET['deduct_type'])||empty($_GET['other_side'])||empty($_GET['price'])||empty($_GET['message'])||empty($_GET['trade_type'])) showmessage($lang[66]);
	$money = dealprice($_GET['price'],$_GET['deduct_type']);
	if($money['amount']<=0) showmessage($lang[67]);
	$user = @DB::fetch_first("SELECT * FROM ".DB::table('common_member')." WHERE username='{$_GET[other_side]}'");
	if(empty($user['uid'])) showmessage($lang[68]);
	if($_G['uid']==$user['uid']) showmessage($lang[69]);
	$data = array(
	'id'=>NULL,
	'uid'=>$_G['uid'],
	'other_side'=>$user['uid'],
	'message'=>$_GET['message'],
	'contact'=>serialize($_GET['contact']),
	'status'=>1,
	'price'=>intval($_GET['price']),
	'mold'=>intval($_GET['mold']),
	'deduct_type'=>intval($_GET['deduct_type']),
	'trade_type'=>intval($_GET['trade_type']),
	'applytime'=>$_G['timestamp']
	);
	$op = DB::insert('csu_guarantee',$data,1);
	if($op) showmessage($lang[70],'plugin.php?id=csu_guarantee&item=detail&gid='.$op);
}
//WWW.fx8.cc
?>