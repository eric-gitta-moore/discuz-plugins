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
$var = $_G['cache']['plugin']['csu_guarantee'];
@include_once ('function.php');
$kuaidi = '<select name="contact[send]">';
$kuaidilist = explode("\r\n",$var['express']);
foreach ($kuaidilist as $kuaidis){
	$kuaidi .= '<option value="'.$kuaidis.'">'.$kuaidis.'</option>
';
}
$kuaidi .= "</select>";
$salemoneylist = explode("\r\n",$var['salemoney']);
foreach ($salemoneylist as $salemoneys){
	$salemoney .= '<option value="'.$salemoneys.'">'.$salemoneys.'</option>
';
}
if(!$_G['uid']) showmessage($lang[37],"member.php?mod=logging&action=login");
if(!in_array($_G['groupid'],unserialize($var['groups']))) showmessage($lang[38]);
$order = DB::fetch_first("SELECT * FROM ".DB::table('csu_guarantee')." WHERE id=".$_GET['gid']);
$other = getuserbyuid($order['other_side']);
if($order['status'] == 0) showmessage($lang[39]);
if($order['uid']==$_G['uid']){
	$include = 'uid';
}elseif($order['other_side']==$_G['uid']) {
	$include = 'oside';
}else showmessage($lang[40]);
$buyandsell = bas($order);
$price = dealprice($order['price'],$order['deduct_type']);
include template('csu_guarantee:window_header');
if($_GET['status']!=6) include template('csu_guarantee:window_'.$include.'_'.$_GET['status'].'_'.$order['trade_type']);
else include template('csu_guarantee:window_6');
include template('csu_guarantee:window_footer');
?>