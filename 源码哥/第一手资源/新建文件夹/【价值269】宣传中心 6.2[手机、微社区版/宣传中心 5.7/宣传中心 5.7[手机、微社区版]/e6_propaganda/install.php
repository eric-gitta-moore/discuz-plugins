<?php

if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `pre_e6_pro_clientorder` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `orderid` char(32) NOT NULL,
  `pay` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL,
  `price` decimal(6,2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `date` (`date`)
) ENGINE=MyISAM;

INSERT INTO `pre_e6_pro_clientorder` SET `date`='{$_G['timestamp']}';

CREATE TABLE IF NOT EXISTS `pre_e6_pro_credit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `logtype` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `smoney` int(10) unsigned NOT NULL DEFAULT '0',
  `emoney` int(10) unsigned NOT NULL DEFAULT '0',
  `change` mediumint(6) NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL,
  `describe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_e6_pro_finance` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(15) NOT NULL,
  `money` mediumint(6) unsigned NOT NULL,
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `feemoney` smallint(5) unsigned NOT NULL,
  `feetype` tinyint(2) unsigned NOT NULL,
  `ok` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `okdate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_e6_pro_task` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  `participate` smallint(5) unsigned NOT NULL,
  `complete` smallint(5) unsigned NOT NULL,
  `claim` tinyint(1) unsigned NOT NULL,
  `claim1` smallint(5) unsigned NOT NULL,
  `claim2` smallint(5) unsigned NOT NULL,
  `reward` tinyint(1) unsigned NOT NULL,
  `reward1` smallint(5) unsigned NOT NULL,
  `reward2` smallint(5) unsigned NOT NULL,
  `grouplimit` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_e6_pro_task_list` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL,
  `value` mediumint(8) NOT NULL,
  `taskid` smallint(5) unsigned NOT NULL,
  `ok` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`taskid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_e6_pro_user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `region` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vip` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `fuid1` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid2` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid3` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid4` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid5` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid6` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid7` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid8` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid9` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fuid10` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `activation1` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `activation2` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `activation3` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `activation4` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `activation5` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `activation6` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `activation7` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `activation8` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `activation9` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `activation10` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_e6_pro_user_count` (
  `uid` mediumint(8) unsigned NOT NULL,
  `withdraw` mediumint(8) unsigned NOT NULL,
  `ip` smallint(5) unsigned NOT NULL,
  `register` smallint(5) unsigned NOT NULL,
  `money` mediumint(8) unsigned NOT NULL,
  `task` smallint(4) unsigned NOT NULL,
  `paymoney` decimal(8,2) unsigned NOT NULL,
  `area` smallint(5) unsigned NOT NULL,
  `upvip` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_e6_pro_visit` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `ip` (`ip`),
  KEY `date` (`date`)
) ENGINE=MyISAM;
SQL;
runquery($sql);
if (file_exists(DISCUZ_ROOT . "data/e6_propaganda.config.php")) {
	include DISCUZ_ROOT . "data/e6_propaganda.config.php";
	C::t('common_setting')->update_batch(array('e6_propaganda' => serialize(daddslashes($e6_propaganda))));
	updatecache('setting');
	@unlink(DISCUZ_ROOT . '/data/e6_propaganda.config.php');
}
if (file_exists(DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php')) {
	$pluginid = 'e6_propaganda';
	$Hooks = array(
		'forumdisplay_sideBar',
		'forumdisplay_topBar',
	);
	$data = array();
	foreach ($Hooks as $Hook) {
		$data[] = array($Hook => array('plugin' => $pluginid, 'include' => 'api.class.php', 'class' => $pluginid . '_api', 'method' => $Hook));
	}
	require_once DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';
	$e6_wechat = new WeChatHook;
	if (method_exists($e6_wechat, 'updateAPIHook')) {
		WeChatHook::updateAPIHook($data);
	}
}
$finish = TRUE;
?>