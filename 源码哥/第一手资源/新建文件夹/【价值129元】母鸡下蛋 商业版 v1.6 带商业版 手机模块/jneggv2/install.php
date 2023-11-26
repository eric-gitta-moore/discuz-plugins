<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

CREATE TABLE IF NOT EXISTS `pre_game_jneggv2_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `acdo` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pre_game_jneggv2_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `jidan` int(11) NOT NULL,
  `jindan` int(11) NOT NULL,
  `chicken` int(11) NOT NULL,
  `luck` int(11) NOT NULL,
  `jointime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pre_game_jneggv2_chicken` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `chickenqty` int(11) NOT NULL,
  `buytime` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `other` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

EOF;

runquery($sql);

$finish = TRUE;
//From:QQ 25 75 163 778  Www.fx8.cc
?>