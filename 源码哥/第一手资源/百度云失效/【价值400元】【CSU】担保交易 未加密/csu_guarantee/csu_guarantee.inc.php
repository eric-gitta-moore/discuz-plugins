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
@include_once ('function.php');
$arr = array();
$var = $_G['cache']['plugin']['csu_guarantee'];
$navtitle = $var['title'];
$metakeywords = $var['keywords'];
$metadescription = $var['description'];
$salemoneylist = explode("\r\n",$var['salemoney']);
foreach ($salemoneylist as $salemoneys){
	$salemoney .= '<option value="'.$salemoneys.'">'.$salemoneys.'</option>
';
}
$_GET['item'] = $_GET['item'] ? $_GET['item'] : "default";
if(!$_G['uid']) showmessage($lang[37],"member.php?mod=logging&action=login");
if(!in_array($_G['groupid'],unserialize($var['groups']))) showmessage($lang[38]);
@include_once ('include/'.$_GET['item'].'.php');
include template('csu_guarantee:header');
include template('csu_guarantee:'.$_GET['item']);
include template('csu_guarantee:footer');
?>