<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$installsql = <<<EOF
DROP TABLE IF EXISTS cdb_xiaomy_buyvipgroup;
CREATE TABLE IF NOT EXISTS `cdb_xiaomy_buyvipgroup` (
  `id`    int(11) unsigned NOT NULL auto_increment,
  `uid`     mediumint(8) unsigned  NOT NULL,
  `username` VARCHAR(30) NOT NULL DEFAULT '',
  `cyclecount` int(10) NOT NULL,
  `groupid` int(10) NOT NULL,
  `payrmb` float(7,2) NOT NULL,
  `payaccount` VARCHAR(100) NOT NULL DEFAULT '',
  `payment` VARCHAR(100) NOT NULL DEFAULT '',
  `tnumber` VARCHAR(100) NOT NULL DEFAULT '',
  `status` char(2)  NOT NULL,
  `dateline` int(10) DEFAULT NULL,
  `vdateline` int(10) DEFAULT NULL,
  PRIMARY KEY  (`id`),
  index in_uid(`uid`)
) ENGINE=MyISAM;
EOF;
runquery($installsql);
$finish = TRUE;
?>