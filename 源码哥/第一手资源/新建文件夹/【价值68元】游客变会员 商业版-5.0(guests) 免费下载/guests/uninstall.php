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
DROP TABLE IF EXISTS `{tablepre}plugin_guests`;
DROP TABLE `{tablepre}plugin_guests_info`;
DROP TABLE `{tablepre}plugin_guests_members`;
EOF;
runquery($sql);

$finish = true;
?>
