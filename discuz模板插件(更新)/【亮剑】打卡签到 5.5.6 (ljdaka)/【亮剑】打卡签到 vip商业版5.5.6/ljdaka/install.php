<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_plugin_daka` (
  `id` int(10) NOT NULL auto_increment,
  `uid` int(10) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `jinbi` int(10) NOT NULL,
  `alldays` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `timestamp` (`timestamp`)
)
EOF;

runquery($sql);
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_plugin_daka_thread` (
  `tid` int(10) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`tid`)
)
EOF;
runquery($sql);
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_plugin_daka_user` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `allday` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `day` int(11) NOT NULL,
  `fen` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `allday` (`allday`),
  KEY `money` (`money`),
  KEY `timestamp` (`timestamp`)
)
EOF;
runquery($sql);
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_plugin_daka_syscache` (
  `id` int(11) NOT NULL auto_increment,
  `plugin_b` varchar(255) NOT NULL,
  `plugin_w` mediumtext NOT NULL,
  `plugin_sign` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
)
EOF;
runquery($sql);
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_plugin_daka_user_y` (
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `yueday` int(11) NOT NULL,
  `yuemoney` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `timestamp` (`timestamp`),
  KEY `yuemoney` (`yuemoney`)
)
EOF;
runquery($sql);
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_plugin_daka_user_z` (
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `zhouday` int(11) NOT NULL,
  `zhoumoney` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `timestamp` (`timestamp`),
  KEY `zhoumoney` (`zhoumoney`)
)
EOF;
runquery($sql);
if(file_exists(DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php')){
	$pluginid = 'ljdaka';
	$Hooks = array(
		'forumdisplay_mobilesign',
	);
	$data = array();
	foreach ($Hooks as $Hook) {
		$data[] = array($Hook => array('plugin' => $pluginid, 'include' => 'api.class.php', 'class' => $pluginid . '_api', 'method' => $Hook));
	}
	require_once DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';
	WeChatHook::updateAPIHook($data);
}
//finish to put your own code
$finish = TRUE;
?>