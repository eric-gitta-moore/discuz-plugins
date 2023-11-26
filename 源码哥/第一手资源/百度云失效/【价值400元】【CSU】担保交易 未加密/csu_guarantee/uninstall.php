<?php
/**
 *      DEV Team:fx8.cc    Author:QQ 2575 163 778
 *      (C)2014-2017
 *      This is NOT a freeware, use is subject to license terms
 *      Offical Website:www.ymg6.com
 *		Blog:www.FX8.vip
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_csu_guarantee`;
EOF;
runquery($sql);
$finish = true;
?>
