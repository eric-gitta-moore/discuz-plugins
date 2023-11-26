<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = <<<EOT
DROP TABLE IF EXISTS pre_game_jneggv2_log;
DROP TABLE IF EXISTS pre_game_jneggv2_user;
DROP TABLE IF EXISTS pre_game_jneggv2_chicken;

EOT;

runquery($sql);

$finish = true;
?>
