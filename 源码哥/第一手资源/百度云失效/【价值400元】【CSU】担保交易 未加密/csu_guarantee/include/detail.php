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
$rs = getorder("WHERE id =".$_GET['gid']);
$order = $rs[0];
if(!$order) showmessage($lang[71]);
if($order['uid']!=$_G['uid']&&$order['other_side']!=$_G['uid']&&!in_array($_G['groupid'],unserialize($var['admin']))) showmessage($lang[74]);
$price = dealprice($order['price'],$order['deduct_type']);
$buyandsell = bas($order);
$odop = orderop($order);
$start = getuserbyuid($order['uid']);
$reply = $order['reply'];
if(submitcheck('replynew')&&!empty($_GET['message'])){
	$_GET = daddslashes($_GET);
	if($order['status'] == 0 || $order['status'] == 7) showmessage($lang[72]);
	$i = $_G['timestamp'];
	$reply[$i]['message'] = $_GET['message'];
	$reply[$i]['uid'] = $_G['uid'];
	$update['reply'] = serialize(daddslashes($reply));
	if(DB::update('csu_guarantee',$update,array('id'=>intval($_GET['gid'])))) showmessage($lang[73],dreferer());
}
function reply(){
	global $reply,$var;
	$i = 1;
	foreach ($reply as $time=>$replys){
		$user = getuserbyuid($replys['uid']);
		$admin = in_array($replys['uid'],unserialize($var['admin'])) ? $lang[74] : '';
		echo '<div class="jy_con_rightb">
		  <h2><span style="float:right; font-weight:normal;">'.$admin.'<a href="home.php?mod=space&amp;uid='.$user['uid'].'" style="color:#3293BE" target="_blank">'.$user['username'].'</a>&nbsp;'.$lang[75].' '.date("Y-m-d H:i:s",$time).'&nbsp;</span>'.$i.$lang[76].'</h2>
		  <ul class="jy_a" >
					  '.dstripslashes($replys['message']).'<br>
		  </ul>';
		  $i++;
	}
}
//WWW.fx8.cc
?>