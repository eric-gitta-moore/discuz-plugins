<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$settingfile = DISCUZ_ROOT . './data/sysdata/cache_ljdaka_setting.php';
if(file_exists($settingfile)){
	unlink($settingfile);
}
$sql = <<<EOF
drop table IF EXISTS `pre_plugin_daka`;
drop table IF EXISTS `pre_plugin_daka_thread`;
drop table IF EXISTS `pre_plugin_daka_user`;
drop table IF EXISTS `pre_plugin_daka_syscache`;
drop table IF EXISTS `pre_plugin_daka_user_y`;
drop table IF EXISTS `pre_plugin_daka_user_z`;
EOF;
runquery($sql);
$finish = TRUE;
?>