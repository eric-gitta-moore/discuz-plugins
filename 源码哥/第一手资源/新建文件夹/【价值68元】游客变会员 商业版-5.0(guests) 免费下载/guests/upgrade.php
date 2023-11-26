<?php
/**
 *	[游客变会员(guests.{modulename})] (C)2012-2099 Powered by 源码哥.
 *  Version: 5.0
 *  Date: 2015-09-06 14:06:26
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$fromversion = $_GET['fromversion'];
if ($fromversion < 3.0) {
	$query = DB::query("DESCRIBE `".DB::table('plugin_guests_info')."` `welcome_path`");
	if (!DB::fetch($query)) {
		$sql = <<<EOF
DELETE FROM `{tablepre}plugin_guests_info`;
ALTER TABLE `{tablepre}plugin_guests_info` ADD `welcome_path` varchar(256) DEFAULT 'source/plugin/guests/template/image/welcome.png';
REPLACE INTO `{tablepre}plugin_guests_info`(`name`) VALUES('guests');
EOF;
		runquery($sql);
	}
	$sql = <<<EOF
ALTER TABLE `{tablepre}plugin_guests_info` ADD PRIMARY KEY(`name`);	
EOF;
	runquery($sql);
}
$finish = true;
?>
