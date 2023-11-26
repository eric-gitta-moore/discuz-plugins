<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
pload('F:seo,F:copyright,F:output');
$head_url = '?'.PICK_GO.'seo&myac=';
$myac = $_GET['myac'];
$tpl = $_GET['tpl'];
if(empty($myac)) $myac = 'seo_set';
if(function_exists($myac)) $info = $myac();
$mytemp = $_REQUEST['mytemp'] ? $_REQUEST['mytemp'] : $myac;
if(!$tpl && $tpl!= 'no') include template('milu_pick:'.$mytemp);
?>