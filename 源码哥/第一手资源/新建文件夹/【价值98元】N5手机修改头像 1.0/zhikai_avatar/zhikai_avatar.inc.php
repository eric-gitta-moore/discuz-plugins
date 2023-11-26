<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
if( !defined('IN_DISCUZ') ) {
	exit('Access Denied');
}

include 'language/'.currentlang().'.php';
$plang = $language['php'];
$hlang = $language['html'];

if (!$_G['uid']) {
	showmessage($plang['001'],null,array(),array('login' =>1));
}

define('APP_ID','zhikai_avatar');
define('APP_DIR','source/plugin/'.APP_ID);
define('APP_URL',$_G['siteurl'].'plugin.php?id='.APP_ID);
define('CUR_PAGE','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$config = $_G['cache']['plugin'][APP_ID];
include 'common.func.php';
include 'core.inc.php';
//www-FX8-co
?>