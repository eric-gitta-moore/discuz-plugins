<?php
/**
 * 
 * 魔趣吧出品 必属精品
 * 魔趣吧源码论坛 全网首发 http://WWW.moqu8.com
 * 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 * 感谢支持！您的支持是我们最大的动力！永久免费下载本站所有资源！
 * 欢迎大家来访获得最新更新的优秀资源！更多VIP特色资源不容错过！！
 * 魔趣吧用户交流群: ①群626530746
 * 永久域名：http://www.moqu8.com/ (请收藏备用!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<eof
CREATE TABLE IF NOT EXISTS `pre_lev_ckplayer` (
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

CREATE TABLE IF NOT EXISTS `pre_lev_ckplayer_group` (
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

CREATE TABLE IF NOT EXISTS `pre_lev_ckplayer_zj` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `groupid` int(10) NOT NULL DEFAULT '0',
  `videoid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_lev_ckplayer_tanmu` (
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

eof;

runquery($sql);

$finish = true;
?>