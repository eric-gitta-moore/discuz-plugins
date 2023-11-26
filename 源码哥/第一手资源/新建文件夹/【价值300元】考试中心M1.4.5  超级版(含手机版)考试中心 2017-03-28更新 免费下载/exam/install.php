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

$sql = <<<EOF

 
CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_buy` (
  `bid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;



CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_cate` (
  `cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ucid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT '',
  `icon` varchar(125) DEFAULT '',
  `paper_count` mediumint(8) unsigned DEFAULT '0',
  `exam_count` int(10) unsigned DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `last` varchar(255) DEFAULT '',
  PRIMARY KEY (`cid`,`ucid`,`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;



CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_exam` (
  `eid` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `gid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` mediumint(3) NOT NULL DEFAULT '0',
  `subject` text NOT NULL,
  `result` varchar(26) NOT NULL DEFAULT '',
  `data` text NOT NULL,
  `note` text NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `count_right` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `count_wrong` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`eid`,`pid`,`cid`,`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;



CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_group` (
  `gid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(80) NOT NULL DEFAULT '',
  `sort` mediumint(3) unsigned NOT NULL DEFAULT '0',
  `score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `num_max` mediumint(3) DEFAULT NULL,
  `content` text NOT NULL,
  `assoc` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`gid`,`pid`,`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;



CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_log` (
  `lid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(8) unsigned NOT NULL DEFAULT '0',
  `pid` int(8) unsigned NOT NULL DEFAULT '0',
  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `score` decimal(4,1) unsigned NOT NULL DEFAULT '0.0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `commenttime` int(10) unsigned NOT NULL DEFAULT '0',
  `total` decimal(5,1) NOT NULL DEFAULT '0.0',
  `comment` varchar(255) NOT NULL DEFAULT '',
  `userinfo` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`lid`,`uid`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;



CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_log_exam` (
  `leid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eid` int(10) unsigned NOT NULL DEFAULT '0',
  `lid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(8) unsigned NOT NULL DEFAULT '0',
  `pid` int(8) unsigned NOT NULL DEFAULT '0',
  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `result` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `score` decimal(3,1) unsigned DEFAULT NULL,
  `score2` decimal(3,1) unsigned DEFAULT NULL,
  PRIMARY KEY (`leid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;



CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_paper` (
  `pid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL DEFAULT '',
  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fgid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT 'friend group',
  `username` varchar(15) NOT NULL DEFAULT '',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `edittime` int(10) unsigned DEFAULT '0',
  `content` text NOT NULL,
  `last_time` int(10) unsigned DEFAULT '0',
  `last_user` varchar(15) NOT NULL DEFAULT '',
  `pv` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `submit` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `minute` mediumint(6) unsigned DEFAULT NULL,
  `pass` mediumint(6) unsigned DEFAULT NULL,
  `pwd` varchar(6) NOT NULL DEFAULT '',
  `price` mediumint(6) unsigned DEFAULT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `color` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `delay` smallint(6) unsigned DEFAULT NULL,
  `twice` smallint(4) unsigned DEFAULT NULL,
  `stick` tinyint(1) NOT NULL DEFAULT '0',
  `wait` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `long` int(10) unsigned NOT NULL DEFAULT '0',
  `readgroup` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`,`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;


CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_upload` (
  `iid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `src` char(255) NOT NULL,
  `uptime` int(10) unsigned DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `eid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`iid`,`src`,`uid`,`eid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;


CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_wrong` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(8) unsigned NOT NULL DEFAULT '0',
  `pid` int(8) unsigned NOT NULL DEFAULT '0',
  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `sys_result` varchar(255) NOT NULL DEFAULT '',
  `user_result` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;
 
EOF;

runquery($sql);

$finish = TRUE;
?>