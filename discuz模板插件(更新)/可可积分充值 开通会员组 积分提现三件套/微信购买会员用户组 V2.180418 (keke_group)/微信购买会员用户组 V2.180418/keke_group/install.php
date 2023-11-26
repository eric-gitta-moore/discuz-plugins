<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$keke_group_orderlog= DB::table("keke_group_orderlog");
$keke_group= DB::table("keke_group");
$sql = <<<EOF
CREATE TABLE `$keke_group_orderlog` (
  `orderid` char(24) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `usname` varchar(255) NOT NULL,
  `money` int(32) NOT NULL,
  `groupid` int(50) unsigned NOT NULL,
  `groupname` varchar(50) NOT NULL,
  `groupvalidity` int(10) NOT NULL,
  `groupinvalid` int(10) NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `state` int(10) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `zftime` int(10) unsigned NOT NULL,
  `sn` varchar(80) NOT NULL,
  `opid` char(32) NOT NULL,
  PRIMARY KEY  (`orderid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

CREATE TABLE `$keke_group` (
  `id` int(50) NOT NULL auto_increment,
  `groupid` char(24) NOT NULL,
  `groupname` varchar(100) NOT NULL,
  `ico` varchar(150) NOT NULL,
  `money` int(200) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `tequan` varchar(255) NOT NULL,
  `display` int(10) NOT NULL,
  `state` int(10) NOT NULL,
  `hot` int(10) NOT NULL,
  `give` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

EOF;
runquery($sql);
$finish = true;

?>