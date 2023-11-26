<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$keke_group_orderlog= DB::table("keke_group_orderlog");
$keke_group= DB::table("keke_group");
$sql = <<<EOF
DROP TABLE IF EXISTS `$keke_group_orderlog`;
DROP TABLE IF EXISTS `$keke_group`;

EOF;

runquery($sql);
$finish = true;
?>
