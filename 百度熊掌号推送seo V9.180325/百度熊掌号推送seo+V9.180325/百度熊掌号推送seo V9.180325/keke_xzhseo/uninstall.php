<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$keke_xzhseo= DB::table("keke_xzhseo");
$sql = <<<EOF
DROP TABLE IF EXISTS `$keke_xzhseo`;
EOF;
runquery($sql);
$finish = true;