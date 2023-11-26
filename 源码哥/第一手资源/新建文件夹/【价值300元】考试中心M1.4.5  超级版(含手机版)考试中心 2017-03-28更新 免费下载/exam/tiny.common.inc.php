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

require_once 'tiny.function.inc.php';
 
if(!empty($_POST) && $_POST['formhash'] != formhash()){
	showmessage('ERROR SUBMIT!');
	exit;
}
 
$config   = $_G['cache']['plugin']['exam'];
$config['updir']    = 'source/plugin/exam/upload/';
$template = empty($config['template']) ? ($_G['charset']=='utf-8' ? 'default_utf8' : 'default') : trim($config['template']);
$config['groupuse'] = unserialize($config['groupuse']);  if(!$config['groupuse'][0]) unset( $config['groupuse'][0] );
$config['groupadd'] = unserialize($config['groupadd']);  if(!$config['groupadd'][0]) unset( $config['groupadd'][0] );
$config['groupfree']= unserialize($config['groupfree']); if(!$config['groupfree'][0])unset( $config['groupfree'][0]);
$config['extcredit']= $_G['setting']['extcredits'][$config['credit']]; $config['extcredit']['field'] = empty($config['credit']) ? '' : 'extcredits' . $config['credit'];
$config['welcome']  = trim($config['welcome']);
$config['mobiad']   = trim($config['mobiad']);
$config['showscore'] = intval($config['showscore']);
 
$COLOR = array('none', '#EE5023', '#2897C5', '#996600', '#3C9D40', '#2B65B7', '#EC1282', '#8F2A90', '#FF0000');
 
if($config['rewrite']){
	$indexurl = 'exam.html';
	$paperurl = 'exam';
	$testrurl = 'test';
	$listurl  = 'list';
}else{
	$indexurl = 'plugin.php?id=exam';
	$paperurl = 'plugin.php?id=exam&paper=';
	$testrurl = 'plugin.php?id=exam&test=';
	$listurl  = 'plugin.php?id=exam&list=';
}

 
$mobiurl = $_G['siteurl'] . ($config['rewrite'] ? 'm' : 'plugin.php?id=exam:m');
$_G['setting']['footernavs']['mobile']['code'] = "<a href=\"$mobiurl\" >&#x624B;&#x673A;&#x7248;</a>";
