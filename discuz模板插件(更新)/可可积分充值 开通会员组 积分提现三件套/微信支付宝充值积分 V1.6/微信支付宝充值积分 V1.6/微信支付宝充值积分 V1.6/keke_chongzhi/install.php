<?php
/*
 
 */


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$keke_chongzhi_orderlog= DB::table("keke_chongzhi_orderlog");
$keke_chongzhi_credit= DB::table("keke_chongzhi_credit");
$sql = <<<EOF
CREATE TABLE `$keke_chongzhi_orderlog` (
  `orderid` char(24) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `usname` varchar(255) NOT NULL,
  `money` int(32) NOT NULL,
  `credit` int(50) unsigned NOT NULL,
  `credittype` int(10) NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `state` int(10) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `zftime` int(10) unsigned NOT NULL,
  `sn` varchar(80) NOT NULL,
  `opid` char(32) NOT NULL,
  PRIMARY KEY  (`orderid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

CREATE TABLE `$keke_chongzhi_credit` (
  `creditid` int(10) unsigned NOT NULL,
  `bili` int(50) NOT NULL,
  `min` float(50,2) NOT NULL,
  `max` float(50,2) unsigned NOT NULL,
  `state` int(10) NOT NULL,
  `sxf` int(10) NOT NULL,
  `shunxu` int(10) NOT NULL,
  PRIMARY KEY  (`creditid`)
) ENGINE=MyISAM;

EOF;
runquery($sql);
$finish = true;
?>