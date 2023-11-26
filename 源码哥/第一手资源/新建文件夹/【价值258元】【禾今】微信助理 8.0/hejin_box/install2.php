<?php
/*
 * 出处：源码哥
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}



$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `cdb_hjbox_buttons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT '0',
  `type` tinyint(2) DEFAULT '1',
  `title` varchar(1000) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `yuliua` int(11) DEFAULT NULL,
  `yuliub` int(11) DEFAULT NULL,
  `yuliuc` varchar(1000) DEFAULT NULL,
  `yuliud` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
EOF;
runquery($sql);

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `cdb_hjbox_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `text` varchar(1000) DEFAULT NULL,
  `pic` varchar(1000) DEFAULT NULL,
  `content` text,
  `clicks` int(11) NOT NULL DEFAULT '0',
  `shares` int(11) NOT NULL DEFAULT '0',
  `password` varchar(100) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `add_time` int(11) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `istj` tinyint(1) NOT NULL DEFAULT '0',
  `yuliua` int(11) DEFAULT NULL,
  `yuliub` int(11) DEFAULT NULL,
  `yuliuc` int(11) DEFAULT NULL,
  `yuliud` varchar(1000) DEFAULT NULL,
  `yuliue` varchar(1000) DEFAULT NULL,
  `yuliuf` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
EOF;
runquery($sql);

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `cdb_hjbox_replys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `pic` varchar(1000) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '0',
  `is_openid` tinyint(1) NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL,
  `yuliua` int(11) DEFAULT NULL,
  `yuliub` int(11) DEFAULT NULL,
  `yuliuc` int(11) DEFAULT NULL,
  `yuliud` varchar(1000) DEFAULT NULL,
  `yuliue` varchar(1000) DEFAULT NULL,
  `yuliuf` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
EOF;
runquery($sql);


$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `cdb_hjbox_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(1000) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `city` varchar(1000) DEFAULT NULL,
  `country` varchar(1000) DEFAULT NULL,
  `province` varchar(1000) DEFAULT NULL,
  `headimgurl` varchar(1000) DEFAULT NULL,
  `is_gz` tinyint(1) NOT NULL DEFAULT '1',
  `openid` varchar(1000) NOT NULL,
  `telphone` varchar(100) DEFAULT NULL,
  `bbsuid` int(11) DEFAULT NULL,
  `gztime` int(11) NOT NULL,
  `yuliua` int(11) DEFAULT NULL,
  `yuliub` int(11) DEFAULT NULL,
  `yuliuc` int(11) DEFAULT NULL,
  `yuliud` varchar(1000) DEFAULT NULL,
  `yuliue` varchar(1000) DEFAULT NULL,
  `yuliuf` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
EOF;
runquery($sql);

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `cdb_hjbox_wfl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(1000) NOT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `pic` varchar(1000) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `isshow` tinyint(4) NOT NULL DEFAULT '1',
  `listid` int(11) NOT NULL DEFAULT '1',
  `showid` int(11) NOT NULL DEFAULT '1',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `yuliua` int(11) DEFAULT NULL,
  `yuliub` int(11) DEFAULT NULL,
  `yuliuc` int(11) DEFAULT NULL,
  `yuliud` varchar(1000) DEFAULT NULL,
  `yuliue` varchar(1000) DEFAULT NULL,
  `yuliuf` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
EOF;
runquery($sql);

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `cdb_hjbox_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` text,
  `cj_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
EOF;
runquery($sql);



$finish = TRUE;
?>
