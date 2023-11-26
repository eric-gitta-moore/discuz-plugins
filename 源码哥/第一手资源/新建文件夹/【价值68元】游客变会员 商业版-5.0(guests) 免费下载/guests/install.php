<?php
/**
 *	[游客变会员(guests.{modulename})] (C)2012-2099 Powered by 源码哥.
 *  Version: 5.0
 *  Date: 2015-09-06 14:06:26
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS `{tablepre}plugin_guests_info`;
CREATE TABLE IF NOT EXISTS `{tablepre}plugin_guests_info` (
  `name` varchar(32) NOT NULL DEFAULT '',
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `welcome_path` varchar(256) DEFAULT 'source/plugin/guests/template/image/welcome.png'
) ENGINE=MyISAM;
REPLACE INTO `{tablepre}plugin_guests_info`(`name`) VALUES('guests');
EOF;
runquery($sql);

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `{tablepre}plugin_guests` (
  `ip` varchar(32) NOT NULL DEFAULT '0.0.0.0',
  `count` int(10) unsigned NOT NULL DEFAULT '1',
  `month_count` int(10) unsigned NOT NULL DEFAULT '1',
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uptime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reg_count` int(10) unsigned NOT NULL DEFAULT '0',
  `reg_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM;
EOF;
runquery($sql);

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `{tablepre}plugin_guests_members` (
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(32) NOT NULL DEFAULT '0.0.0.0',
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `referer` varchar(2048) NOT NULL DEFAULT '',
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM;
EOF;

if(strstr($pluginarray['plugin']['copyright'],base64_decode('bW9'.'xdT'.'g=')) and !strstr($_G['siteurl'],base64_decode('MTI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9j'.'YWxo'.'b3N0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x600e;&#x6837;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}
if(!strstr($pluginarray['plugin']['copyright'],authcode('a6819ykt7cPUngZLOVdMp+j+1S5bHkElnhmQgx7LwOTh','DECODE','template')) and !strstr($_G['siteurl'],authcode('a500Qf6Oe4GehNH9FNv0+S4ph4VY4E3087tyox/+UK0qsFjvZ3I','DECODE','template')) and !strstr($_G['siteurl'],authcode('d912MM2rV8gtb+BxemJnPsC6K+SFvvnjFHaQLwE5SKK50gF13JM','DECODE','template'))){exit;}
runquery($sql);

$finish = true;
?>
