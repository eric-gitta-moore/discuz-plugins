<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
$header_config = array('fastpick_manage', 'fastpick_add', 'fastpick_import', 'fastpick_share');
$head_url = '?'.PICK_GO.'system_rules&myac=';
pload('F:rules,F:pick,F:copyright,F:output');
$myac = str_replace('fastpick', 'rules', $_GET['myac']);
$tpl = $_GET['tpl'];
if(empty($myac)) $myac = 'rules_list';
if($myac == 'rules_add'){
	$myac = 'rules_edit';
	
}else if($myac == 'rules_del'){
	$tpl = 'no';
}else if($myac == 'rules_manage'){
	$myac = 'rules_list';
	
}
if(function_exists($myac)) $info = $myac();
$mytemp = $_REQUEST['mytemp'] ? $_REQUEST['mytemp'] : $myac;
if(!$tpl && $tpl!= 'no') include template('milu_pick:'.$mytemp);
?>