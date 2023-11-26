<?php
/**
 *	[(levrobot.install)] (C)2013-2099 Powered by www.moqu8.com.
 *	Version: 1.0.0
 *	Date: 2013-5-19 16:01
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_lev_ckplayer`;
CREATE TABLE `pre_lev_ckplayer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `bbsname` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `vdtype` varchar(255) NOT NULL,
  `imgsrc` varchar(255) NOT NULL,
  `videourl` varchar(255) NOT NULL,
  `sectime` varchar(255) NOT NULL,
  `vdfix` varchar(255) NOT NULL,
  `isvip` int(10) NOT NULL DEFAULT '0',
  `price` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `hitnum` int(10) NOT NULL DEFAULT '0',
  `cmnum` int(10) NOT NULL DEFAULT '0',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `contents` text,
  `settings` text,
  `uptime` int(10) NOT NULL DEFAULT '0',
  `addtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `pre_lev_ckplayer_group`;
CREATE TABLE `pre_lev_ckplayer_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `bbsname` varchar(255) NOT NULL,
  `gname` varchar(255) NOT NULL,
  `videoids` varchar(255) NOT NULL,
  `contents` text,
  `settings` text,
  `isopen` int(10) NOT NULL DEFAULT '0',
  `uptime` int(10) NOT NULL DEFAULT '0',
  `addtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `pre_lev_ckplayer_zj`;
CREATE TABLE `pre_lev_ckplayer_zj` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `groupid` int(10) NOT NULL DEFAULT '0',
  `videoid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `pre_lev_ckplayer_tanmu`;
CREATE TABLE `pre_lev_ckplayer_tanmu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `videoid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `bbsname` varchar(255) NOT NULL,
  `descs` varchar(255) NOT NULL,
  `contents` text,
  `formhash` varchar(255) NOT NULL,
  `clientip` varchar(255) NOT NULL,
  `addtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

EOF;

runquery($sql);
$finish = true;
?>