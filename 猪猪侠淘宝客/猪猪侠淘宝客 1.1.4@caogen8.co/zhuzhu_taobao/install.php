<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 37712 2017-12-10 19:29:36Z Вн-Иљ-АЩ $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_zhuzhu_taobao_brand`;
CREATE TABLE `pre_zhuzhu_taobao_brand` (
  `brand_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` tinyint(3) NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `banner` varchar(100) NOT NULL,
  `big_banner` varchar(100) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`brand_id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `pre_zhuzhu_taobao_cat`;
CREATE TABLE `pre_zhuzhu_taobao_cat` (
  `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `tb_cat` int(10) unsigned NOT NULL,
  `tb_key` varchar(100) NOT NULL,
  `available` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `pre_zhuzhu_taobao_category`;
CREATE TABLE `pre_zhuzhu_taobao_category` (
  `category_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `upid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `pic` varchar(255) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `available` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM;

EOF;

runquery($sql);

$finish = TRUE;

?>