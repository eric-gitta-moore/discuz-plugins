<?php
/*

 */


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$table1 = DB::table("keke_chongzhi_orderlog");
$sql = <<<EOF
DROP TABLE IF EXISTS `$table1`;
EOF;

runquery($sql);
$finish = true;
?>
?>