<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$keke_tixian= DB::table("keke_tixian");
$keke_tixian_card= DB::table("keke_tixian_card");
$keke_tixian_credit= DB::table("keke_tixian_credit");
$sql = <<<EOF
DROP TABLE IF EXISTS `$keke_tixian`;
DROP TABLE IF EXISTS `$keke_tixian_card`;
DROP TABLE IF EXISTS `$keke_tixian_credit`;
EOF;

runquery($sql);
$finish = true;
?>