<?php
/*
 * 出处：源码哥
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}



$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `cdb_hjbox_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` text,
  `cj_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
EOF;
runquery($sql);



$finish = TRUE;
?>