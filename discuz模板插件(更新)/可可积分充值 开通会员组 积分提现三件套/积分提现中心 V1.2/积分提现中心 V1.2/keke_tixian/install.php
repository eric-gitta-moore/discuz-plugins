<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$keke_tixian= DB::table("keke_tixian");
$keke_tixian_card= DB::table("keke_tixian_card");
$keke_tixian_credit= DB::table("keke_tixian_credit");
$sql = <<<EOF
CREATE TABLE `$keke_tixian` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(10) unsigned NOT NULL,
  `usname` varchar(255) NOT NULL,
  `money` int(32) NOT NULL,
  `credit` int(50) unsigned NOT NULL,
  `credittype` int(10) NOT NULL,
  `cardtype` varchar(255) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
   `cardon` char(32) NOT NULL,
  `state` int(32) NOT NULL,
  `cardname` varchar(80) NOT NULL,
  `tuiyuanyin` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

CREATE TABLE `$keke_tixian_credit` (
  `creditid` int(10) unsigned NOT NULL,
  `bili` int(50) NOT NULL,
  `min` float(50,2) NOT NULL,
  `max` float(50,2) unsigned NOT NULL,
  `state` int(10) NOT NULL,
  `sxf` int(10) NOT NULL,
  PRIMARY KEY  (`creditid`)
) ENGINE=MyISAM;

CREATE TABLE `$keke_tixian_card` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(10) unsigned NOT NULL,
  `usname` varchar(255) NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `bank` int(10) NOT NULL,
  `cardon` char(32) NOT NULL,
  PRIMARY KEY `id` (`id`)
) ENGINE=MyISAM;

EOF;
runquery($sql);
$finish = true;
?>