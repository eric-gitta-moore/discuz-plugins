<?php
/*  V1.0
 *  FOR Discuz! X 
 *	ainuo design 
 *  QQÈº£º550494646
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) exit('Access Denied');

$sql = <<<EOF
DROP TABLE IF EXISTS `pre_qu_app`;
CREATE TABLE IF NOT EXISTS `pre_qu_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color_left` char(14) NOT NULL,
  `color_topword` char(14) NOT NULL,
  `color_topbg` char(14) NOT NULL,
  `color_topline` char(14) NOT NULL,
  `color_wordbottom` char(14) NOT NULL,
  `color_userbgcolor` char(14) NOT NULL,
  `color_link` char(14) NOT NULL,
  `f_post` tinyint(2) NOT NULL,
  `f_news` varchar(1000) NOT NULL,
  `f_quan` varchar(1000) NOT NULL,
  `f_tuwen` varchar(1000) NOT NULL,
  `f_qqzone` varchar(1000) NOT NULL,
  `f_weibo` varchar(1000) NOT NULL,
  `f_pbl` varchar(1000) NOT NULL,
  `f_bigpic` varchar(1000) NOT NULL,
  `f_video` varchar(1000) NOT NULL,
  `f_music` varchar(1000) NOT NULL,
  `f_trade` varchar(1000) NOT NULL,
  `f_poll` varchar(1000) NOT NULL,
  `f_activity` varchar(1000) NOT NULL,
  `f_debate` varchar(1000) NOT NULL,
  `f_reward` varchar(1000) NOT NULL,
  `f_zhineng` varchar(1000) NOT NULL,
  `f_wordnum` int(10) NOT NULL,
  `login_qq` varchar(100) NOT NULL,
  `login_weibo` varchar(100) NOT NULL,
  `login_weixin` varchar(100) NOT NULL,
  `leftnav` text NOT NULL,
  `cache_portal` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

DROP TABLE IF EXISTS `pre_qu_appnav`;
CREATE TABLE IF NOT EXISTS `pre_qu_appnav` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `color` char(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `disable` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=14 ;


DROP TABLE IF EXISTS `pre_qu_appquicknav`;
CREATE TABLE IF NOT EXISTS `pre_qu_appquicknav` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `color` char(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `disable` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=9 ;


INSERT INTO `pre_qu_app` (`id`, `color_left`, `color_topword`, `color_topbg`, `color_topline`, `color_wordbottom`, `color_userbgcolor`, `color_link`, `f_post`, `f_news`, `f_quan`, `f_tuwen`, `f_qqzone`, `f_weibo`, `f_pbl`, `f_bigpic`, `f_video`, `f_music`, `f_trade`, `f_poll`, `f_activity`, `f_debate`, `f_reward`, `f_zhineng`, `f_wordnum`, `login_qq`, `login_weibo`, `login_weixin`, `leftnav`, `cache_portal`) VALUES
(1, '', '', '', '', '', '', '', 0, 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 'a:1:{i:0;s:1:"0";}', 80, 'connect.php?mod=login&op=init&referer=forum.php&statfrom=login_simple', '', 'plugin.php?id=wxconnect:wxlogin', '', 1800);

INSERT INTO `pre_qu_appnav` (`id`, `displayorder`, `title`, `pic`, `color`, `url`, `disable`) VALUES
(1, 1, '$installlang[index]', 'homefill', '#ff8040', 'forum.php', 1),
(2, 2, '$installlang[forum]', 'communityfill', '#0080c0', 'forum.php?forumlist=1', 1),
(3, 3, '$installlang[news]', 'newfill', '#7d00fb', 'portal.php?mod=list&amp;catid=1', 1),
(4, 4, '$installlang[group]', 'profilefill', '#bb1317', 'group.php', 1),
(7, 10, '$installlang[home]', 'tagfill', '#804000', 'misc.php?mod=tag', 1),
(6, 11, '$installlang[album]', 'samefill', '#400040', 'search.php?mod=forum', 1),
(8, 6, '$installlang[tag]', 'creativefill', '#408080', 'home.php', 1),
(11, 8, '$installlang[search]', 'camerafill', '#800040', 'home.php?mod=space&amp;do=album&amp;view=all', 1);


INSERT INTO `pre_qu_appquicknav` (`id`, `displayorder`, `title`, `pic`, `color`, `url`, `disable`) VALUES
(1, 1, '$installlang[video]', 'videofill', '#ff5402', 'forum.php?mod=post&action=newthread&fid=49', 1),
(2, 5, '$installlang[yuhuiba]', 'pengyouquan', '#ff80c0', 'forum.php?mod=forumdisplay&fid=73', 1),
(3, 6, '$installlang[qes]', 'picfill', '#4b91e4', 'home.php?mod=spacecp&ac=upload', 1),
(4, 7, '$installlang[zufang]', 'markfill', '#c8c417', 'home.php?mod=space&do=doing&view=me', 1),
(5, 2, '$installlang[qrcode]', 'likefill', '#c85837', 'forum.php?mod=forumdisplay&fid=72', 1),
(6, 8, '$installlang[faxiangce]', 'writefill', '#800080', 'plugin.php?id=qu_message:message', 1),
(7, 4, '$installlang[xieriji]', 'servicefill', '#00cccc', 'forum.php?mod=forumdisplay&fid=71', 1),
(8, 3, '$installlang[tiyijian]', 'qiang', '#18b620', 'forum.php?mod=forumdisplay&fid=74', 1);

EOF;
runquery($sql);

$finish = TRUE;
?>
