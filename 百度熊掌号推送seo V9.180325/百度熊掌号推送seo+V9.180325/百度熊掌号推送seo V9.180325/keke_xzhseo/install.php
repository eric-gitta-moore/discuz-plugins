<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$keke_xzhseo= DB::table("keke_xzhseo");
$sql = <<<EOF
CREATE TABLE `$keke_xzhseo` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `time` int(20) NOT NULL,
  `type` int(10) NOT NULL,
  `mods` int(20) NOT NULL,
  `atid` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `atid` USING BTREE (`id`,`atid`)
) ENGINE=MyISAM;

EOF;
runquery($sql);
$finish = true;
