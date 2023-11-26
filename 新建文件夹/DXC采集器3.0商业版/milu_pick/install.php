<?php
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 20324 2011-02-21 09:35:00Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	//exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
$sql_file = DISCUZ_ROOT.'/source/plugin/milu_pick/data/data.sql';
$handle = fopen($sql_file, "r");
$sql = fread($handle, filesize($sql_file));
$tablepre = !empty($_G['config']['db'][1]['tablepre']) ? $_G['config']['db'][1]['tablepre'] : 'pre_';
if(GBK){
	$sql = str_replace('DEFAULT CHARSET=gbk','DEFAULT CHARSET=utf8', $sql);
}else{
	$sql = str_replace('DEFAULT CHARSET=utf8','DEFAULT CHARSET=gbk', $sql);
}
$sql = str_replace('pre_strayer', 'cdb_strayer', $sql);
$sql = preg_replace("'\/\*.*?\*\/'si", "", $sql);
runquery($sql);
$finish = TRUE;
?>