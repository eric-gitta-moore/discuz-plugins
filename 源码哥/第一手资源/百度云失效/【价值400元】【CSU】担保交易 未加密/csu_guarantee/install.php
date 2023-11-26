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
CREATE TABLE IF NOT EXISTS `cdb_csu_guarantee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `other_side` int(7) NOT NULL,
  `message` text NOT NULL,
  `contact` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `price` int(5) NOT NULL,
  `deduct_type` tinyint(1) NOT NULL,
  `mold` int(3) NOT NULL,
  `applytime` int(11) NOT NULL,
  `trade_type` tinyint(1) NOT NULL DEFAULT '0',
  `other_contact` text NOT NULL,
  `reply` text NOT NULL,
  `send` text NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=7 ;
EOF;
runquery($sql);
$finish = true;
?>
