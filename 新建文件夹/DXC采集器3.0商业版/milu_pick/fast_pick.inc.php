<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
pload('F:fastpick,F:copyright,F:output');
$header_config = array('fastpick_manage', 'fastpick_add', 'fastpick_import' , 'fastpick_share','fastpick_set', 'fastpick_evo', 'fastpick_evo_log');
$head_url = '?'.PICK_GO.'fast_pick&myac=';
$myac = $_GET['myac'];
$tpl = $_GET['tpl'];
if(empty($myac)) $myac = 'fastpick_manage';
if($myac == 'fastpick_add'){
	$myac = 'fastpick_edit';
	
}else if($myac == 'fastpick_del'){
	$tpl = 'no';
}
if($_GET['id']) $header_config[1] = $myac;

if(function_exists($myac)) $info = $myac();
$mytemp = $_REQUEST['mytemp'] ? $_REQUEST['mytemp'] : $myac;

if(!$tpl && $tpl!= 'no') include template('milu_pick:'.$mytemp);
?>